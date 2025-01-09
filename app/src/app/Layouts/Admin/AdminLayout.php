<?php

use App\Core\Session;
use App\Models\User;

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
    <script src="https://kit.fontawesome.com/f80b94bd90.js" crossorigin="anonymous"></script>
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
                <a href="/admin" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= (strpos($currentPath, '/admin') === 0 && strpos($currentPath, '/admin/inventory') === false) ? 'font-semibold' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i> Gestión
                </a>
                <a href="/admin/inventory" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath === '/admin/inventory') ? 'font-semibold' : ''; ?>">
                    <i class="fas fa-cogs"></i> Inventario
                </a>
            </div>

            <!-- Profile and Contract Dropdown -->
            <div class="flex items-center gap-4">
                <select id="contractBtn" name="contractBtn" class="bg-white text-sm rounded-md p-2 text-right focus:outline-none" onchange="setCurrentContract(this.value)">
                    <?php
                    foreach ($contracts as $contract) {
                        echo '<option value="' . $contract->getId() . '"' . ($currentContract == $contract->getId() ? ' selected' : '') . '>' . $contract->name . '</option>';
                    }
                    echo '<option value="-1"' . ($currentContract == -1 ? ' selected' : '') . '>Todos los contratos</option>';
                    ?>
                </select>
                <div class="relative">
                    <img class="h-10 rounded-full cursor-pointer" src="https://via.placeholder.com/150" alt="User Avatar" onclick="document.getElementById('profile-dropdown').classList.toggle('hidden')">
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
            <a href="/admin" class="block py-2 text-sm text-gray-700 hover:bg-gray-200 rounded <?= (strpos($currentPath, '/admin') === 0 && strpos($currentPath, '/admin/inventory') === false) ? 'font-semibold' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Gestión
            </a>
            <a href="/admin/inventory" class="block py-2 text-sm text-gray-700 hover:bg-gray-200 rounded <?= ($currentPath === '/admin/inventory') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-cogs"></i> Inventario
            </a>
        </div>
    </header>

    <!-- Submenu -->
    <div id="submenu" class="md:flex overflow-x-auto flex-nowrap whitespace-nowrap items-center gap-4 px-4 py-4 bg-gray-100 shadow-md">
        <div class="submenu text-center flex items-center space-x-6 mx-auto">
            <a href="/admin/contracts" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath == '/admin/contracts') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-file-contract block"></i>
                Contratos
            </a>
            <a href="/admin/work-orders" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath == '/admin/work-orders') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-briefcase block"></i>
                Órdenes de trabajo
            </a>
            <a href="/admin/element-types" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath == '/admin/element-types') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-cube block"></i>
                Tipos de elemento
            </a>
            <a href="/admin/tree-types" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath == '/admin/tree-types') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-tree block"></i>
                Tipos de árbol
            </a>
            <a href="/admin/task-types" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath == '/admin/task-types') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-tasks block"></i>
                Tipos de tarea
            </a>
            <a href="/admin/users" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath == '/admin/users') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-users block"></i>
                Usuarios
            </a>
            <a href="/admin/stats" class="text-sm text-gray-700 hover:text-gray-600 active:text-gray-700 <?= ($currentPath == '/admin/stats') ? 'font-semibold' : ''; ?>">
                <i class="fas fa-chart-bar block"></i>
                Estadísticas
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 pt-8 pb-16">
        <?php if (Session::has('success')): ?>
            <div id="alert-msg" class="bg-green-400 text-white px-4 py-3 rounded-lg mb-6 transform transition-all duration-500 ease-in-out" role="alert">
                <span class="inline-block mr-2">
                    <!-- Success Icon (Font Awesome) -->
                    <i class="fas fa-check-circle w-5 h-5 text-white"></i>
                </span>
                <?= htmlspecialchars(Session::get('success')); ?>
            </div>
        <?php endif; ?>

        <?php if (Session::has('error')): ?>
            <div id="alert-msg-error" class="bg-red-400 text-white px-4 py-3 rounded-lg mb-6 transform transition-all duration-500 ease-in-out" role="alert">
                <span class="inline-block mr-2">
                    <!-- Error Icon (Font Awesome) -->
                    <i class="fas fa-exclamation-circle w-5 h-5 text-white"></i>
                </span>
                <strong class="font-bold">Error:</strong> <?= htmlspecialchars(Session::get('error')); ?>
            </div>
        <?php endif; ?>

        <?= $content; ?>
    </main>

    <script src="/assets/js/app.js?v=<?= time(); ?>"></script>
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
