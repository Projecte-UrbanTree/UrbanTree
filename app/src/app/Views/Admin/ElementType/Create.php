<div class="mb-4 flex justify-end">
    <a href="/admin/element-types" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a tipos de elemento</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Creando nuevo tipo de elemento</h2>

    <form id="elementTypeForm" action="/admin/element-type/store" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Error Messages -->
        <div id="errorMessages"
            class="hidden col-span-1 md:col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"></div>

        <!-- Element Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" id="name" name="name" placeholder="Introduce el nombre del tipo de elemento"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Element Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <input type="text" id="description" name="description" placeholder="Introduce una descripción"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Element Icon -->
        <div>
            <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icono</label>
            <input type="text" id="icon" name="icon" placeholder="Introduce el icono (e.g., fa-solid fa-tree)"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>

        <!-- Element Color -->
        <div>
            <label for="color-input" class="block text-sm font-medium mb-2 dark:text-white">Color picker</label>
            <input type="color" class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700" id="color-input" name="color" value="#2563eb" title="Choose your color">
        </div>

        <!-- Requires Tree Type -->
        <div class="col-span-1 md:col-span-2 flex items-center">
            <input type="checkbox" id="requires_tree_type" name="requires_tree_type" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mr-2">
            <label for="requires_tree_type" class="block text-sm font-medium text-gray-700">Requiere especie</label>
        </div>

        <!-- Submit Button -->
        <div class="col-span-1 md:col-span-2 flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white shadow-sm hover:bg-blue-600 transition-all duration-200 rounded">
                Crear nuevo tipo de elemento
            </button>
        </div>
    </form>
</div>
