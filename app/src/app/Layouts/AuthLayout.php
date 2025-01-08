<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title . ' - ' . getenv('APP_NAME'); ?></title>
    <script src="/assets/js/app.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>

<body class="bg-gray-50 font-sans leading-normal tracking-normal flex items-center justify-center h-screen">

    <!-- Auth content area -->
    <div class="w-full max-w-lg bg-white rounded-lg p-8 border border-gray-200">
        <!-- Header with Logo -->
        <header class="text-center mb-8">
            <img src="/assets/images/logotip-horizontal.png" alt="Logo" class="mx-auto mb-4 w-36 md:w-48">

        </header>

        <!-- Main content -->
        <main>
            <?= $content; ?>
        </main>
    </div>

</body>

</html>
