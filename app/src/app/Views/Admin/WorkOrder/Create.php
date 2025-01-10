<?php
function mapWithId($items, $getIdMethod)
{
    return array_map(function ($item) use ($getIdMethod) {
        $properties = get_object_vars($item);
        $properties['id'] = $item->$getIdMethod();
        return (object) $properties;
    }, $items);
}
?>

<div class="mb-4 flex justify-end">
    <a href="/admin/work-orders" class="btn-create flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a órdenes de trabajo</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Crear nueva órden de trabajo</h2>
    <form id="workOrderForm" action="/admin/work-order/store" method="POST" class="space-y-6">
        
    <div id="errorMessages" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"></div>    
    
    <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
            <input type="date" id="date" name="date"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="users" class="block text-sm font-medium text-gray-700 mb-1">Operarios</label>
            <input type="text" name="userNames" id="workersInput" readonly
                onclick="openModal('modalWorkers', 'workersInput')" placeholder="Seleccionar Operarios"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-pointer focus:outline-none">

            <!-- Hidden input to store selected IDs -->
            <input type="hidden" name="userIds" id="userIdsInput">
        </div>

        <div class="flex justify-end">
            <button type="button" id="addBlocks" onclick="addBlock()"
                class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500">
                Agregar Bloques
            </button>
        </div>

        <div id="blocksContainer" class="space-y-6">
            <!-- Blocks will be added here dynamically -->
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
                    <input type="checkbox" value="<?= htmlspecialchars($user->getId()); ?>" class="form-checkbox">
                    <span><?= htmlspecialchars($user->name . " " . $user->surname); ?></span>
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
                    <input type="checkbox" value="<?= htmlspecialchars($zone->getId()); ?>" class="form-checkbox">
                    <span><?= htmlspecialchars($zone->name); ?></span>
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
    const taskTypes = <?= json_encode(mapWithId($task_types, 'getId')); ?>;
    const treeTypes = <?= json_encode(mapWithId($tree_types, 'getId')); ?>;
</script>