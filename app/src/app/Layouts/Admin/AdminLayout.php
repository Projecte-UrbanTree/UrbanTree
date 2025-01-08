<?php

use App\Core\Session;
use App\Models\User;

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$currentContract = Session::get('current_contract');
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
    <script src="https://cdn.lordicon.com/lordicon.js"></script>

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
                <!-- Contract Dropdown -->
                <select id="contractBtn" name="contractBtn"
                    class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                    onchange="setCurrentContract(this.value)">
                    <?php
                    foreach ($contracts as $contract) {
                        echo '<option value="' . $contract->getId() . '"' . ($currentContract == $contract->getId() ? ' selected' : '') . '>' . $contract->name . '</option>';
                    }
                    echo '<option value="-1"' . ($currentContract == -1 ? ' selected' : '') . '>Todos los contratos</option>';
                    ?>
                </select>

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
                            <?= User::getRoleName($_SESSION['user']['role']); ?>
                        </span>
                        <div id="profile-dropdown"
                            class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="/admin/configuration"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-800" role="menuitem"
                                    tabindex="-1" id="menu-item-0">Configuración de la cuenta</a>
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
    <div id="submenu"
        class="md:flex overflow-x-auto justify-center items-center gap-6 p-6 shadow-md sm:shadow-none px-2 py-1 sm:py-4">

        <div class="submenu text-center flex items-center space-x-6">
            <div class="submenu-item">
                <a href="/admin/contracts"
                    class="link-primary <?= ($currentPath == '/admin/contracts') ? 'active' : ''; ?>">
                    <i class="fas fa-file-contract block"></i>
                    <span class="text-sm font-medium whitespace-nowrap">Contratos</span>
                </a>
            </div>

            <div class="submenu-item">
                <a href="/admin/work-orders"
                    class="link-primary <?= ($currentPath == '/admin/work-orders') ? 'active' : ''; ?>">
                    <i class="fas fa-briefcase md:block"></i>
                    <span class="text-sm font-medium whitespace-nowrap">Órdenes de trabajo</span>
                </a>
            </div>

            <div class="submenu-item">
                <a href="/admin/element-types"
                    class="link-primary <?= ($currentPath == '/admin/element-types') ? 'active' : ''; ?>">
                    <i class="fas fa-cube md:block"></i>
                    <span class="text-sm font-medium whitespace-nowrap">Tipos de elemento</span>
                </a>
            </div>

            <div class="submenu-item">
                <a href="/admin/tree-types"
                    class="link-primary <?= ($currentPath == '/admin/tree-types') ? 'active' : ''; ?>">
                    <i class="fas fa-tree md:block"></i>
                    <span class="text-sm font-medium whitespace-nowrap">Tipos de árbol</span>
                </a>
            </div>

            <div class="submenu-item">
                <a href="/admin/task-types"
                    class="link-primary <?= ($currentPath == '/admin/task-types') ? 'active' : ''; ?>">
                    <i class="fas fa-tasks md:block"></i>
                    <span class="text-sm font-medium whitespace-nowrap">Tipos de tarea</span>
                </a>
            </div>

            <div class="submenu-item">
                <a href="/admin/users" class="link-primary <?= ($currentPath == '/admin/users') ? 'active' : ''; ?>">
                    <i class="fas fa-users md:block"></i>
                    <span class="text-sm font-medium whitespace-nowrap">Usuarios</span>
                </a>
            </div>

            <div class="submenu-item">
                <a href="/admin/stats" class="link-primary <?= ($currentPath == '/admin/stats') ? 'active' : ''; ?>">
                    <i class="fas fa-chart-bar md:block"></i>
                    <span class="text-sm font-medium whitespace-nowrap">Estadísticas</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6">
        <?php if (Session::has('success')): ?>
            <div id="alert-msg" class="bg-blue-500 text-white px-4 py-3 rounded-lg mb-6" role="alert">
                <strong class="font-bold">Success: </strong>
                <span><?= htmlspecialchars(Session::get('success')); ?></span>
            </div>
        <?php endif;
        echo $content;
        ?>
    </div>

    <script src="/assets/js/app.js?v=<?= time(); ?>"></script>
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
</body>

</html>