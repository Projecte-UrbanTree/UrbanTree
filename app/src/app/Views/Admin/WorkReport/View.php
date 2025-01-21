<div class="mb-4 flex justify-end">
    <a href="/admin/work-orders" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a órdenes de trabajo</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-200 rounded shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Detalles del Parte de Trabajo</h2>
    <?php if (! empty($report)) { ?>
        <!-- Usuarios asignados -->
        <div class="mt-6 border border-gray-200 p-4 rounded">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Usuarios Asignados</h3>
            <ul class="list-disc list-inside">
                <?php foreach ($report->workOrder()->users() as $user) { ?>
                    <li><?= htmlspecialchars($user->name.' '.$user->surname) ?></li>
                <?php } ?>
            </ul>
        </div>

        <!-- Recursos usados -->
        <div class="mt-6 border border-gray-200 p-4 rounded">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Recursos Usados</h3>
            <?php if (! empty($report->workReportResources())) { ?>
                <ul class="list-disc list-inside">
                    <?php foreach ($report->workReportResources() as $resource) { ?>
                        <li><?= htmlspecialchars($resource->resource()->name) ?> (<?= htmlspecialchars($resource->resource()->resourceType()->name) ?>)</li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p class="text-gray-600">No se encontraron recursos usados.</p>
            <?php } ?>
        </div>

        <!-- Tareas y horas dedicadas -->
        <div class="mt-6 border border-gray-200 p-4 rounded">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Tareas y Horas Dedicadas</h3>
            <?php foreach ($report->workOrder()->blocks() as $block) { ?>
                <div class="mb-4">
                    <h4 class="text-lg font-semibold text-gray-800">Bloque <?= $block->getId() ?></h4>
                    <ul class="list-disc list-inside">
                        <?php foreach ($block->tasks() as $task) { ?>
                            <li>
                                <?= htmlspecialchars($task->task()->name) ?> (<?= htmlspecialchars($task->elementType()->name) ?>)
                                <?php if ($task->treeType() != null) { ?>
                                    : <?= htmlspecialchars($task->treeType()->species) ?>
                                <?php } ?>
                                - Horas dedicadas: <?= htmlspecialchars($task->spent_time) ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>

        <!-- Observaciones -->
        <div class="mt-6 border border-gray-200 p-4 rounded">
            <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
            <p class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100"><?= htmlspecialchars($report->observation) ?></p>
        </div>

        <!-- Combustible gastado -->
        <div class="mt-6 border border-gray-200 p-4 rounded">
            <label class="block text-sm font-medium text-gray-700 mb-1">Combustible gastado</label>
            <p class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100"><?= htmlspecialchars($report->spent_fuel) ?> litros</p>
        </div>
    <?php } else { ?>
        <p>No se encontró parte de trabajo.</p>
    <?php } ?>
</div>
