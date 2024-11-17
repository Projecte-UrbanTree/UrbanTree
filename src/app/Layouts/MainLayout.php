<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title . ' - ' . getenv('APP_NAME'); ?></title>
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
                <a href="/" class="block py-2 px-4 text-white hover:bg-gray-700">Home</a>
                <a href="#" class="block py-2 px-4 text-white hover:bg-gray-700">Example 1</a>
                <a href="#" class="block py-2 px-4 text-white hover:bg-gray-700">Example 2</a>
            </nav>
        </aside>

        <!-- Main content area -->
        <div class="flex-1 flex flex-col">
            <!-- Top bar -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <div class="text-xl font-bold"><?php echo $title; ?></div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, User</span>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded">Logout</button>
                </div>
            </header>

            <!-- Content area -->
            <main class="flex-grow p-6">
                <?= $content ?>
            </main>
        </div>
    </div>

</body>

</html>