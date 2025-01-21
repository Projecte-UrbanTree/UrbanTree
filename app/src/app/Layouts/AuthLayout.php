<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character set declaration for the document -->
    <meta charset="UTF-8">
    <!-- Viewport settings to make the layout responsive on different screen sizes -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Page title dynamically generated from PHP -->
    <title><?= $title.' - '.getenv('APP_NAME'); ?></title>
    <!-- Favicon link -->
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <!-- Tailwind CSS framework (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Main stylesheet for the application -->
    <link rel="stylesheet" href="/assets/css/app.css">
    <!-- Tailwind custom JavaScript file (local) -->
    <script src="/assets/js/tailwind.js"></script>
    <!-- FontAwesome CDN for icons -->
    <script src="https://kit.fontawesome.com/f03c46a869.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-50 font-sans leading-normal tracking-normal flex items-center justify-center h-screen p-2 md:p-0">

    <!-- Auth content area -->
    <div class="w-full max-w-lg bg-white rounded p-8 border border-gray-200">
        <!-- Header with Logo -->
        <header class="text-center my-8">
            <img src="/assets/images/logo.png" alt="Logo" class="mx-auto mb-4 w-48 md:w-64">

        </header>

        <!-- Main content -->
        <main>
            <?= $content; ?>
        </main>
    </div>

</body>

</html>
