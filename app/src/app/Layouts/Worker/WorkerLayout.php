<?php
use App\Core\Session;
use App\Models\User;

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title . ' - ' . getenv('APP_NAME'); ?></title>

    <!-- Tailwind / CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <script src="/assets/js/tailwind.js"></script>

    <!-- Iconos -->
    <script src="https://kit.fontawesome.com/f80b94bd90.js" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</head>

<body class="w-full min-h-screen flex flex-col">

    <!-- Navigation Bar -->
    <div class="border-b border-softGray">
        <nav class="flex items-center px-2 py-4 h-16 max-w-7xl mx-auto justify-between">

            <!-- Logo -->
            <a href="/worker" class="basis-1/5 flex items-center">
                <img class="hidden md:block w-48" src="/assets/images/logotip-horizontal.png" alt="Logo">
                <img class="md:hidden block w-12" src="/assets/images/resized-isotip.png" alt="Logo">
            </a>

            <div class="flex gap-3 md:gap-6 justify-center">
                <a href="/worker/inventory" class="menu-link text-sm sm:text-lg align-middle 
                          <?= (strpos($currentPath, '/worker/inventory') === 0) ? 'active' : ''; ?>">
                    Inventario
                </a>
                <a href="/worker/orders" class="menu-link text-sm sm:text-lg align-middle
                          <?= (strpos($currentPath, '/worker/orders') === 0) ? 'active' : ''; ?>">
                    Órdenes
                </a>
            </div>

            <!-- User Section -->
            <div class="flex items-center gap-4 basis-1/5 justify-end">
                <a href="#" class="hidden md:block text-gray-700 hover:text-blue-600">
                    <lord-icon src="https://cdn.lordicon.com/vspbqszr.json" trigger="hover" state="loop-bell"
                        colors="primary:#747474" style="width:28px;height:28px">
                    </lord-icon>
                </a>

                <!-- User Avatar y Dropdown -->
                <div class="relative flex items-center gap-2 cursor-pointer"
                    onclick="profileDropdown.classList.toggle('hidden')">
                    <img class="h-10 rounded-full" style="width: 25px; height: 25px" src="/assets/images/avatar.png"
                        alt="User Avatar">
                    <div class="hidden md:block text-sm relative">
                        <span class="block text-gray-700">
                            <?= $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname']; ?>
                        </span>
                        <span class="block text-gray-500">
                            <?= User::role_name($_SESSION['user']['role']); ?>
                        </span>
                        <div id="profile-dropdown" class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right
                                    rounded-md bg-white shadow-lg ring-1 ring-black/5
                                    focus:outline-none" role="menu" aria-orientation="vertical"
                            aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="/worker/profile"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-800" role="menuitem"
                                    tabindex="-1">
                                    Mi Perfil
                                </a>
                                <a href="/worker/settings"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-800" role="menuitem"
                                    tabindex="-1">
                                    Configuración
                                </a>
                                <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-800"
                                    role="menuitem" tabindex="-1">
                                    Cerrar sesión
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </nav>
    </div>

<!-- main content -->
    <div class="max-w-7xl mx-auto px-6 py-4 flex-grow">
        <?php if (Session::has('success')): ?>
            <div id="alert-msg" class="bg-blue-500 text-white px-4 py-3 rounded-lg mb-6" role="alert">
                <strong class="font-bold">¡Éxito!</strong>
                <span><?= htmlspecialchars(Session::get('success')); ?></span>
            </div>
        <?php endif; ?>

        <?= $content; ?>
    </div>
    <!-- js dunno if i should put this on app.js or here -->
    <script src="/assets/js/app.js"></script>
    <script>
        setTimeout(() => {
            const alertMsg = document.getElementById('alert-msg');
            if (alertMsg) {
                alertMsg.classList.add('hidden');
            }
        }, 3500);

        const profileDropdown = document.getElementById('profile-dropdown');
    </script>
</body>

</html>