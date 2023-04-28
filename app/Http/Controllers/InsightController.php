<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\SaveInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InsightController extends Controller
{

    public function formatCsv(String $csvData)
    {
        $data = str_replace(array('[', ']'), '', $csvData);
        $result[] = new Insight();

        // split data by curly braces
        $lines = explode('{', $data);

        foreach ($lines as $line) {
            // remove closing curly brace and any trailing whitespace
            $line = rtrim($line, '} ');

            // split line by apostrophe character
            $parts = explode("'", $line);

            // extract data if parts array has the required indices
            if (count($parts) >= 8) {
                $text = trim($parts[1]);
                $price = trim($parts[3]);
                $store = trim($parts[5]);
                $loc_store = trim($parts[7]);

                $model = new Insight();
                $model->title = $text;
                $model->price = $price;
                $model->store = $store;
                $model->location = $loc_store;
                array_push($result, $model);
            }
        }
        return $result;
    }

    public static function toIdr($num)
    {
        $formattedNum = number_format($num, 0, ',', '.');
        return "Rp" . $formattedNum;
    }

    public static function processPrice($model)
    {
        $sortedPrice = [];
        foreach ($model as $value) {
            $price = (int) preg_replace("/[^0-9]/", "", $value->price);
            array_push($sortedPrice, $price);
        }
        sort($sortedPrice);
        array_shift($sortedPrice);

        return $sortedPrice;
    }

    public function scrapTokopedia(Request $request)
    {
        $scrapTitle = $request->inputValue;
        $pageNum = $request->dropdownValue + 1;

        $action = $request->input('action');
        $output = [];
        $return_var = 0;

        if ($action === 'csv') {
            exec("node node/tokopedia_csv.js '{$scrapTitle}' {$pageNum}", $output, $return_var);
            $csv_output = implode(PHP_EOL, $output);
            $model = InsightController::formatCsv($csv_output);
            return view('csv-view', ['model' => $model, 'scrapTitle' => $scrapTitle, 'csv_output' => $csv_output]);
        } else if ($action === 'json') {
            exec("node node/tokopedia_json.js '{$scrapTitle}' {$pageNum}", $output, $return_var);
            return view('json-view', ['productResult' => $output, 'scrapTitle' => $scrapTitle]);
        }
    }

    public static function getAverage($model)
    {
        $sortedPrice = InsightController::processPrice($model);
        $total = 0;
        foreach ($sortedPrice as $price) {
            $total += $price;
        }

        $average = $total / sizeof($model);

        return InsightController::toIdr($average);
    }


    public static function getMedian($model)
    {
        $sortedPrice = InsightController::processPrice($model);
        $count = sizeof($sortedPrice);
        $mid = floor(($count - 1) / 2);

        if ($count % 2) {
            $median = $sortedPrice[$mid];
        } else {
            $lo = $sortedPrice[$mid];
            $hi = $sortedPrice[$mid + 1];
            $median = ($lo + $hi) / 2;
        }

        return InsightController::toIdr($median);
    }

    public static function getRange($model)
    {
        $sortedPrice = InsightController::processPrice($model);
        $count = sizeof($sortedPrice);

        return InsightController::toIdr($sortedPrice[0]) . " - " . InsightController::toIdr($sortedPrice[$count - 1]);
    }

    public static function getQ1($model)
    {
        $sortedPrice = InsightController::processPrice($model);
        $count = sizeof($sortedPrice);
        $mid = floor(($count - 1) / 2);
        $lowerQuartile = InsightController::getMedian(array_slice($sortedPrice, 0, $mid));

        return InsightController::toIdr($lowerQuartile);
    }

    public static function getQ2($model)
    {
        $sortedPrice = InsightController::processPrice($model);
        $count = sizeof($sortedPrice);
        $mid = floor(($count - 1) / 2);
        $upperQuartile = InsightController::getMedian(array_slice($sortedPrice, $mid + 1));

        return InsightController::toIdr($upperQuartile);
    }

    public function saveCsvToDatabase(Request $request)
    {
        // Get the user ID and CSV data from the request
        $userId = Auth::id();
        $instanceId = Str::uuid()->toString();
        $csvData = $request->input('csv_data');
        $scrapTitle = $request->input('scrap_title');

        // Create a new instance of the CSV data and save it to the database
        $csvInstance = new SaveInstance();
        $csvInstance->user_id = $userId;
        $csvInstance->instance_id = $instanceId;
        $csvInstance->scrap_title = $scrapTitle;
        $csvInstance->save();

        $data = str_replace(array('[', ']'), '', $csvData);

        // split data by curly braces
        $lines = explode('{', $data);

        // loop through lines and extract data
        foreach ($lines as $line) {
            // remove closing curly brace and any trailing whitespace
            $line = rtrim($line, '} ');

            // split line by apostrophe character
            $parts = explode("'", $line);

            // extract data if parts array has the required indices
            if (count($parts) >= 8) {
                $text = trim($parts[1]);
                $price = trim($parts[3]);
                $store = trim($parts[5]);
                $loc_store = trim($parts[7]);

                $model = new Insight();
                $model->instance_id = $instanceId;
                $model->title = $text;
                $model->price = $price;
                $model->store = $store;
                $model->location = $loc_store;

                $model->save();
            }
        }

        // Redirect the user to the appropriate page
        return redirect()->route('home')->with('success', 'CSV data saved to database.');
    }

    public function getScrapHistory()
    {
        $instances = SaveInstance::with('scrapData')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('scrap-history', compact('instances'));
    }

    public function getScrapData($instance_id)
    {
        $scrapData = Insight::where('instance_id', $instance_id)->get();
        $scrapTitle = SaveInstance::where('instance_id', $instance_id)->firstOrFail()->scrap_title;
        $scrapCreated = SaveInstance::where('instance_id', $instance_id)->firstOrFail()->created_at;
        return view('scrap-data', compact('scrapData'))->with('scrapTitle', $scrapTitle)->with('scrapCreated', $scrapCreated);;
    }
}
