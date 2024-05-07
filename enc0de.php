<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encode Dec0de Studio - by It T4mpan</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 50px; }
        .container { max-width: 800px; }
        .output { word-wrap: break-word; white-space: pre-wrap; }
        textarea { min-height: 200px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Encode Dec0de Studio - by It T4mpan</h1>
        <form method="post" class="mb-3">
            <div class="form-group">
                <label for="data">Input Data:</label>
                <textarea class="form-control" id="data" name="data" required></textarea>
            </div>
            <div class="form-group">
                <label for="operation">Select Operation:</label>
                <select class="form-control" id="operation" name="operation">
                    <option value="base64_encode">Base64 Encode</option>
                    <option value="base64_decode">Base64 Decode</option>
                    <option value="hex_encode">Hexadecimal Encode</option>
                    <option value="hex_decode">Hexadecimal Decode</option>
                    <option value="php_serialize">PHP Serialize</option>
                    <option value="php_unserialize">PHP Unserialize</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Convert</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $_POST['data'];
            $operation = $_POST['operation'];
            $result = '';
            $error = false;

            switch ($operation) {
                case 'base64_encode':
                    $result = base64_encode($data);
                    break;
                case 'base64_decode':
                    $result = base64_decode($data);
                    break;
                case 'hex_encode':
                    $result = bin2hex($data);
                    break;
                case 'hex_decode':
                    $result = pack('H*', $data); // Corrected method for hex decoding
                    break;
                case 'php_serialize':
                    $result = serialize($data);
                    break;
                case 'php_unserialize':
                    try {
                        $result = unserialize($data);
                        if ($result === false && $data !== serialize(false)) {
                            throw new Exception("Unserialization failed");
                        }
                        $result = print_r($result, true);
                    } catch (Exception $e) {
                        $result = "Error: " . $e->getMessage();
                        $error = true;
                    }
                    break;
            }
            echo "<div class='alert " . ($error ? "alert-danger" : "alert-success") . "'><strong>Result:</strong> <span class='output'>" . htmlspecialchars($result) . "</span></div>";
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
