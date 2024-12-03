<div class="mb-4 flex justify-end">
    <a href="/work-orders"
        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500 flex items-center space-x-2">
        <!-- Icono de retorno (chevron-left) -->
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

        <!-- Tabla dinámica -->
        <div>
            <table id="dynamicTable" class="min-w-full border border-gray-300 rounded-lg">
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
                            <input type="text" name="zones_display" id="zonesDisplay"
                                class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
                                onclick="openModal('zones')">
                            <input type="hidden" name="zones[]" id="selectedZones">
                        </td>
                        <td class="border px-4 py-2">
                            <input type="text" name="tasks_display" id="tasksDisplay"
                                class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
                                onclick="openModal('tasks')">
                            <input type="hidden" name="tasks[]" id="selectedTasks">
                        </td>
                        <td class="border px-4 py-2">
                            <input type="text" name="workers_display" id="workersDisplay"
                                class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
                                onclick="openModal('workers')">
                            <input type="hidden" name="workers[]" id="selectedWorkers">
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





        <!-- Submit Button -->
        <div class="flex items-center">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                Create Work Order
            </button>
        </div>
    </form>
</div>