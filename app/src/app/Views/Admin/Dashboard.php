<div class="p-6">
    <!-- Page Title -->
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Tablero</h1>
        <p class="text-sm text-gray-600">¡Le damos nuevamente la bienvenida,
            <?= $_SESSION['user']['name'] . " " . $_SESSION['user']['surname']; ?>,
            a su tablero! A continuación te ofrecemos una rápida visión general de tus datos.
        </p>
    </div>

    <!-- Scrollable Content -->
    <div class="overflow-x-auto">
        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Widget 1 -->
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-700">Usuarios</h2>
                <p class="mt-2 text-3xl font-bold"><?= $users ?></p>
                <p class="text-sm text-gray-500 mt-1">+0% que el anterior periodo</p>
            </div>

            <!-- Widget 3 -->
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-700">Contratos</h2>
                <p class="mt-2 text-3xl font-bold"><?= $contracts ?></p>
                <p class="text-sm text-gray-500 mt-1">+0% que el anterior periodo</p>
            </div>

            <!-- Widget 2 -->
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-700">Elementos</h2>
                <p class="mt-2 text-3xl font-bold"><?= $elements ?></p>
                <p class="text-sm text-gray-500 mt-1">+0% que el anterior periodo</p>
            </div>

            <!-- Widget 3 -->
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-700">Órdenes de trabajo</h2>
                <p class="mt-2 text-3xl font-bold"><?= $workorders ?></p>
                <p class="text-sm text-gray-500 mt-1">+0% que el anterior periodo</p>
            </div>
        </div>
    </div>
</div>