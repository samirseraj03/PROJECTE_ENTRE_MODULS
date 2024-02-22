<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data View</title>
</head>
<body>
    <h1>Data View</h1>

    <!-- Access processed data in JavaScript -->
    <script>
        var jsonData = $data;
        console.log(jsonData);
        // Use jsonData in your JavaScript logic
    </script>

    <!-- Access processed data in PHP -->
    <div>
        <pre>{{ print_r($data, true) }}</pre>
        <!-- Use $data in your PHP logic -->
    </div>
</body>
</html>