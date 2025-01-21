<?php

use App\Core\Session;

?>

<?php $title = getenv('APP_NAME'); ?>

<?php if (Session::has('error')) { ?>
    <div class="bg-red-600 text-white px-4 py-3 rounded mb-6" role="alert">
        <strong class="font-semibold">Error: </strong>
        <span><?= htmlspecialchars(Session::get('error')); ?></span>
    </div>
<?php } ?>

<form action="/auth/login" method="POST" class="space-y-6">
    <div>
        <label for="email" class="block text-sm font-medium text-gray-800">Correo electrónico</label>
        <input type="email" id="email" name="email" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
            value="customer@urbantree.com"
            placeholder="tucorreo@ejemplo.com">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-800">Contraseña</label>
        <input type="password" id="password" name="password" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
            value="demopass"
            placeholder="••••••••">
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember_me" name="remember_me" type="checkbox"
                class="h-4 w-4 text-primary focus:ring-primary-500 border-gray-300 rounded">
            <label for="remember_me" class="ml-2 text-sm text-gray-900">Recuérdame</label>
        </div>
    </div>

    <div>
        <button type="submit"
            class="w-full bg-primary hover:bg-primaryDark text-white font-medium py-2 px-4 rounded">
            Iniciar sesión
        </button>
    </div>
</form>
