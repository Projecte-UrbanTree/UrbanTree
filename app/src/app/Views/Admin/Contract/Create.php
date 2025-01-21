<div class="mb-4 flex justify-end">
    <a href="/admin/contracts" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a contratos</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Creando nuevo contrato</h2>

    <form id="contractForm" action="/admin/contract/store" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Error Messages -->
        <div id="errorMessages"
            class="hidden col-span-1 md:col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"></div>

        <!-- Contract Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" id="name" name="name" placeholder="Introduce el nombre del contrato"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Start Date -->
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha inicial</label>
            <input type="date" id="start_date" name="start_date" placeholder="Selecciona la fecha de inicio"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- End Date -->
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha final</label>
            <input type="date" id="end_date" name="end_date" placeholder="Selecciona la fecha de fin"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Proposed Invoice -->
        <div>
            <label for="invoice_proposed" class="block text-sm font-medium text-gray-700 mb-1">Factura propuesta</label>
            <input type="number" step="0.01" id="invoice_proposed" name="invoice_proposed" max="999999999.99"
                placeholder="Introduce el monto de la factura propuesta"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Agreed Invoice -->
        <div>
            <label for="invoice_agreed" class="block text-sm font-medium text-gray-700 mb-1">Factura aceptada</label>
            <input type="number" id="invoice_agreed" name="invoice_agreed" max="999999999.99"
                placeholder="Introduce el monto de la factura aceptada"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Paid Invoice -->
        <div>
            <label for="invoice_paid" class="block text-sm font-medium text-gray-700 mb-1">Factura pagada</label>
            <input type="number" id="invoice_paid" name="invoice_paid" max="999999999.99"
                placeholder="Introduce el monto de la factura pagada"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Submit Button -->
        <div class="col-span-1 md:col-span-2 flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white shadow-sm hover:bg-blue-600 transition-all duration-200 rounded">
                Crear nuevo contrato
            </button>
        </div>
    </form>
</div>
