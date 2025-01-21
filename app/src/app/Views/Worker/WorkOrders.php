<div class="mb-6">
    <h1 class="text-2xl flex items-center font-semibold text-gray-800 mb-4">
        <i class="fas fa-tasks mr-2"></i> Órdenes de Trabajo
    </h1>

    <!-- Date picker -->
    <div class="flex items-center justify-center space-x-4 mb-6">
        <button
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none"
            id="prev-day">
            <i class="fas fa-chevron-left"></i>
        </button>
        <input
            type="date"
            class="w-full px-4 py-2 md:w-48 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 text-center"
            id="date-input"
            value="<?= htmlspecialchars($date ?? date('Y-m-d')) ?>" required />
        <button
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none"
            id="next-day">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <?php if (! empty($work_orders)) { ?>
        <?php foreach ($work_orders as $work_order) { ?>
            <?php $work_report = $work_order->report(); ?>
            <?php $usedJson = htmlspecialchars(json_encode($work_report_resources[$work_order->getId()] ?? []), ENT_QUOTES); ?>
            <div hidden id="used-res-<?= $work_order->getId(); ?>" data-used="<?= $usedJson ?>"></div>

            <div class="bg-white p-6 border border-gray-200 rounded mb-8">
                <p class="text-lg font-semibold text-gray-800">Usuarios asignados:</p>
                <input type="text" readonly
                    class="text-center border border-gray-300 rounded-md py-2 px-4 w-full mt-2 bg-gray-100"
                    value="<?= implode(', ', array_map(fn ($user) => $user->name.' '.$user->surname, $work_order->users())) ?>" required />

                <?php $blockCounter = 1; ?>
                <?php foreach ($work_order->blocks() as $block) { ?>
                    <div class="mt-8 p-6 border border-gray-200 rounded bg-white">
                        <p class="text-lg font-semibold text-gray-800">Bloque <?= $blockCounter++ ?></p>

                        <!-- Tasktype and Species -->
                        <div>
                            <p class="text-lg font-semibold text-gray-800">Tipo de Tareas</p>
                            <ul class="list-disc list-inside">
                                <?php foreach ($block->tasks() as $blockTask) { ?>
                                    <li class="flex items-center space-x-2">
                                        <input type="checkbox"
                                            class="task-checkbox form-checkbox text-blue-500 rounded-md focus:ring-2 focus:ring-blue-400"
                                            data-task-id="<?= $blockTask->getId() ?>"
                                            value="1"
                                            <?= $blockTask->status == 1 ? 'checked' : '' ?>
                                            <?= $work_report ? 'disabled' : '' ?> />
                                        <span>
                                            <?= htmlspecialchars($blockTask->task()->name) ?>
                                            <?= htmlspecialchars(' '.$blockTask->elementType()->name); ?>
                                            <?php if ($blockTask->treeType() != null) { ?>
                                                : <?= htmlspecialchars($blockTask->treeType()->species) ?>
                                            <?php } ?>
                                        </span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <!-- Notes -->
                        <div class="mt-4">
                            <p class="text-lg font-semibold text-gray-800">Notas:</p>
                            <?php if (! empty($block->notes)) { ?>
                                <p class="mt-2 text-gray-700 bg-gray-100 rounded-md p-3">
                                    <?= htmlspecialchars($block->notes) ?>
                                </p>
                            <?php } else { ?>
                                <p class="mt-2 text-gray-700 bg-gray-100 rounded-md p-3">
                                    No hay notas disponibles.
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <form id="work-reportForm-<?= $work_order->getId() ?>" method="POST" action="/worker/work-orders/store-report" class="mt-6 bg-white border border-gray-200 rounded p-6" onsubmit="return confirm('¿Estás seguro de que deseas enviar el parte de trabajo?');" <?= $work_order_reports[$work_order->getId()] ? 'disabled' : '' ?>>
                    <input type="hidden" name="work_order_id" value="<?= $work_order->getId() ?>">
                    <h1 class="text-2xl font-bold my-4 text-gray-800 flex items-center">
                        <i class="fas fa-clipboard-list mr-2"></i> Parte de Trabajo
                    </h1>

                    <?php $blockCounter = 1; ?>
                    <?php foreach ($work_order->blocks() as $block) { ?>
                        <div class="mt-8 p-6 border border-gray-200 rounded bg-white">
                            <p class="text-lg font-semibold text-gray-800">Bloque <?= $blockCounter++ ?></p>
                            <div>
                                <p class="text-lg font-semibold text-gray-800">Tipo de Tareas</p>
                                <ul class="list-disc list-inside">
                                    <?php foreach ($block->tasks() as $blockTask) { ?>
                                        <li class="flex items-center space-x-2">
                                            <?= htmlspecialchars($blockTask->task()->name) ?>
                                            <?= htmlspecialchars(' '.$blockTask->elementType()->name); ?>
                                            <?php if ($blockTask->treeType() != null) { ?>
                                                : <?= htmlspecialchars($blockTask->treeType()->species) ?>
                                            <?php } ?>

                                            <!-- Dedicated Hours -->
                                            <label for="spent_time-<?= $blockTask->getId() ?>"
                                                class="ml-4 text-gray-800">Horas:</label>
                                            <input type="time"
                                                id="spent_time-<?= $blockTask->getId() ?>"
                                                name="spent_time[<?= $blockTask->getId() ?>]"
                                                value="<?= $blockTask->spent_time ?>"
                                                class="text-center border border-gray-300 rounded-md py-1 px-2 w-32 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                                <?= $work_report ? 'disabled' : '' ?> required>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="mt-4">
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
                            <?= $work_report ? 'disabled' : '' ?> required />
                    </div>

                    <div class="mt-4">
                        <p class="text-lg font-semibold text-gray-800">Recursos:</p>
                        <?php
                        $resourcesByType = [];
            foreach ($resources as $resource) {
                $resourcesByType[$resource->resourceType()->name][] = $resource;
            }
            ?>

                        <?php foreach ($resourcesByType as $typeName => $resourcesList) { ?>
                            <div class="mt-4">
                                <label for="resource_<?= htmlspecialchars($typeName) ?>" class="block text-gray-800 font-medium">
                                    <?= htmlspecialchars($typeName) ?>
                                </label>

                                <div class="relative">
                                    <button
                                        type="button"
                                        class="relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        data-resource-type="<?= htmlspecialchars($typeName) ?>"
                                        onclick="toggleDropdown('dropdown-<?= htmlspecialchars($typeName) ?>')"
                                        <?= $work_report ? 'disabled' : '' ?>>
                                        <span id="selected-<?= htmlspecialchars($typeName) ?>">Seleccione recursos...</span>
                                        <svg class="absolute top-1/2 end-3 -translate-y-1/2 shrink-0 size-3.5 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m7 15 5 5 5-5" />
                                            <path d="m7 9 5-5 5 5" />
                                        </svg>
                                    </button>
                                    <div id="dropdown-<?= htmlspecialchars($typeName) ?>" class="hidden mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded overflow-hidden overflow-y-auto">
                                        <?php foreach ($resourcesList as $resource) { ?>
                                            <div onclick="toggleSelection('<?= htmlspecialchars($resource->name) ?>', '<?= htmlspecialchars($resource->getId()) ?>', '<?= htmlspecialchars($typeName) ?>')" class="py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded focus:outline-none focus:bg-gray-100">
                                                <span><?= htmlspecialchars($resource->name) ?></span>
                                                <span id="check-<?= htmlspecialchars($resource->getId()) ?>" class="hidden">
                                                    <svg class="shrink-0 size-3.5 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="20 6 9 17 4 12" />
                                                    </svg>
                                                </span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <select id="resource_<?= htmlspecialchars($typeName) ?>" name="resource_id[]" class="hidden" multiple <?= $work_report ? 'disabled' : '' ?>>
                                        <?php foreach ($resourcesList as $resource) { ?>
                                            <option value="<?= htmlspecialchars($resource->getId()) ?>"><?= htmlspecialchars($resource->name) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="mt-4">
                        <p class="text-lg font-semibold text-gray-800">Observaciones:</p>
                        <textarea name="observation" class="w-full p-2.5 text-sm text-gray-800 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 mt-2" rows="4" placeholder="Escribe aquí tus observaciones..." <?= $work_report ? 'disabled' : '' ?> required><?= htmlspecialchars($work_report->observation ?? '') ?></textarea>
                    </div>

                    <?php if ($work_report) { ?>
                        <p class="text-green-600 mt-4">El parte de trabajo ya ha sido enviado.</p>
                    <?php } else { ?>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 w-full mt-4 transition-all duration-200 flex items-center justify-center space-x-2">
                            <i class="fas fa-paper-plane"></i>
                            <span>Enviar Parte de Trabajo</span>
                        </button>
                    <?php } ?>
                </form>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="text-gray-600 mt-6">No hay órdenes de trabajo para esta fecha.</p>
    <?php } ?>
</div>
