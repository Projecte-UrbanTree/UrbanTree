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
            <div class="mt-4 flex justify-end">
                <button id="addRow"
                    class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded mb-4">
                    Afegir Fila
                </button>
            </div>

            <div class="relative overflow-x-auto scrollbar-none shadow-md sm:rounded-lg">
                <table id="workOrderTable" class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="bg-neutral-700 text-white uppercase">
                        <tr>
                            <th scope="col" class="px-5 py-3">Zonas</th>
                            <th scope="col" class="px-5 py-3">Tareas</th>
                            <th scope="col" class="px-5 py-3">Operarios</th>
                            <th scope="col" class="px-5 py-3">Notas</th>
                            <th scope="col" class="px-5 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <input type="text" name="zones[]" id="zonesDisplay_0"
                                    class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
                                    onclick="openModal('zonesDisplay_0', data.zones)">
                            </td>
                            <td class="px-5 py-4">
                                <input type="text" name="tasks[]" id="tasksDisplay_0"
                                    class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
                                    onclick="openModal('tasksDisplay_0', data.tasks)">
                            </td>
                            <td class="px-5 py-4">
                                <input type="text" name="workers[]" id="workersDisplay_0"
                                    class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
                                    onclick="openModal('workersDisplay_0', data.workers)">
                            </td>

                            <td class="px-5 py-4">
                                <input type="text" name="notes[]" class="w-full px-2 py-1 border rounded-lg">
                            </td>
                            <td class="px-5 py-4 text-center">
                                <button type="button" class="bg-red-500 text-white px-2 py-1 rounded hover:scale-110"
                                    onclick="removeRow(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="selectionModal"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white w-96 rounded-lg shadow-lg">
                <div class="p-4 border-b border-gray-300 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-700">Seleccionar opciones</h2>

                </div>
                <div class="p-4">
                    <ul id="modalOptions" class="space-y-2"></ul>
                </div>
                <div class="p-4 border-t border-gray-300 flex justify-end">
                    <button type="button" onclick="applySelection()"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Aplicar</button>
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2">Cancelar</button>
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

<script>
    const data = {
        zones: <?= json_encode($zones); ?>,
        tasks: <?= json_encode($task_types); ?>,
        workers: <?= json_encode($users); ?>
    };
</script>