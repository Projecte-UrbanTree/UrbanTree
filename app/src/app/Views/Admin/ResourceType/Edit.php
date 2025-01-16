<div class="mb-4 flex justify-end">
    <a href="/admin/resource-types"
        class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a tipos de recurso</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Tipo de Recurso</h2>
    <form id="typeResourcesForm" action="/admin/resource-type/<?= htmlspecialchars($resource_type->getId()); ?>/update"
        method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Error Messages -->
        <div id="errorMessages"
            class="hidden col-span-1 md:col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        </div>

        <!-- Resource Type Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($resource_type->name); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
        </div>


        <!-- Resource Type Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <input type="text" id="description" name="description" value="<?= htmlspecialchars($resource_type->description); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Action Buttons -->
        <div class="col-span-1 md:col-span-2 flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white shadow-sm hover:bg-blue-600 transition-all duration-200 rounded">
                Actualizar
            </button>
        </div>
    </form>
</div>
