<!DOCTYPE html>
<html>

<head>
    <title>Insighter</title>
    <link rel="icon" type="image/png" href="{{ asset('InsighterLogo.png') }}">
</head>

<body>
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

            <div style="text-align: center; margin-top: 50px;">
                <form action="{{ route('scrapTokopedia') }}" method="POST">
                    @csrf
                    <label for="inputValue">Product Name:</label>
                    <input type="text" id="inputValue" name="inputValue">
                    <br><br>
                    <label for="dropdownValue">Number of Pages:</label>
                    <select id="dropdownValue" name="dropdownValue">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <br><br>
                    <button type="submit" name="action" value="csv" style="font-size: 2em; padding: 20px 50px;">Display
                        in
                        CSV</button>
                    <button type="submit" name="action" value="json" style="font-size: 2em; padding: 20px 50px;">Display
                        in
                        JSON</button>
                </form>
            </div>

            @auth
                <form method="GET" action="{{ route('getScrapHistory') }}">
                    <div style="text-align: center; margin-top: 50px;">
                        <button type="submit">View History</button>
                    </div>
                </form>
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

            <div style="text-align: center; margin-top: 50px;">
                <img src="InsighterLogo.png" style="width="256px"; height="256px""/>
                <form action="{{ route('scrapTokopedia') }}" method="POST">
                    @csrf
                    <label for="inputValue">Product Name:</label>
                    <input type="text" id="inputValue" name="inputValue">
                    <br><br>
                    <label for="dropdownValue">Number of Pages:</label>
                    <select id="dropdownValue" name="dropdownValue">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <br><br>
                    <button type="submit" name="action" value="csv" style="font-size: 2em; padding: 20px 50px;">Display
                        in
                        CSV</button>
                    <button type="submit" name="action" value="json" style="font-size: 2em; padding: 20px 50px;">Display
                        in
                        JSON</button>
                </form>
            </div>

            @auth
                <form method="GET" action="{{ route('getScrapHistory') }}">
                    <div style="text-align: center; margin-top: 50px;">
                        <button type="submit">View History</button>
                    </div>
                </form>
            @endauth
    @endauth

</body>

</html>
