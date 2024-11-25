<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo htmlspecialchars($title) . ' - ' . htmlspecialchars(getenv('APP_NAME')); ?>
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="/assets/js/app.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal flex items-center justify-center h-screen">

    <?php echo $content; ?>


</body>

</html>