<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title . ' - ' . getenv('APP_NAME'); ?>
    </title>
    <script src="/assets/js/app.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.1/dist/cookieconsent.css">
</head>

<body class="w-full h-full">
    <?= $content; ?>
    <script type="module" src="/assets/js/cookieconsent-config.js"></script>
</body>

</html>