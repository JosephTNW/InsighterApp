<html>

<head>
    <title>{{ $scrapTitle }}</title>
</head>

<body>
    @php
        $average = App\Http\Controllers\InsightController::getAverage($scrapData);
        $median = App\Http\Controllers\InsightController::getMedian($scrapData);
        $range = App\Http\Controllers\InsightController::getRange($scrapData);
        $q1 = App\Http\Controllers\InsightController::getQ1($scrapData);
        $q3 = App\Http\Controllers\InsightController::getQ3($scrapData);
    @endphp

    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Scrap Data') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <h3 class="px-4 py-2">{{ $scrapTitle }} - {{ $scrapCreated }}</h3>
                        <table class="table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Title</th>
                                    <th class="px-4 py-2">Price</th>
                                    <th class="px-4 py-2">Store</th>
                                    <th class="px-4 py-2">Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scrapData as $result)
                                    <tr>
                                        <td class="px-4 py-2">{{ $result->title }}</td>
                                        <td class="px-4 py-2">{{ $result->price }}</td>
                                        <td class="px-4 py-2">{{ $result->store }}</td>
                                        <td class="px-4 py-2">{{ $result->location }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
                <div class="flex justify-between w-full">
                    <div class="w-1/3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3>Average</h3>
                            <br>
                            <p>{{ $average }}</p>
                        </div>
                    </div>
                    <div class="w-1/3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3>Lower Quartile (Q1)</h3>
                            <br>
                            <p>{{ $q1 }}</p>
                        </div>
                    </div>
                    <div class="w-1/3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3>Median (Q2)</h3>
                            <br>
                            <p>{{ $median }}</p>
                        </div>
                    </div>
                    <div class="w-1/3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3>Upper Quartile (Q3)</h3>
                            <br>
                            <p>{{ $q3 }}</p>
                        </div>
                    </div>
                    <div class="w-1/3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3>Range</h3>
                            <br>
                            <p><b>{{ $range }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-app-layout>
</body>

</html>
