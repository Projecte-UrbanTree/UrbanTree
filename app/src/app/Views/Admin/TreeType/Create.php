<div class="mb-4 flex justify-end">
    <a href="/admin/tree-types" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a especies</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Creando nueva especie</h2>

    <form id="treeTypeForm" action="/admin/tree-type/store" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Error Messages -->
        <div id="errorMessages"
            class="hidden col-span-1 md:col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"></div>

        <!-- Family -->
        <div>
            <label for="family" class="block text-sm font-medium text-gray-700 mb-1">Familia</label>
            <input type="text" id="family" name="family" placeholder="Introduce la familia del árbol"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Genus -->
        <div>
            <label for="genus" class="block text-sm font-medium text-gray-700 mb-1">Género</label>
            <input type="text" id="genus" name="genus" placeholder="Introduce el género del árbol"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Species -->
        <div>
            <label for="species" class="block text-sm font-medium text-gray-700 mb-1">Especie</label>
            <input type="text" id="species" name="species" placeholder="Introduce la especie del árbol"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Submit Button -->
        <div class="col-span-1 md:col-span-2 flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white shadow-sm hover:bg-blue-600 transition-all duration-200 rounded">
                Crear nueva especie
            </button>
        </div>
    </form>
</div>
