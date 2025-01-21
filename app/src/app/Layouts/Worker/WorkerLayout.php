<?php

use App\Core\Session;

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$currentContract = Session::get('current_contract');
?>
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
    <!-- Mapbox CSS and JavaScript -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.9.2/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.9.2/mapbox-gl.js"></script>
    <!-- Turf.js library -->
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6.5.0/turf.min.js"></script>
</head>

<body class="bg-gray-50">

    <!-- Navigation Bar -->
    <header class="border-b bg-white shadow-md">
        <nav class="flex items-center justify-between px-4 py-4 max-w-7xl mx-auto">

            <!-- Logo (hidden on mobile) -->
            <a href="/" class="hidden sm:block">
                <img class="w-36 md:w-48" src="/assets/images/logo.png" alt="Logo">
            </a>

            <!-- Mobile Menu Toggle Button -->
            <button id="mobile-menu-toggle" class="block md:hidden text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Navigation Links (Visible only on large screens) -->
            <div class="hidden md:flex space-x-6">
                <a href="/worker/work-orders" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath === '/worker/work-orders') ? 'font-semibold' : ''; ?>">
                    <i class="fas fa-toolbox"></i> Ordenes de trabajo
                </a>
                <a href="/worker/inventory" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath === '/worker/inventory') ? 'font-semibold' : ''; ?>">
                    <i class="fas fa-box-archive"></i> Inventario
                </a>
            </div>

            <!-- Profile and Contract Dropdown -->
            <div class="flex items-center gap-4">
                <div class="relative">
                    <!-- Letters avatar -->
                    <div class="h-10 w-10 flex items-center justify-center bg-gray-300 text-gray-700 font-semibold text-lg rounded-full cursor-pointer" onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')">
                        <?= strtoupper(substr(Session::get('user')['name'], 0, 1).substr(Session::get('user')['surname'], 0, 1)); ?>
                    </div>
                    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md ring-1 ring-black/5 z-10">
                        <a href="/license" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Licencia</a>
                        <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-4 py-4 bg-gray-100">
            <a href="/worker/work-orders" class="block py-2 text-sm text-gray-700 hover:bg-gray-200 rounded <?= ($currentPath === '/worker/work-orders') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-toolbox"></i> Ordenes de trabajo
            </a>
            <a href="/worker/inventory" class="block py-2 text-sm text-gray-700 hover:bg-gray-200 rounded <?= ($currentPath === '/worker/inventory') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-box-archive"></i> Inventario
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 pt-8 pb-16">
        <?php if (Session::has('success')) { ?>
            <div id="alert-msg"
                class="bg-green-400 text-white px-4 py-3 rounded mb-6 transform transition-all duration-500 ease-in-out"
                role="alert">
                <span class="inline-block mr-2">
                    <!-- Success Icon (Font Awesome) -->
                    <i class="fas fa-check-circle w-5 h-5 text-white"></i>
                </span>
                <?= htmlspecialchars(Session::get('success')); ?>
            </div>
        <?php } ?>

        <?php if (Session::has('error')) { ?>
            <div id="alert-msg-error"
                class="bg-red-400 text-white px-4 py-3 rounded mb-6 transform transition-all duration-500 ease-in-out"
                role="alert">
                <span class="inline-block mr-2">
                    <!-- Error Icon (Font Awesome) -->
                    <i class="fas fa-exclamation-circle w-5 h-5 text-white"></i>
                </span>
                <strong class="font-bold">Error:</strong> <?= htmlspecialchars(Session::get('error')); ?>
            </div>
        <?php } ?>

        <?= $content; ?>
    </main>

    <script src="/assets/js/worker.js?v=<?= time(); ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Show alerts with animation (Success and Error messages)
            const alertMsg = document.querySelector("#alert-msg");
            const alertMsgError = document.querySelector("#alert-msg-error");

            if (alertMsg) {
                setTimeout(() => {
                    alertMsg.classList.remove("hidden", "opacity-0");
                    alertMsg.classList.add("opacity-100");
                }, 100);

                setTimeout(() => {
                    alertMsg.classList.add("opacity-0");
                    alertMsg.classList.remove("opacity-100");
                    setTimeout(() => {
                        alertMsg.classList.add("hidden");
                    }, 500);
                }, 3500);
            }

            if (alertMsgError) {
                setTimeout(() => {
                    alertMsgError.classList.add("opacity-0");
                    alertMsgError.classList.remove("opacity-100");
                    setTimeout(() => {
                        alertMsgError.classList.add("hidden");
                    }, 500);
                }, 3500);
            }

            // Mobile menu toggle functionality
            const mobileMenuToggle = document.getElementById("mobile-menu-toggle");
            const mobileMenu = document.getElementById("mobile-menu");

            mobileMenuToggle.addEventListener("click", function() {
                mobileMenu.classList.toggle("hidden");
            });
        });
    </script>

</body>

</html>
