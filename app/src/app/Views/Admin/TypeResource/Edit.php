<div class="mb-4 flex justify-end">
    <a href="/admin/type-resources" class="btn-create flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a órdenes de trabajo</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Tipo de Recurso</h2>
    <form id="typeResourcesForm" action="/admin/type-resource/<?= htmlspecialchars($type_resource->getId()); ?>/update"
        method="POST" class="space-y-6">
        <div id="errorMessages" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        </div>
        <input type="hidden" name="id" value="<?= htmlspecialchars($type_resource->getId()); ?>">
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
            <input type="text" id="category" name="category" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                value="<?= htmlspecialchars($type_resource->category); ?>">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea id="description" name="description"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"><?= htmlspecialchars(trim($type_resource->description)); ?></textarea>
        </div>
        <div class="flex items-center">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                Actualizar
            </button>
        </div>
    </form>
</div>