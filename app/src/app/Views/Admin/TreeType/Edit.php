<div class="mb-4 flex justify-end">
    <a href="/admin/tree-types" class="btn-create flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a tipos de árbol</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editando tipo de árbol</h2>

    <form id="treeTypeForm" action="/admin/tree-type/<?= htmlspecialchars($tree_type->getId()); ?>/update" method="POST"
        class="space-y-6">
        <div id="errorMessages"
            class="hidden bg-red-100 border border-red-400 text-red700 px-4 py-3 rounded relative mb-6"></div>
        <div>
            <label for="family" class="block text-sm font-medium text-gray-700 mb-1">Familia</label>
            <input type="text" id="family" name="family" value="<?= htmlspecialchars($tree_type->family); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="genus" class="block text-sm font-medium text-gray-700 mb-1">Género</label>
            <input type="text" id="genus" name="genus" value="<?= htmlspecialchars($tree_type->genus); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="species" class="block text-sm font-medium text-gray-700 mb-1">Especie</label>
            <input type="text" id="species" name="species" value="<?= htmlspecialchars($tree_type->species); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex items-center">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                Actualizar
            </button>
        </div>
    </form>
</div>