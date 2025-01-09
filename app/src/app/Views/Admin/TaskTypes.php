<div class="p-2 md:p-6">
    <!-- Task Types Table -->
    <div class="relative overflow-x-auto rounded-lg">
        <div class="mb-4 flex justify-end">
            <a href="/admin/task-types/create" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded">
                <i class="fas fa-plus mr-2"></i> Nuevo tipo de tarea
            </a>
        </div>
        <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-700 text-white">
                <tr class="h-12">
                    <th scope="col" class="px-4 py-3 font-medium rounded-tl-lg">Nombre</th>
                    <th scope="col" class="px-4 py-3 font-medium text-center w-32 rounded-tr-lg">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php if (empty($task_types)) { ?>
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-center text-gray-500">No hay tipos de tarea disponibles.</td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($task_types as $task_type) { ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-300">
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                <?= htmlspecialchars($task_type->name); ?>
                            </th>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-3">
                                    <a href="/admin/task-types/<?= htmlspecialchars($task_type->getId()); ?>/edit"
                                        class="p-2 text-gray-700 border border-transparent hover:text-gray-500 transition-all duration-200"
                                        title="Editar" aria-label="Editar tipo de tarea <?= htmlspecialchars($task_type->name); ?>">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <a href="/admin/task-types/<?= htmlspecialchars($task_type->getId()); ?>/delete"
                                        onclick="return confirm('¿Desea eliminar el tipo de tarea <?= htmlspecialchars($task_type->name); ?>?');"
                                        class="p-2 text-gray-700 border border-transparent hover:text-red-500 transition-all duration-200"
                                        title="Eliminar" aria-label="Eliminar tipo de tarea <?= htmlspecialchars($task_type->name); ?>">
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
</div>
