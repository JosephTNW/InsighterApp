<!DOCTYPE html>
<html>
<head>
    <title>Big Button Example</title>
</head>
<body>
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
            <button type="submit" name="action" value="csv"
            style="font-size: 2em; padding: 20px 50px;">Display in CSV</button>
            <button type="submit" name="action" value="json"
            style="font-size: 2em; padding: 20px 50px;">Display in JSON</button>
        </form>
    </div>
</body>
</html>