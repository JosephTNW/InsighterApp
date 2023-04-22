<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InsightController extends Controller
{
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
            return view('csv-view', ['csv_output' => $csv_output]);
        } else if ($action === 'json') {
            exec("node node/tokopedia_json.js '{$scrapTitle}' {$pageNum}", $output, $return_var);
            return view('json-view', ['productResult' => $output]);
        }
    }
}
