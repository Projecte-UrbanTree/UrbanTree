<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo htmlspecialchars($title).' - '.htmlspecialchars(getenv('APP_NAME')); ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal flex items-center justify-center h-screen">

    <!-- Auth content area -->
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-gray-800">
                <?php echo htmlspecialchars($title); ?></h1>
        </header>

        <!-- Main content -->
        <main>
            <?php echo $content; ?>
        </main>
    </div>

</body>

</html>
