<div class="mb-4 flex justify-end">
    <a href="/admin/resource-type/create"
        class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded">
        <i class="fas fa-plus mr-2"></i> Nuevo tipo de recurso
    </a>
</div>
<!-- Type Resources Table -->
<div class="relative overflow-x-auto rounded-lg">
    <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
        <thead class="bg-gray-700 text-white">
            <tr class="h-12"> <!-- Adjusted height -->
                <th scope="col" class="px-4 py-3 font-medium rounded-tl-lg">Nombre</th>
                <th scope="col" class="px-4 py-3 font-medium">Descripción</th>
                <th scope="col" class="px-4 py-3 text-center font-medium w-32 rounded-tr-lg">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <?php foreach ($resource_types as $resource_type) { ?>
                <tr class="hover:bg-gray-50 transition-colors duration-300">
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                        <?= htmlspecialchars($resource_type->name); ?>
                    </th>
                    <td class="px-4 py-3">
                        <?= htmlspecialchars($resource_type->description ? $resource_type->description : 'N/A'); ?>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center space-x-3">
                            <a href="/admin/resource-type/<?= htmlspecialchars($resource_type->getId()); ?>/edit"
                                class="p-2 text-gray-700 border border-transparent hover:text-gray-500 transition-all duration-200"
                                title="Editar"
                                aria-label="Editar tipo de recurso <?= htmlspecialchars($resource_type->getId()); ?>">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <a href="/admin/resource-type/<?= htmlspecialchars($resource_type->getId()); ?>/delete"
                                onclick="return confirm('¿Desea eliminar el tipo de recurso <?= htmlspecialchars($resource_type->name); ?>?');"
                                class="p-2 text-gray-700 border border-transparent hover:text-red-500 transition-all duration-200"
                                title="Eliminar"
                                aria-label="Eliminar tipo de recurso <?= htmlspecialchars($resource_type->getId()); ?>">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
