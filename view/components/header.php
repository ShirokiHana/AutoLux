<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AutoLux</title>
    <script src="/js/query.js"></script>

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        body {
            display: flex;
            flex-direction: column;
            background-color: #f5f5f6;
            background-image:
                    linear-gradient(rgba(30, 28, 34, 0.045) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(30, 28, 34, 0.045) 1px, transparent 1px);
            background-size: 40px 40px;
            color: #302c34;
            padding-bottom: 6rem;
            box-sizing: border-box;
            margin-inline: 1em;
        }

        body > table {
            align-self: flex-start;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #000;
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 0.5em;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        tr > :last-child {
            border-right: 0;
        }

        table > tr:last-child > *,
        table > :last-child > tr:last-child > * {
            border-bottom: 0;
        }
    </style>
    </head>
    <body>
    <?php view( 'components/nav.php' ) ?>