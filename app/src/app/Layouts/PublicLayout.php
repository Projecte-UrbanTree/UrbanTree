<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character set declaration for the document -->
    <meta charset="UTF-8">
    <!-- Viewport settings to make the layout responsive on different screen sizes -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Page title dynamically generated from PHP -->
    <title><?= $title . ' - ' . getenv('APP_NAME'); ?></title>
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
    <!-- CookieConsent Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.1/dist/cookieconsent.css">
</head>

<body class="w-full h-full bg-gray-50">
    <div class="p-2 md:p-6">
        <!-- Logo -->
        <div class="flex justify-center">
            <a href="/">
                <img src="/assets/images/logo.png" alt="Logo" class="mx-auto mb-4 w-36 md:w-48">
            </a>
        </div>

        <!-- Main Content (Dynamic) -->
        <div class="max-w-6xl bg-white mx-auto rounded p-2 md:p-6 mb-8 border border-gray-200">
            <?= $content; ?>
        </div>
    </div>

    <!-- Return Button -->
    <div class="bottom-8 right-8 fixed">
        <a href="javascript:history.back()" class="bg-primary hover:bg-primaryDark text-white py-2 px-4 rounded">
            <i class="fa-solid fa-angle-left mr-1"></i> Volver atrás
        </a>
    </div>

    <!-- CookieConsent Script -->
    <script type="module" src="/assets/js/cookieconsent-config.js"></script>
</body>

</html>
