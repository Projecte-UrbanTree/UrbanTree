<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $title . ' - ' . getenv('APP_NAME'); ?>
    </title>
    <script src="/assets/js/app.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 flex-shrink-0">
            <div class="text-white text-2xl font-bold p-4 border-b border-gray-700">
                <?php echo getenv('APP_NAME'); ?>
            </div>
            <nav class="mt-4">
                <?php $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
                <a href="/dashboard"
                    class="block py-2 px-4 text-white hover:bg-gray-700 <?php echo $currentPath === '/' ? 'bg-gray-700' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 inline">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                    </svg>

                    Dashboard
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
                        <?php echo $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname']; ?></span>
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
            const alertMsg = document.getElementById('alert-msg');
            if (alertMsg) {
                alertMsg.classList.add('hidden');
            }
        }, 3500);
    </script>

</body>

</html>
