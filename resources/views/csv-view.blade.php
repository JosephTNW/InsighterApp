<!DOCTYPE html>
<html>
<head>
    <title>CSV View Example</title>
</head>
<body>
    <table>
        @foreach (explode(PHP_EOL, $csv_output) as $row)
            <tr>
                @foreach (str_getcsv($row) as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>