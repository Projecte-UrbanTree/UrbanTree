<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title . ' - ' . getenv('APP_NAME'); ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <script src="/assets/js/tailwind.js"></script>
    <script src="https://kit.fontawesome.com/f80b94bd90.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.1/dist/cookieconsent.css">
</head>

<body class="w-full h-full bg-gray-50">
    <div class="p-2 md:p-6">
        <!-- Logo -->
        <div class="flex justify-center">
            <a href="/">
                <img src="/assets/images/logotip-horizontal.png" alt="Logo" class="mx-auto mb-4 w-36 md:w-48">
            </a>
        </div>

        <!-- Main Content (Dynamic) -->
        <div class="max-w-6xl bg-white mx-auto rounded-lg p-2 md:p-6 mb-8 border border-gray-200">
            <?= $content; ?>
        </div>
    </div>

    <!-- Return Button -->
    <div id="returnBtn" class="fixed bottom-16 right-16">
        <a href="javascript:history.back()" class="bg-primary hover:bg-primaryDark text-white py-2 px-4 rounded-lg">
            <i class="fa-solid fa-rotate-left"></i> Volver atrás
        </a>
    </div>

    <script type="module" src="/assets/js/cookieconsent-config.js"></script>
</body>

</html>
