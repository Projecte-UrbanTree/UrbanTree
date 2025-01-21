<?php

use App\Core\Session;

?>

<!-- Page Title Card -->
<div class="bg-white rounded p-6 mb-8 border border-gray-200">
    <div class="flex items-center space-x-4">
        <span class="text-4xl text-gray-800">👋</span>
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Bienvenido de nuevo,
                <?= Session::get('user')['name'].' '.Session::get('user')['surname']; ?>.
            </h1>
            <p class="text-base text-gray-500 mt-2">Te damos la bienvenida a tu tablero. Aquí tienes un resumen
                rápido de tus datos.</p>
        </div>
    </div>
</div>

<!-- Dashboard Widgets -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <!-- Widget 1: Usuarios -->
    <div
        class="bg-white rounded p-6 flex flex-col items-center justify-center text-center border border-gray-200">
        <div class="text-gray-600 mb-4">
            <i class="fas fa-users fa-lg"></i>
        </div>
        <h2 class="text-lg font-medium text-gray-800">Usuarios</h2>
        <p class="mt-3 text-3xl font-semibold text-gray-900"><?= $users ?></p>
    </div>

    <!-- Widget 2: Contratos -->
    <div
        class="bg-white rounded p-6 flex flex-col items-center justify-center text-center border border-gray-200">
        <div class="text-gray-600 mb-4">
            <i class="fas fa-file-contract fa-lg"></i>
        </div>
        <h2 class="text-lg font-medium text-gray-800">Contratos</h2>
        <p class="mt-3 text-3xl font-semibold text-gray-900"><?= $contracts ?></p>
    </div>

    <!-- Widget 3: Elementos -->
    <div
        class="bg-white rounded p-6 flex flex-col items-center justify-center text-center border border-gray-200">
        <div class="text-gray-600 mb-4">
            <i class="fas fa-cogs fa-lg"></i>
        </div>
        <h2 class="text-lg font-medium text-gray-800">Elementos</h2>
        <p class="mt-3 text-3xl font-semibold text-gray-900"><?= $elements ?></p>
    </div>

    <!-- Widget 4: Órdenes de trabajo -->
    <div
        class="bg-white rounded p-6 flex flex-col items-center justify-center text-center border border-gray-200">
        <div class="text-gray-600 mb-4">
            <i class="fas fa-briefcase fa-lg"></i>
        </div>
        <h2 class="text-lg font-medium text-gray-800">Órdenes de trabajo</h2>
        <p class="mt-3 text-3xl font-semibold text-gray-900"><?= $workorders ?></p>
    </div>
</div>
