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

    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 flex items-center justify-center bg-white z-50">
        <img src="/assets/images/logo.png" alt="Loading..." class="w-48 fade-animation">
    </div>

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
            </div>

            <!-- Profile and Contract Dropdown -->
            <div class="flex items-center gap-4">
                <select id="contractBtn" name="contractBtn" class="bg-white text-sm rounded-md p-2 text-right focus:outline-none" onchange="setCurrentContract(this.value)">
                    <?php
                    foreach ($contracts as $contract) {
                        echo '<option value="'.$contract->getId().'"'.($currentContract == $contract->getId() ? ' selected' : '').'>'.$contract->name.'</option>';
                    }
echo '<option value="-1"'.($currentContract == -1 ? ' selected' : '').'>Todos los contratos</option>';
?>
                </select>
                <div class="relative">
                    <!-- Letters avatar -->
                    <div class="h-10 w-10 flex items-center justify-center bg-gray-300 text-gray-700 font-semibold text-lg rounded-full cursor-pointer" onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')">
                        <?= strtoupper(substr(Session::get('user')['name'], 0, 1).substr(Session::get('user')['surname'], 0, 1)); ?>
                    </div>
                    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md ring-1 ring-black/5 z-10">
                        <a href="/admin/account" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configuración de la cuenta</a>
                        <a href="/license" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Licencia</a>
                        <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-4 py-4 bg-gray-100">
        </div>
    </header>

    <!-- Submenu -->
    <div id="submenu" class="flex overflow-x-auto whitespace-nowrap justify-center items-center gap-4 px-4 py-4 bg-gray-100 shadow-md">
        <!-- Hide or disable editing buttons for customers -->
        <button id="zone-control" class="hidden text-sm text-gray-700 flex flex-col items-center">
            <i class="fas fa-brush"></i>
            Editor de zonas
        </button>
        <button id="element-control" class="hidden text-sm text-gray-700 flex flex-col items-center">
            <i class="fas fa-jar-wheat"></i>
            Editor de elementos
        </button>

        <!-- Separator -->
        <div class="h-6 border-l border-gray-300 mx-4"></div>

        <!-- Create Button (Hidden for customers) -->
        <button id="create-control" class="hidden text-sm text-gray-300 flex flex-col items-center" disabled>
            <i class="fas fa-plus-circle"></i>
            Crear nueva zona
        </button>

        <!-- Finish Creation Button (Hidden for customers) -->
        <button id="finish-control" class="hidden text-sm text-gray-700 flex flex-col items-center">
            <i class="fas fa-check-circle"></i>
            Finalizar creación
        </button>

        <!-- Cancel Zone Creation Button (Hidden for customers) -->
        <button id="cancel-zone-control" class="hidden text-sm text-gray-700 flex flex-col items-center">
            <i class='fas fa-times-circle'></i> Cancelar creación
        </button>

    </div>

    <!-- Main Content -->
    <main class="flex grow">
        <?= $content; ?>
    </main>

    <script src="/assets/js/app.js?v=<?= time(); ?>"></script>
    <script>
        window.userRole = <?= json_encode(Session::get('user')['role']) ?>;
    </script>
    <script src="/assets/js/map.js?v=<?= time(); ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
