<div class="mb-4 flex justify-end">
    <a href="/admin/user/create" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded">
        <i class="fas fa-plus mr-2"></i> Nuevo usuario
    </a>
</div>
<!-- Users Table -->
<div class="relative overflow-x-auto rounded-lg">
    <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
        <thead class="bg-gray-700 text-white">
            <tr class="h-12"> <!-- Adjusted height -->
                <th scope="col" class="px-4 py-3 font-medium rounded-tl-lg">Nombre</th>
                <th scope="col" class="px-4 py-3 font-medium">Compañía</th>
                <th scope="col" class="px-4 py-3 font-medium">Correo electrónico</th>
                <th scope="col" class="px-4 py-3 font-medium">Función</th>
                <th scope="col" class="px-4 py-3 text-center font-medium w-32 rounded-tr-lg">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <?php if (empty($users)) { ?>
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No hay usuarios disponibles.</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($users as $user) { ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-300">
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                            <?= htmlspecialchars($user->name.' '.$user->surname); ?>
                        </th>
                        <td class="px-4 py-3">
                            <?= htmlspecialchars($user->company); ?>
                        </td>
                        <td class="px-4 py-3">
                            <?= htmlspecialchars($user->email); ?>
                        </td>
                        <td class="px-4 py-3">
                            <?= htmlspecialchars($user->getRoleName($user->role)); ?>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="/admin/user/<?= htmlspecialchars($user->getId()); ?>/edit"
                                    class="p-2 text-gray-700 border border-transparent hover:text-gray-500 transition-all duration-200"
                                    title="Editar" aria-label="Editar usuario <?= htmlspecialchars($user->name.' '.$user->surname); ?>">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <a href="/admin/user/<?= htmlspecialchars($user->getId()); ?>/delete"
                                    onclick="return confirm('¿Desea eliminar el usuario <?= htmlspecialchars($user->name.' '.$user->surname); ?>?');"
                                    class="p-2 text-gray-700 border border-transparent hover:text-red-500 transition-all duration-200"
                                    title="Eliminar" aria-label="Eliminar usuario <?= htmlspecialchars($user->name.' '.$user->surname); ?>">
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
