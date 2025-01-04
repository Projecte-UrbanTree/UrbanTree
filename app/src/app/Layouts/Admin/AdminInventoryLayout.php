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
    <link rel="stylesheet" href="/assets/css/app.css?v=<?= time(); ?>">
    <script src="/assets/js/tailwind.js"></script>
    <script src="https://kit.fontawesome.com/f80b94bd90.js" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
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
    <div class="border-b border-softGray">
        <nav class="flex items-center px-2 py-4 h-16 max-w-7xl mx-auto justify-between">

            <!-- Logo -->
            <a href="#" class="md:basis-1/3 basis-1/5 flex justify-start">
                <img class="md:block hidden w-48" src="/assets/images/logotip-horizontal.png" alt="Logo">
                <img class="md:hidden block w-12" src="/assets/images/resized-isotip.png" alt="Logo">
            </a>

            <div class="flex md:flex gap-3 md:gap-6 basis-0 flex-grow justify-center">
                <a href="/admin"
                    class="menu-link text-sm sm:text-lg align-middle <?= (strpos($currentPath, '/admin') === 0 && strpos($currentPath, '/admin/inventory') === false) ? 'active' : ''; ?>">
                    Gestión
                </a>
                <a href="/admin/inventory"
                    class="menu-link text-sm sm:text-lg align-middle <?= ($currentPath === '/admin/inventory') ? 'active' : ''; ?>">
                    Inventario
                </a>
            </div>

            <!-- User Section -->
            <div class="flex items-center gap-4 mx-2 basis-1/3 justify-end">
                <!-- User Info Dropdown -->
                <div class="relative inline-block text-left">
                    <button onclick="toggleSubmenu()"
                        class="flex items-center gap-2 bg-white px-3 py-2 text-sm text-gray-900 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <span class="hidden sm:block">Contratos</span>
                        <svg class="hidden sm:block -mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                        <lord-icon class="block sm:hidden" src="https://cdn.lordicon.com/vdjwmfqs.json" trigger="hover"
                            colors="primary:#747474" style="width:22px;height:22px">
                        </lord-icon>
                    </button>
                </div>

                <!-- Notifications Icon -->
                <a href="#" class="hidden md:block text-gray-700 hover:text-blue-600">
                    <lord-icon src="https://cdn.lordicon.com/vspbqszr.json" trigger="hover" state="loop-bell"
                        colors="primary:#747474" style="width:28px;height:28px">
                    </lord-icon>
                </a>

                <!-- User Avatar -->
                <div class="relative flex items-center gap-2 cursor-pointer"
                    onclick="profileDropdown.classList.toggle('hidden')">
                    <img class="h-10 rounded-full" style="width: 25px; height: 25px" src="/assets/images/avatar.png"
                        alt="User Avatar">
                    <div class="hidden md:block text-sm relative">
                        <span
                            class="block text-gray-700"><?= $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname']; ?></span>
                        <span class="block text-gray-500">
                            <?= User::role_name($_SESSION['user']['role']); ?>
                        </span>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <button id="toggleSidebar" class="fixed left-0 top-1/2 -translate-y-1/2 z-50 
    w-8 h-24 bg-white hover:bg-gray-200 rounded-r-lg shadow-md cursor-pointer">
        <i class="fas fa-chevron-right text-gray-600"></i>
    </button>

    <div class="fixed top-1/6 mt-10 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 
    flex flex-row gap-2 bg-white bg-opacity-50 backdrop-filter backdrop-blur-md 
    shadow-md rounded-lg p-4">
        <!-- <button class="w-10 h-10 flex items-center justify-center rounded-full 
    bg-gray-100 hover:bg-green-100 active:bg-green-100 transition-colors duration-300">
            <i class="fas fa-file-contract text-gray-600"></i>
        </button> -->
        <button class="w-10 h-10 flex items-center justify-center rounded-full 
    bg-gray-100 hover:bg-green-100 active:bg-green-100 transition-colors duration-300">
            <i class="fas fa-map-marker-alt text-gray-600"></i>
        </button>
        <button class="w-10 h-10 flex items-center justify-center rounded-full 
    bg-gray-100 hover:bg-green-100 active:bg-green-100 transition-colors duration-300">
            <i class="fas fa-tree text-gray-600"></i>
        </button>
    </div>






    <!-- Barra lateral -->
    <div id="sidebar" class="fixed top-16 left-0 h-[calc(100%-65px)] w-16 
    flex flex-col items-center justify-start 
    bg-white shadow-xl 
    pt-6 pb-4 z-40 
    hidden transition-transform transform -translate-x-full group">
        <!-- Opción 1: Edit -->
        <div class="relative group mb-6">
            <button class="flex items-center justify-center 
        w-12 h-12 hover:bg-gray-100 rounded-full 
        transition-colors duration-200 ease-in-out cursor-pointer">
                <i class="fas fa-edit text-xl text-gray-600"></i>
            </button>
        </div>
        <!-- Opción 2: Filter -->
        <div class="relative group mb-6">
            <button class="flex items-center justify-center 
        w-12 h-12 hover:bg-gray-100 rounded-full 
        transition-colors duration-200 ease-in-out cursor-pointer">
                <i class="fas fa-filter text-xl text-gray-600"></i>
            </button>
        </div>
    </div>














    </div>










    <!-- Main Content -->
    <?= $content ?>

    <script src="/assets/js/app.js"></script>
    <!-- Javascript, add class d-none to alert-msg after 5 seconds if it exists -->
    <script>
        setTimeout(() => {
            const alertMsg = document.getElementById('alert-msg');
            if (alertMsg) {
                alertMsg.classList.add('hidden');
            }
        }, 3500);
    </script>
    <script>
        const menuButton = document.getElementById('menuButton');
        const submenu = document.getElementById('submenu');
        const submenuItems = document.querySelectorAll('.submenu-item');
        const profileDropdown = document.getElementById('profile-dropdown');

        menuButton.addEventListener('click', () => {
            submenu.classList.toggle('hidden');
        });
    </script>
    <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const floatingButtons = document.querySelectorAll('#floatingContracts, #floatingZones, #floatingElements');

        toggleSidebar.addEventListener('mouseenter', () => {
            toggleSidebar.classList.add('hidden');
            sidebar.classList.remove('hidden');
            sidebar.classList.add('translate-x-0');
        });

        sidebar.addEventListener('mouseleave', () => {
            toggleSidebar.classList.remove('hidden');
            sidebar.classList.add('hidden');
            sidebar.classList.remove('translate-x-0');
        });

        floatingButtons.forEach((button) => {
            button.addEventListener('click', () => {
                floatingButtons.forEach((btn) => btn.classList.remove('bg-blue-500', 'text-white'));
                button.classList.add('bg-blue-500', 'text-white');
            });
        });
    </script>
    <script>
        const buttons = document.querySelectorAll('.w-10.h-10');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                buttons.forEach(btn => btn.classList.remove('bg-green-100'));
                button.classList.add('bg-green-100');
            });
        });
    </script>
</body>

</html>