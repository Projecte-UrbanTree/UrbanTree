<?php $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title . ' - ' . getenv('APP_NAME'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <script src="/assets/js/tailwind.js"></script>
    <script src="https://kit.fontawesome.com/f80b94bd90.js" crossorigin="anonymous"></script>
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
                    class="menu-link <?php echo (strpos($currentPath, '/admin') === 0 && strpos($currentPath, '/admin/inventory') === false) ? 'active' : ''; ?>">
                    Gestión
                </a>
                <a href="/admin/inventory"
                    class="menu-link <?php echo ($currentPath === '/admin/inventory') ? 'active' : ''; ?>">
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
                        <span class="block text-gray-700"><?php echo $_SESSION['user']['name']; ?></span>
                        <span class="block text-gray-500">
                            <?php echo ($_SESSION['user']['role'] == 2) ? 'ADMINISTRADOR' : 'USUARIO'; ?>
                        </span>
                        <div id="profile-dropdown"
                            class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-800"
                                    role="menuitem" tabindex="-1" id="menu-item-0">Account settings</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-1">Support</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                    id="menu-item-2">License</a>
                                <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-800"
                                    role="menuitem" tabindex="-1" id="menu-item-3">Sign out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- Submenu Section (Hidden by default on small screens, visible on medium and larger screens) -->
    <?php if ($currentPath !== '/admin/inventory') { ?>
        <div id="submenu"
            class="md:flex overflow-x-auto justify-center items-center gap-6 p-6 shadow-md sm:shadow-none px-2 py-1 sm:py-4">
            <!-- class="md:flex hidden overflow-x-auto whitespace-nowrap justify-start items-center gap-4 p-4 shadow-md sm:shadow-none px-2 py-1 sm:py-4"> -->

            <div class="submenu text-center flex items-center space-x-6">
                <!-- Contracts -->
                <div class="submenu-item">
                    <a href="/admin/contracts"
                        class="link-primary <?php echo ($currentPath == '/admin/contracts') ? 'active' : ''; ?>">
                        <i class="fas fa-file-contract block"></i>
                        <span class="text-sm font-medium whitespace-nowrap">Contratos</span>
                    </a>
                </div>

                <!-- Work Orders-->
                <div class="submenu-item">
                    <a href="/admin/work-orders"
                        class="link-primary <?php echo ($currentPath == '/admin/work-orders') ? 'active' : ''; ?>">
                        <i class="fas fa-briefcase md:block"></i>
                        <span class="text-sm font-medium whitespace-nowrap">Orden de Trabajo</span>
                    </a>
                </div>

                <!-- Zones -->
                <div class="submenu-item">
                    <a href="/admin/zones"
                        class="link-primary <?php echo ($currentPath == '/admin/zones') ? 'active' : ''; ?>">
                        <i class="fas fa-map-marker-alt md:block"></i>
                        <span class="text-sm font-medium whitespace-nowrap">Zonas</span>
                    </a>
                </div>

                <!-- Elements -->
                <div class="submenu-item">
                    <a href="/admin/elements"
                        class="link-primary <?php echo ($currentPath == '/admin/elements') ? 'active' : ''; ?>">
                        <i class="fas fa-cube md:block"></i>
                        <span class="text-sm font-medium whitespace-nowrap">Elementos</span>
                    </a>
                </div>

                <!-- Task Types -->
                <div class="submenu-item">
                    <a href="/admin/task-types"
                        class="link-primary <?php echo ($currentPath == '/admin/task-types') ? 'active' : ''; ?>">
                        <i class="fas fa-tasks md:block"></i>
                        <span class="text-sm font-medium whitespace-nowrap">Tipo Tarea</span>
                    </a>
                </div>

                <!-- Users -->
                <div class="submenu-item">
                    <a href="/admin/users"
                        class="link-primary <?php echo ($currentPath == '/admin/users') ? 'active' : ''; ?>">
                        <i class="fas fa-users md:block"></i>
                        <span class="text-sm font-medium whitespace-nowrap">Usuarios</span>
                    </a>
                </div>

                <!-- Partes -->
                <div class="submenu-item">
                    <a href="/admin/work-reports"
                        class="link-primary <?php echo ($currentPath == '/admin/work-reports') ? 'active' : ''; ?>">
                        <i class="fas fa-clipboard-list md:block"></i>
                        <span class="text-sm font-medium whitespace-nowrap">Partes</span>
                    </a>
                </div>

                <!-- Stats -->
                <div class="submenu-item">
                    <a href="/admin/stats"
                        class="link-primary <?php echo ($currentPath == '/admin/stats') ? 'active' : ''; ?>">
                        <i class="fas fa-chart-bar md:block"></i>
                        <span class="text-sm font-medium whitespace-nowrap">Estadísticas</span>
                    </a>
                </div>
            </div>


        </div>
    <?php } ?>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6">
        <?php echo $content; ?>
    </div>

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
</body>

</html>