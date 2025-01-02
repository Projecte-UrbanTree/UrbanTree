<?php
use App\Models\User;
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title . ' - ' . getenv('APP_NAME'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <script src="/assets/js/tailwind.js"></script>
    <script src="https://kit.fontawesome.com/f80b94bd90.js" crossorigin="anonymous"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.8.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.8.0/mapbox-gl.js"></script>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        #map {
            height: calc(100% - 65px);
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <div class="border-b border-gray">
        <nav class="flex items-center justify-between px-4 py-4 h-16 max-w-7xl mx-auto">

            <!-- Logo -->
            <a href="#">
                <img class="md:block hidden w-48" src="/assets/images/logotip-horizontal.png" alt="Logo">
                <img class="md:hidden block" src="/assets/images/isotip.png" alt="Logo">
            </a>
            <!-- Navigation Links (Visible only on large screens) -->
            <div class="hidden md:flex gap-6">
                <a href="/admin"
                    class="menu-link <?= (strpos($currentPath, '/admin') === 0 && strpos($currentPath, '/admin/inventory') === false) ? 'active' : ''; ?>">
                    Gestión
                </a>
                <a href="/admin/inventory"
                    class="menu-link <?= ($currentPath === '/admin/inventory') ? 'active' : ''; ?>">
                    Inventario
                </a>
            </div>


            <!-- User Section -->
            <div class="flex items-center gap-4 mx-2">
                <!-- User Info Dropdown -->
                <div class="relative inline-block text-left">
                    <button onclick="toggleSubmenu()"
                        class="flex items-center gap-2 bg-white px-3 py-2 text-sm text-gray-900 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Contratos
                        <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <!-- Notifications Icon -->
                <a href="#" class="hidden md:block text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </a>
                <!-- User Avatar -->
                <div class="relative flex items-center gap-2 cursor-pointer"
                    onclick="profileDropdown.classList.toggle('hidden')">
                    <img class="h-10 rounded-full" src="/assets/images/avatar.png" alt="User Avatar">
                    <div class="hidden md:block text-sm relative">
                        <span
                            class="block text-gray-700"><?= $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname']; ?></span>
                        <span class="block text-gray-500">
                            <?= User::role_name($_SESSION['user']['role']); ?>
                        </span>
                        <div id="profile-dropdown"
                            class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-800"
                                    role="menuitem" tabindex="-1" id="menu-item-0">Configuración de la cuenta</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-1">Soporte</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-2">Licencia</a>
                                <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-800"
                                    role="menuitem" tabindex="-1" id="menu-item-3">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <?= $content ?>

    <script src="/assets/js/app.js"></script>
    <!-- Javascript, add class d-none to alert-msg after 5 seconds if it exists -->
    <script>
        mapboxgl.accessToken = '<?= getenv("MAPBOX_TOKEN") ?>';

        setTimeout(() => {
            const alertMsg = document.getElementById('alert-msg');
            if (alertMsg) {
                alertMsg.classList.add('hidden');
            }
        }, 3500);

        const menuButton = document.getElementById('menuButton');
        const submenu = document.getElementById('submenu');
        const submenuItems = document.querySelectorAll('.submenu-item');
        const profileDropdown = document.getElementById('profile-dropdown');

        menuButton.addEventListener('click', () => {
            submenu.classList.toggle('hidden');
        });
    </script>
    <script src="/assets/js/inventary.js" defer></script>
</body>

</html>