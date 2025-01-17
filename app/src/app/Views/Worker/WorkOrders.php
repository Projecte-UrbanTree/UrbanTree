<div class="mt-8 max-w-3xl mx-auto p-8 border rounded-lg shadow-lg bg-white text-center">
    <h1 class="text-4xl font-bold mb-6 text-gray-800">Órdenes de Trabajo</h1>

    <!-- Date picker -->
    <div class="flex items-center justify-center mb-6 space-x-4">
        <button id="prev-day" class="bg-blue-500 text-white rounded-full p-3 hover:bg-blue-600 shadow-md">
            <i class="fas fa-chevron-left"></i>
        </button>

        <input type="date" id="date-input"
               class="text-center border border-gray-300 rounded-lg py-2 px-4 w-48 focus:ring-2 focus:ring-blue-500 focus:outline-none"
               value="<?= htmlspecialchars($date ?? date('Y-m-d')) ?>" />

        <button id="next-day" class="bg-blue-500 text-white rounded-full p-3 hover:bg-blue-600 shadow-md">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <?php if (!empty($work_orders)): ?>
        <?php foreach ($work_orders as $work_order): ?>
            <?php $work_report = $work_order->report(); ?>

            <div class="mt-6">
                <p class="text-lg font-semibold">Usuarios asignados:</p>
                <input type="text" readonly
                       class="text-center border border-gray-300 rounded-md py-2 px-4 w-full mt-2 bg-gray-100"
                       value="<?= implode(', ', array_map(fn ($user) => $user->name.' '.$user->surname, $work_order->users())) ?>" />
            </div>

            <?php $blockCounter = 1; ?>
            <?php foreach ($work_order->blocks() as $block): ?>
                <div class="mt-8 p-6 border rounded-lg shadow-md bg-white">
                    <p class="text-lg font-semibold text-gray-800">Bloque <?= $blockCounter++ ?></p>

                    <!-- Tasktype and Species -->
                    <div>
                        <p class="text-lg font-semibold text-gray-800">Tipo de Tareas</p>
                        <ul class="list-disc list-inside">
                            <?php foreach ($block->tasks() as $blockTask): ?>
                                <li class="flex items-center space-x-2">
                                    <input type="checkbox"
                                           class="task-checkbox form-checkbox text-blue-500 rounded-md focus:ring-2 focus:ring-blue-400"
                                           data-task-id="<?= $blockTask->getId() ?>"
                                           value="1"
                                           <?= $blockTask->status == 1 ? 'checked' : '' ?>
                                    />
                                    <span>
                                        <?= htmlspecialchars($blockTask->task()->name) ?>
                                        <?php echo htmlspecialchars(' '.$blockTask->elementType()->name); ?>
                                        <?php if ($blockTask->treeType() != null): ?>
                                            : <?= htmlspecialchars($blockTask->treeType()->species) ?>
                                        <?php endif; ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Notes -->
                    <div class="mt-4">
                        <p class="text-lg font-semibold text-gray-800">Notas:</p>
                        <p class="mt-2 text-gray-700 bg-gray-100 rounded-md p-3 shadow-sm">
                            <?= htmlspecialchars($block->notes) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>

            <form id="work-reportForm-<?= $work_order->getId() ?>" method="POST" action="/worker/work-orders/store-report">
                <input type="hidden" name="work_order_id" value="<?= $work_order->getId() ?>">
                <h1 class="text-4xl font-bold my-6 text-gray-800">Parte de Trabajo</h1>

                <?php $blockCounter = 1; ?>
                <?php foreach ($work_order->blocks() as $block): ?>
                    <div class="mt-8 p-6 border rounded-lg shadow-md bg-white">
                        <p class="text-lg font-semibold text-gray-800">Bloque <?= $blockCounter++ ?></p>
                        <div>
                            <p class="text-lg font-semibold text-gray-800">Tipo de Tareas</p>
                            <ul class="list-disc list-inside">
                                <?php foreach ($block->tasks() as $blockTask): ?>
                                    <li class="flex items-center space-x-2">
                                        <?= htmlspecialchars($blockTask->task()->name) ?>
                                        <?php echo htmlspecialchars(" " . $blockTask->elementType()->name); ?>
                                        <?php if ($blockTask->treeType() != null): ?>
                                            : <?= htmlspecialchars($blockTask->treeType()->species) ?>
                                        <?php endif; ?>

                                        <!-- Dedicated Hours -->
                                        <label for="spent_time-<?= $blockTask->getId() ?>"
                                               class="ml-4 text-gray-800">Horas:</label>
                                        <input type="time"
                                               id="spent_time-<?= $blockTask->getId() ?>"
                                               name="spent_time[<?= $blockTask->getId() ?>]"
                                               value="<?= $blockTask->spent_time ?>"
                                               class="text-center border border-gray-300 rounded-md py-1 px-2 w-20 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div>
                    <label for="spent_fuel">
                        <p class="text-lg font-semibold text-gray-800">Combustible:</p>
                    </label>
                    <input 
                        type="number"
                        step="0.01"
                        id="spent_fuel"
                        name="spent_fuel"
                        value="<?= number_format($work_report->spent_fuel ?? 0.0, 2, '.', '') ?>"
                        class="text-center border border-gray-300 rounded-md py-2 px-4 w-full mt-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Litros de combustible"
                        required
                    />
                </div>

                <div>
                    <p class="text-lg font-semibold text-gray-800">Recursos:</p>
                    <?php
                    $resourcesByType = [];
                    foreach ($resources as $resource) {
                        $resourcesByType[$resource->resourceType()->name][] = $resource;
                    }
                    ?>

                    <?php foreach ($resourcesByType as $typeName => $resourcesList): ?>
                        <div class="mt-4">
                            <label for="resource_<?= htmlspecialchars($typeName) ?>" class="block text-gray-800 font-medium">
                                <?= htmlspecialchars($typeName) ?>
                            </label>

                            <div class="relative">
                                <button type="button" class="relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="toggleDropdown('dropdown-<?= htmlspecialchars($typeName) ?>')">
                                    <span id="selected-<?= htmlspecialchars($typeName) ?>">Seleccione recursos...</span>
                                    <svg class="absolute top-1/2 end-3 -translate-y-1/2 shrink-0 size-3.5 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/>
                                    </svg>
                                </button>
                                <div id="dropdown-<?= htmlspecialchars($typeName) ?>" class="hidden mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto">
                                    <?php foreach ($resourcesList as $resource): ?>
                                        <div onclick="toggleSelection('<?= htmlspecialchars($resource->name) ?>', '<?= htmlspecialchars($resource->getId()) ?>', '<?= htmlspecialchars($typeName) ?>')" class="py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100">
                                            <span><?= htmlspecialchars($resource->name) ?></span>
                                            <span id="check-<?= htmlspecialchars($resource->getId()) ?>" class="hidden">
                                                <svg class="shrink-0 size-3.5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <select id="resource_<?= htmlspecialchars($typeName) ?>" name="resource_id[]" class="hidden" multiple>
                                    <?php foreach ($resourcesList as $resource): ?>
                                        <option value="<?= htmlspecialchars($resource->getId()) ?>"><?= htmlspecialchars($resource->name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div>
                    <p class="text-lg font-semibold text-gray-800">Observaciones:</p>
                    <textarea name="observation" class="block w-full p-2.5 text-sm text-gray-800 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none mt-2" rows="4" placeholder="Escribe aquí tus observaciones..."><?= htmlspecialchars($work_report->observation) ?></textarea>
                </div>

                <button
                    type="submit"
                    class="btn-submit mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 w-full"
                    data-workorder-id="<?= $work_order->getId() ?>"
                >
                    Enviar Parte de Trabajo
                </button>
            </form>

        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-600 mt-6">No hay órdenes de trabajo para esta fecha.</p>
    <?php endif; ?>
</div>
