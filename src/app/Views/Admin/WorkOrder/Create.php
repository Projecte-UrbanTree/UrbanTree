<?php
$zones = [];
$tasks = [];
$workers = [];

foreach ($workOrders as $workOrder) {
    foreach ($workOrder->tasks() as $task) {
        foreach ($task->zones() as $zone) {
            $zones[] = $zone->name;
        }
        foreach ($task->taskTypes() as $task_type) {
            $tasks[] = $task_type->name;
        }
        foreach ($task->workers() as $worker) {
            $workers[] = $worker->name;
        }
    }
}

$zones = array_unique($zones);
$tasks = array_unique($tasks);
$workers = array_unique($workers);
?>

<div class="mb-4 flex justify-end">
    <a href="/work-orders"
        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500 flex items-center space-x-2">
        <!-- Icon to return(chevron-left) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Return to Work Orders</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Work Order</h2>
    <form action="/work-order/store" method="POST" class="space-y-6">

        <div>
            <label for="contract_id" class="block text-sm font-medium text-gray-700 mb-1">Contrato</label>
            <select id="contract_id" name="contract_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
                <option value="" disabled selected>Selecciona un contrato</option>
                <?php foreach ($workOrders as $workOrder): ?>
                    <option value="<?= htmlspecialchars($workOrder->contract()->name) ?>">
                        <?= htmlspecialchars($workOrder->contract()->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Data</label>
            <input type="date" id="date" name="date"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>


        <!-- dynamic table -->
        <div>
            <div class="mt-4 flex justify-end">
                <button id="addRow"
                    class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded mb-4">
                    Afegir Fila
                </button>
            </div>

            <table id="workOrderTable" class="min-w-full border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">Zones</th>
                        <th class="border px-4 py-2">Tasques</th>
                        <th class="border px-4 py-2">Workers</th>
                        <th class="border px-4 py-2">Notes</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-4 py-2">
                            <input type="text" name="zones[]" id="zonesDisplay_0"
                                class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
                                onclick="openModal('zonesDisplay_0', data.zones)">
                        </td>
                        <td class="border px-4 py-2">
                            <input type="text" name="tasks[]" id="tasksDisplay_0"
                                class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
                                onclick="openModal('tasksDisplay_0', data.tasks)">
                        </td>
                        <td class="border px-4 py-2">
                            <input type="text" name="workers[]" id="workersDisplay_0"
                                class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
                                onclick="openModal('workersDisplay_0', data.workers)">
                        </td>

                        <td class="border px-4 py-2">
                            <input type="text" name="notes[]" class="w-full px-2 py-1 border rounded-lg">
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded"
                                onclick="removeRow(this)">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div id="selectionModal"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white w-96 rounded-lg shadow-lg">
                <div class="p-4 border-b border-gray-300 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-700">Seleccionar Opciones</h2>

                </div>
                <div class="p-4">
                    <ul id="modalOptions" class="space-y-2">
                        <!--Options will be dynamically added here -->
                    </ul>
                </div>
                <div class="p-4 border-t border-gray-300 flex justify-end">
                    <button onclick="applySelection()"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Aplicar</button>
                    <button onclick="closeModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">Cancelar</button>
                </div>
            </div>
        </div>

        <!-- Scripts JS -->
        <script>
            const data = {
                zones: <?php echo json_encode($zones); ?>,
                tasks: <?php echo json_encode($tasks); ?>,
                workers: <?php echo json_encode($workers); ?>
            };
        </script>

        <!-- Submit Button -->
        <div class="flex items-center">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                Create Work Order
            </button>
        </div>
    </form>
</div>