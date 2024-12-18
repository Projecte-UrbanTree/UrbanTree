<?php
use App\Core\Session;

?>

<?php $title = getenv('APP_NAME'); ?>

<?php if (Session::has('error')) { ?>
    <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-6" role="alert">
        <strong class="font-bold">Error: </strong>
        <span><?= htmlspecialchars(Session::get('error')); ?></span>
    </div>
<?php } ?>

<form action="/auth/login" method="POST" class="space-y-6">
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" required value="jose.rodriguez@example.com"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            placeholder="you@example.com">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required value="demopass"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            placeholder="••••••••">
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember_me" name="remember_me" type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <label for="remember_me" class="ml-2 text-sm text-gray-900">Remember me</label>
        </div>
    </div>

    <div>
        <button type="submit"
            class="w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500">
            Sign in
        </button>
    </div>
</form>