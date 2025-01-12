<div class="p-2 md:p-6">
    <div class="mb-4 flex justify-end">
        <a href="/admin/element-type/create" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded">
            <i class="fas fa-plus mr-2"></i> Nuevo tipo de elemento
        </a>
    </div>
    <!-- Element Types Table -->
    <div class="relative overflow-x-auto rounded-lg">
        <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-700 text-white">
                <tr class="h-12">
                    <th scope="col" class="px-4 py-3 font-medium rounded-tl-lg">Nombre</th>
                    <th scope="col" class="px-4 py-3 font-medium">Descripción</th>
                    <th scope="col" class="px-4 py-3 font-medium">Requiere tipo de árbol</th>
                    <th scope="col" class="px-4 py-3 font-medium">Icono</th>
                    <th scope="col" class="px-4 py-3 font-medium">Color</th>
                    <th scope="col" class="px-4 py-3 font-medium">Elementos</th>
                    <th scope="col" class="px-4 py-3 text-center font-medium w-32 rounded-tr-lg">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php foreach ($element_types as $element_type) { ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-300">
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                            <?= htmlspecialchars($element_type->name); ?>
                        </th>
                        <td class="px-4 py-3">
                            <?= htmlspecialchars($element_type->description); ?>
                        </td>
                        <td class="px-4 py-3">
                            <?= $element_type->requires_tree_type ? "Sí" : "No"; ?>
                        </td>
                        <td class="px-4 py-3">
                            <i class="<?= htmlspecialchars($element_type->icon); ?>"></i>
                        </td>
                        <td class="px-4 py-3">
                            <span style="color: <?= htmlspecialchars($element_type->color); ?>;">■</span>
                        </td>
                        <td class="px-4 py-3">
                            <?= count($element_type->elements()); ?>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="/admin/element-type/<?= htmlspecialchars($element_type->getId()); ?>/edit"
                                    class="p-2 text-gray-700 border border-transparent hover:text-gray-500 transition-all duration-200"
                                    title="Editar" aria-label="Editar tipo de elemento <?= htmlspecialchars($element_type->name); ?>">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <a href="/admin/element-type/<?= htmlspecialchars($element_type->getId()); ?>/delete"
                                    onclick="return confirm('¿Desea eliminar el tipo de elemento <?= htmlspecialchars($element_type->name); ?>?');"
                                    class="p-2 text-gray-700 border border-transparent hover:text-red-500 transition-all duration-200"
                                    title="Eliminar" aria-label="Eliminar tipo de elemento <?= htmlspecialchars($element_type->name); ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
