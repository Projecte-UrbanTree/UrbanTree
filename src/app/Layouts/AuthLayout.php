<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title . ' - ' . getenv('APP_NAME'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal flex items-center justify-center h-screen">

    <!-- Auth content area -->
    <div class="w-full max-w-md bg-white shadow-md rounded p-6">
        <header class="text-center mb-6">
            <h1 class="text-2xl font-bold"><?php echo $title; ?></h1>
        </header>

        <!-- Main content area for auth forms -->
        <main>
            <?= $content ?>
        </main>
    </div>

</body>

</html>