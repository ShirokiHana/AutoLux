<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AutoLux</title>
    <script src="/js/query.js"></script>

    <style>
        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        body {
            display: flex;
            flex-direction: column;
            background:
                    radial-gradient(circle at 18% 22%, rgba(255, 142, 188, 0.45) 0%, transparent 45%),
                    radial-gradient(circle at 82% 28%, rgba(112, 214, 255, 0.45) 0%, transparent 45%),
                    radial-gradient(circle at 50% 80%, rgba(213, 187, 247, 0.4) 0%, transparent 50%),
                    linear-gradient(135deg, #fff0f6 0%, #eef7ff 50%, #f7f0ff 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: 'Quicksand', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #4a385f;
        }
    </style>
    </head>
    <body>
    <?php view( 'components/nav.php' ) ?>