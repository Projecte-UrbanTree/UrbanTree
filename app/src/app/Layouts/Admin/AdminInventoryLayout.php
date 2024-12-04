<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . ' - ' . htmlspecialchars(getenv('APP_NAME'), ENT_QUOTES, 'UTF-8'); ?>
    </title>
    <script src="/assets/js/app.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav class="flex items-center justify-between px-4 py-10 h-16 border-2 border-slate-300">
        <!--Menu movil-->
        <button class="md:hidden text-gray-700 hover:text-blue-600" id="menuButton">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                stroke="currentColor" class="h-8 w-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M3 12h18M3 19h18" />
            </svg>
        </button>
        <!-- Logo -->
        <a class="hidden md:block" href="#">
            <img class="h-10" src="/assets/images/logotip-horizontal.png" alt="Urbantree logo">
        </a>
        <a class="block md:hidden" href="#">
            <img class="h-10" src="/assets/images/isotip.png" alt="Urbantree logo">
        </a>

        <!-- Enlaces de navegación -->
        <div class="hidden md:flex gap-4 ml-20">
            <a href="http://localhost:8000/admin/inventory"
                class="text-gray-700 font-bold hover:text-blue-600 text-lg">Inventario</a>
            <a href="http://localhost:8000/admin/management"
                class="text-gray-300 font-bold hover:text-blue-600 text-lg">Gestión</a>
        </div>

        <!-- Icono de notificaciones y Avatar del usuario -->
        <div class="flex items-center gap-4">
            <!-- Icono de notificación -->
            <a href="#" class="hidden md:block text-gray-700 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </a>


            <!-- Contractes -->
            <div class="relative inline-block text-left">
                <div>
                    <button type="button"
                        class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                        id="menu-button" aria-expanded="false" aria-haspopup="true" onclick="toggleDropdown()">
                        Contratos
                        <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Dropdown contractes -->
                <div id="dropdown-menu"
                    class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                    role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                            id="menu-item-0">Edit</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                            id="menu-item-1">Duplicate</a>
                    </div>
                    <div class="py-1" role="none">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                            id="menu-item-2">Archive</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                            id="menu-item-3">Move</a>
                    </div>
                    <div class="py-1" role="none">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                            id="menu-item-4">Share</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                            id="menu-item-5">Add to favorites</a>
                    </div>
                    <div class="py-1" role="none">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                            id="menu-item-6">Delete</a>
                    </div>
                </div>
            </div>

            <!-- Avatar y nombre del usuario -->
            <div class="flex items-center gap-2">
                <img class="h-12 w-12 rounded-full" src="/assets/images/avatar.png" alt="Avatar del usuario">
                <div class="hidden md:block text-sm">
                    <span
                        class="block font-semibold text-gray-700"><?php echo $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname']; ?></span>
                    <span class="block text-gray-500">
                        <?php
                        if ($_SESSION['user']['role'] == 2) {
                            echo "ADMINISTRADOR";
                        } elseif ($_SESSION['user']['role'] == 1) {
                            echo "USUARIO";
                        } else {
                            echo "Invitado";
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <!-- submenu -->

</body>

<script>
    const menuButton = document.getElementById('menuButton');
    const iconContainer = document.getElementById('iconContainer');
    menuButton.addEventListener('click', () => {
        iconContainer.classList.toggle('hidden');
    })
    function Image(image) {
        const icons = document.querySelectorAll('#iconContainer img');
        icons.forEach(icon => {
            if (icon.id === selectedId) {
                // Hacer el ícono seleccionado más oscuro
                icon.classList.add('text-gray-800');
                icon.classList.remove('text-gray-400');
            } else {
                // Hacer los otros íconos menos destacados
                icon.classList.add('text-gray-400');
                icon.classList.remove('text-gray-800');
            }
        });
    }
</script>


</html>