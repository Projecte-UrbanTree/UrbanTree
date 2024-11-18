<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $title . ' - ' . getenv('APP_NAME'); ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 flex-shrink-0">
            <div class="text-white text-2xl font-bold p-4 border-b border-gray-700">
                <?php echo getenv('APP_NAME'); ?>
            </div>
            <nav class="mt-4">
                <?php
                // Get the current path
                $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        ?>

                <a href="/"
                    class="block py-2 px-4 text-white hover:bg-gray-700 <?php echo $currentPath === '/' ? 'bg-gray-700' : ''; ?>">
                    Dashboard
                </a>
                <a href="/users"
                    class="block py-2 px-4 text-white hover:bg-gray-700 <?php echo $currentPath === '/users' ? 'bg-gray-700' : ''; ?>">
                    Manage Users
                </a>
                <a href="/work-orders"
                    class="block py-2 px-4 text-white hover:bg-gray-700 <?php echo $currentPath === '/work-orders' ? 'bg-gray-700' : ''; ?>">
                    Manage Work Orders
                </a>
                <a href="/zones"
                    class="block py-2 px-4 text-white hover:bg-gray-700 <?php echo $currentPath === '/zones' ? 'bg-gray-700' : ''; ?>">
                    Manage Zones
                </a>
                <a href="/tree-types"
                    class="block py-2 px-4 text-white hover:bg-gray-700 <?php echo $currentPath === '/tree-types' ? 'bg-gray-700' : ''; ?>">
                    Tree Types
                </a>
            </nav>
        </aside>

        <!-- Main content area -->
        <div class="flex-1 flex flex-col">
            <!-- Top bar -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <div class="text-xl font-bold"><?php echo $title; ?>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome,
                        <?php echo $_SESSION['user']['name']; ?></span>
                    <a href="/logout"
                        class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500">
                        Logout</a>
                </div>
            </header>

            <!-- Content area -->
            <main class="flex-grow p-6 overflow-auto">
                <?php echo $content; ?>
            </main>
        </div>
    </div>

    <!-- Javascript, add class d-none to alert-msg after 5 seconds if it exists -->
    <script>
        setTimeout(() => {
            console.log('Hide alert message');
            const alertMsg = document.getElementById('alert-msg');
            if (alertMsg) {
                alertMsg.classList.add('hidden');
            }
        }, 3500);
    </script>

</body>

</html>
