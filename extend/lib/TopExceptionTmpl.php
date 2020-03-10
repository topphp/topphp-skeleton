<?php
$errMsg = config("app.error_message");
echo <<<EOT
    
<!DOCTYPE html>

<html>
    <head>
        <title>TopPHP Exception</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1 style="margin-left: 50px;">:(<span style="margin-left: 30px">Sorry！</span></h1>
        <h3 style="margin-left: 50px;">$errMsg</h3>
    </body>
</html>

EOT;




