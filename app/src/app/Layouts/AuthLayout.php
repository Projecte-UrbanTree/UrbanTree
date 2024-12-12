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
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal flex items-center justify-center h-screen">

    <!-- Auth content area -->
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-gray-800">
                <?= $title; ?>
            </h1>
        </header>

        <!-- Main content -->
        <main>
            <?= $content; ?>
        </main>
    </div>

</body>

</html>