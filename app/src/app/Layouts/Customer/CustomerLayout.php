<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title . ' - ' . getenv('APP_NAME'); ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <script src="/assets/js/app.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.1/dist/cookieconsent.css">
</head>

<body class="w-full h-full flex flex-col">

    <!-- Navbar  -->
    <header class="border-b border-softGray">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <img class="hidden md:block w-36" src="/assets/images/logotip-horizontal.png" alt="Logo">
                <img class="md:hidden block w-10" src="/assets/images/resized-isotip.png" alt="Logo">
            </a>



            <div class="flex items-center space-x-4">
                <a href="/login" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    Iniciar sesión
                </a>

            </div>
        </nav>
    </header>

    <main class="flex-grow">
        <?= $content; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 mt-6">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-600 text-sm">
            &copy; <?= date('Y'); ?> - <?= getenv('APP_NAME'); ?>. Todos los derechos reservados.
        </div>
    </footer>

    <script type="module" src="/assets/js/cookieconsent-config.js"></script>
</body>

</html>