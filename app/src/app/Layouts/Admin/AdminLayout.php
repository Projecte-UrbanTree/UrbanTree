<?php $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title . ' - ' . getenv('APP_NAME'); ?></title>
    <script src="/assets/js/app.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <script src="https://kit.fontawesome.com/f80b94bd90.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="flex items-center justify-between px-4 py-4 h-16 border-b-2 border-slate-300">
        <!-- Mobile Menu Button -->
        <button class="md:hidden text-gray-700 hover:text-blue-600" id="menuButton">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                stroke="currentColor" class="h-8 w-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M3 12h18M3 19h18" />
            </svg>
        </button>

        <!-- Logo -->
        <a href="#">
            <img class="h-10 md:block hidden" src="/assets/images/logotip-horizontal.png" alt="Logo">
            <img class="h-10 md:hidden block" src="/assets/images/isotip.png" alt="Logo">
        </a>

        <!-- Navigation Links -->
        <div class="hidden md:flex gap-6 ml-20">
            <a href="/admin" class="font-bold text-lg <?php echo ($currentPath === '/admin') ? 'text-blue-600' : 'text-gray-700'; ?> hover:text-blue-600">
                Gestión
            </a>
            <a href="/admin/inventory" class="font-bold text-lg <?php echo ($currentPath === '/admin/inventory') ? 'text-blue-600' : 'text-gray-700'; ?> hover:text-blue-600">
                Inventario
            </a>
        </div>

        <!-- User Section -->
        <div class="flex items-center gap-4">
            <!-- Notifications Icon -->
            <a href="#" class="hidden md:block text-gray-700 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </a>

            <!-- User Info Dropdown -->
            <div class="relative inline-block text-left">
                <button onclick="toggleDropdown()" class="flex items-center gap-2 bg-white px-3 py-2 text-sm font-semibold text-gray-900 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Contratos
                    <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-56 bg-white shadow-lg ring-1 ring-black/5 rounded-md">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                    <!-- More dropdown items... -->
                </div>
            </div>

            <!-- User Avatar -->
            <div class="flex items-center gap-2">
                <img class="h-12 w-12 rounded-full" src="/assets/images/avatar.png" alt="User Avatar">
                <div class="hidden md:block text-sm">
                    <span class="block font-semibold text-gray-700"><?php echo $_SESSION['user']['name']; ?></span>
                    <span class="block text-gray-500">
                        <?php echo ($_SESSION['user']['role'] == 2) ? 'ADMINISTRADOR' : 'USUARIO'; ?>
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Submenu Section -->
    <div class="md:flex justify-center mt-5 gap-5 hidden">
        <!-- Contratos -->
        <div class="hover:scale-105 duration-200 flex items-center gap-2 <?php echo ($currentPath == '/admin/contracts') ? 'text-blue-600 font-bold' : ''; ?>">
            <i class="fas fa-file-contract <?php echo ($currentPath == '/admin/contracts') ? 'text-blue-600' : 'text-gray-700'; ?>"></i>
            <a href="/admin/contracts" class="<?php echo ($currentPath == '/admin/contracts') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">Contratos</a>
        </div>

        <!-- Orden Trabajo -->
        <div class="hover:scale-105 duration-200 flex items-center gap-2 <?php echo ($currentPath == '/admin/work-orders') ? 'text-blue-600 font-bold' : ''; ?>">
            <i class="fas fa-briefcase <?php echo ($currentPath == '/admin/work-orders') ? 'text-blue-600' : 'text-gray-700'; ?>"></i>
            <a href="/admin/work-orders" class="<?php echo ($currentPath == '/admin/work-orders') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">Orden de Trabajo</a>
        </div>

        <!-- Zonas -->
        <div class="hover:scale-105 duration-200 flex items-center gap-2 <?php echo ($currentPath == '/admin/zones') ? 'text-blue-600 font-bold' : ''; ?>">
            <i class="fas fa-map-marker-alt <?php echo ($currentPath == '/admin/zones') ? 'text-blue-600' : 'text-gray-700'; ?>"></i>
            <a href="/admin/zones" class="<?php echo ($currentPath == '/admin/zones') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">Zonas</a>
        </div>

        <!-- Elementos -->
        <div class="hover:scale-105 duration-200 flex items-center gap-2 <?php echo ($currentPath == '/admin/elements') ? 'text-blue-600 font-bold' : ''; ?>">
            <i class="fas fa-cube <?php echo ($currentPath == '/admin/elements') ? 'text-blue-600' : 'text-gray-700'; ?>"></i>
            <a href="/admin/elements" class="<?php echo ($currentPath == '/admin/elements') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">Elementos</a>
        </div>

        <!-- Tipo Tarea -->
        <div class="hover:scale-105 duration-200 flex items-center gap-2 <?php echo ($currentPath == '/admin/task-types') ? 'text-blue-600 font-bold' : ''; ?>">
            <i class="fas fa-tasks <?php echo ($currentPath == '/admin/task-types') ? 'text-blue-600' : 'text-gray-700'; ?>"></i>
            <a href="/admin/task-types" class="<?php echo ($currentPath == '/admin/task-types') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">Tipo Tarea</a>
        </div>

        <!-- Usuarios -->
        <div class="hover:scale-105 duration-200 flex items-center gap-2 <?php echo ($currentPath == '/admin/users') ? 'text-blue-600 font-bold' : ''; ?>">
            <i class="fas fa-users <?php echo ($currentPath == '/admin/users') ? 'text-blue-600' : 'text-gray-700'; ?>"></i>
            <a href="/admin/users" class="<?php echo ($currentPath == '/admin/users') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">Usuarios</a>
        </div>

        <!-- Partes -->
        <div class="hover:scale-105 duration-200 flex items-center gap-2 <?php echo ($currentPath == '/admin/work-orders') ? 'text-blue-600 font-bold' : ''; ?>">
            <i class="fas fa-clipboard-list <?php echo ($currentPath == '/admin/work-orders') ? 'text-blue-600' : 'text-gray-700'; ?>"></i>
            <a href="/admin/work-orders" class="<?php echo ($currentPath == '/admin/work-orders') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">Partes</a>
        </div>

        <!-- Estadísticas -->
        <div class="hover:scale-105 duration-200 flex items-center gap-2 <?php echo ($currentPath == '/admin/stats') ? 'text-blue-600 font-bold' : ''; ?>">
            <i class="fas fa-chart-bar <?php echo ($currentPath == '/admin/stats') ? 'text-blue-600' : 'text-gray-700'; ?>"></i>
            <a href="/admin/stats" class="<?php echo ($currentPath == '/admin/stats') ? 'text-blue-600 font-bold' : 'text-gray-700 hover:text-blue-600'; ?>">Estadísticas</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto my-16">
        <?php echo $content; ?>
    </div>

    <script>
        const menuButton = document.getElementById('menuButton');
        const dropdown = document.getElementById('dropdown-menu');

        menuButton.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });

        function toggleDropdown() {
            dropdown.classList.toggle('hidden');
        }
    </script>
</body>

</html>
