<div class="mb-4 flex justify-end">
    <a href="/admin/work-orders"
        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500 flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a órdenes de trabajo</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Crear nueva órden de trabajo</h2>
    <form action="/admin/work-order/store" method="POST" class="space-y-6">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
            <input type="date" id="date" name="date"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <div>
            <label for="users" class="block text-sm font-medium text-gray-700 mb-1">Operarios</label>
            <input type="text" id="workersInput" readonly onclick="openModal('modalWorkers', 'workersInput')"
                placeholder="Seleccionar Operarios"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-pointer focus:outline-none">
        </div>

        <div class="flex justify-end">
            <button type="button" id="addBlocks" onclick="addBlock()"
                class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500">
                Agregar Bloques
            </button>
        </div>

        <div id="blocksContainer" class="space-y-6">
            <div class="border border-gray-300 rounded-lg shadow p-4 bg-gray-50">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Bloque 1</h3>
                    <button type="button" onclick="removeBlock(this)" class="text-red-500 hover:text-red-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>      
                <div>
                    <label for="zones" class="block text-sm font-medium text-gray-700 mb-1">Zonas</label>
                    <input type="text" id="zonesInput_1" readonly onclick="openModal('modalZones', 'zonesInput_1')"
                        placeholder="Seleccionar Zonas"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-pointer focus:outline-none">
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="addTask(this)"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500">
                        Agregar Tareas
                    </button>
                </div>
                <div class="tasksContainer space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Seleccionar Tareas</h3>
                    <div class="task-row flex space-x-4 items-end">
                        <!-- Dropdown Task Type -->
                        <div class="w-1/2">
                            <select name="taskType[]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                                <option value="" disabled selected>Seleccione una tarea</option>
                                <?php foreach ($task_types as $task_type) { ?>
                                    <option value="<?php echo htmlspecialchars($task_type->getId()); ?>">
                                        <?php echo htmlspecialchars($task_type->name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Dropdown Specie -->
                        <div class="w-1/2 flex items-center space-x-2">
                            <span class="block text-lg font-semibold text-gray-800">Species</span>
                            <select name="species[]"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                                <option value="" selected>Opcional</option>
                                <?php foreach ($tree_types as $tree_type) { ?>
                                    <option value="<?php echo htmlspecialchars($tree_type->getId()); ?>">
                                        <?php echo htmlspecialchars($tree_type->species); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Button Delete-->
                        <button type="button" onclick="removeTaskRow(this)"
                            class="text-red-500 hover:text-red-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                    <div>

                    </div>
                    <div class="mt-4">
                        <label for="notes_1"class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                        <textarea name="notes[]" id="notes_1" rows="4" placeholder="Añadir notas aquí..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                    </div>
                </div>
            </div>
        </div>
</div>

<div class="flex items-center">
    <button type="submit"
        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
        Crear
    </button>
</div>
</form>
</div>

<!-- MODAL workers -->
<div id="modalWorkers" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <h3 class="text-lg font-semibold mb-4">Seleccionar Operarios</h3>
        <div class="space-y-2">
            <?php foreach ($users as $user) { ?>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" value="<?php echo htmlspecialchars($user->getId()); ?>" class="form-checkbox">
                    <span><?php echo htmlspecialchars($user->name . " " . $user->surname); ?></span>
                </label>
            <?php } ?>
        </div>

        <div class="flex justify-end mt-4">
            <button onclick="saveSelection('modalWorkers')"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Aplicar
            </button>
            <button onclick="closeModal('modalWorkers')"
                class="ml-2 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">
                Cancelar
            </button>
        </div>
    </div>
</div>

<!-- MODAL Zones -->
<div id="modalZones" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <h3 class="text-lg font-semibold mb-4">Seleccionar Zonas</h3>
        <div class="space-y-2">
            <?php foreach ($zones as $zone) { ?>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" value="<?php echo htmlspecialchars($zone->getId()); ?>" class="form-checkbox">
                    <span><?php echo htmlspecialchars($zone->name); ?></span>
                </label>
            <?php } ?>
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="saveSelection('modalZones')"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Aplicar
            </button>
            <button onclick="closeModal('modalZones')"
                class="ml-2 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">
                Cancelar
            </button>
        </div>
    </div>
</div>

<script>
    const taskTypes = <?php echo json_encode($task_types); ?>;
    const treeTypes = <?php echo json_encode($tree_types); ?>;
</script>