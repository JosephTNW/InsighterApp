<!DOCTYPE html>
<html>
<head>
    <title>Product Result</title>
    <style>
        pre {
            white-space: pre-wrap;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <h1>{{$scrapTitle}} Scrapping Result</h1>
    <pre>{{ json_encode($productResult, JSON_PRETTY_PRINT) }}</pre>
</body>
</html>