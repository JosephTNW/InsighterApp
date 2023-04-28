<!DOCTYPE html>
<html>

<head>
    <title>Result Page</title>
</head>

<body>
    @php
        $average = App\Http\Controllers\InsightController::getAverage($model);
        $median = App\Http\Controllers\InsightController::getMedian($model);
        $range = App\Http\Controllers\InsightController::getRange($model);
        $q1 = App\Http\Controllers\InsightController::getQ1($model);
        $q3 = App\Http\Controllers\InsightController::getQ3($model);
    @endphp
    @auth
        <x-app-layout>
            <nav>
                @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">

                        @auth
                        @else
                            <a href="{{ route('login') }}"
                                class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                                in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>
            <h1 class="text-center p-12">{{ $scrapTitle }} Scrapping Result</h1>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                            <table class="table-auto">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Store</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($model as $result)
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
                                <p>{{ $range }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @auth
                <form action="{{ route('saveToDatabase') }}" method="POST">
                    @csrf
                    <input type="hidden" name="csv_data" value="{{ $csv_output }}">
                    <input type="hidden" name="scrap_title" value="{{ $scrapTitle }}">
                    <button type="submit">Save to Database</button>
                </form>
            @else
                <a href="{{ route('login') }}" style="display: inline-block; margin-right: 10px;">Login</a>
                <p style="display: inline-block; margin-right: 10px;">or</p>
                <a href="{{ route('login') }}" style="display: inline-block; margin-right: 10px;">Register</a>
                <p style="display: inline-block;">to save analysis results</p>
            @endauth
        </x-app-layout>
    @else
        <nav>
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">

                    @auth
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>
        <h1 class="text-center m-5">{{ $scrapTitle }} Scrapping Result</h1>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <table class="table-auto">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Store</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model as $result)
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between text-center">
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
                            <p>{{ $range }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


        @auth
            <form action="{{ route('saveToDatabase') }}" method="POST">
                @csrf
                <input type="hidden" name="csv_data" value="{{ $csv_output }}">
                <input type="hidden" name="scrap_title" value="{{ $scrapTitle }}">
                <button type="submit">Save to Database</button>
            </form>
        @else
            <a href="{{ route('login') }}" style="display: inline-block; margin-right: 10px;">Login</a>
            <p style="display: inline-block; margin-right: 10px;">or</p>
            <a href="{{ route('login') }}" style="display: inline-block; margin-right: 10px;">Register</a>
            <p style="display: inline-block;">to save analysis results</p>
        @endauth
    @endauth
</body>

</html>
