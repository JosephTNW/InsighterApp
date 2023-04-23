<!DOCTYPE html>
<html>

<head>
    <title>Insighter</title>
</head>

<body>
    <nav>
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">

                @auth
                    <x-app-layout>

                    </x-app-layout>
                    <a href="{{ url('/dashboard') }}"
                        class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
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
            <button type="submit" name="action" value="csv" style="font-size: 2em; padding: 20px 50px;">Display in
                CSV</button>
            <button type="submit" name="action" value="json" style="font-size: 2em; padding: 20px 50px;">Display in
                JSON</button>
        </form>
    </div>
</body>

</html>
