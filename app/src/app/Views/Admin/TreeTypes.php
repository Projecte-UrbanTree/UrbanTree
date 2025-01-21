<div class="mb-4 flex justify-end">
    <a href="/admin/tree-type/create" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded">
        <i class="fas fa-plus mr-2"></i> Nueva especie
    </a>
</div>
<!-- Tree Types Table -->
<div class="relative overflow-x-auto rounded">
    <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
        <thead class="bg-gray-700 text-white">
            <tr class="h-12"> <!-- Adjusted height -->
                <th scope="col" class="px-4 py-3 font-medium rounded-tl-lg">Especie</th>
                <th scope="col" class="px-4 py-3 font-medium">Género</th>
                <th scope="col" class="px-4 py-3 font-medium">Familia</th>
                <th scope="col" class="px-4 py-3 font-medium">Árboles</th>
                <th scope="col" class="px-4 py-3 text-center font-medium w-32 rounded-tr-lg">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <?php if (empty($tree_types)) { ?>
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No hay especies disponibles.</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($tree_types as $tree_type) { ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-300">
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                            <?= htmlspecialchars($tree_type->species); ?>
                        </th>
                        <td class="px-4 py-3">
                            <?= htmlspecialchars($tree_type->genus); ?>
                        </td>
                        <td class="px-4 py-3">
                            <?= htmlspecialchars($tree_type->family); ?>
                        </td>
                        <td class="px-4 py-3">
                            <?= count($tree_type->elements()); ?>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="/admin/tree-type/<?= htmlspecialchars($tree_type->getId()); ?>/edit"
                                    class="p-2 text-gray-700 border border-transparent hover:text-gray-500 transition-all duration-200"
                                    title="Editar" aria-label="Editar especie <?= htmlspecialchars($tree_type->species); ?>">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <a href="/admin/tree-type/<?= htmlspecialchars($tree_type->getId()); ?>/delete"
                                    onclick="return confirm('¿Desea eliminar la especie <?= htmlspecialchars($tree_type->species); ?>?');"
                                    class="p-2 text-gray-700 border border-transparent hover:text-red-500 transition-all duration-200"
                                    title="Eliminar" aria-label="Eliminar especie <?= htmlspecialchars($tree_type->species); ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
