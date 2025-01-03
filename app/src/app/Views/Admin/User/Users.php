<div class="mb-4 flex justify-end">
    <a href="/admin/user/create" class="btn-create">
        Nuevo usuario
    </a>
</div>

<div class="relative overflow-x-auto scrollbar-none shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="bg-neutral-700 text-white uppercase">
            <tr>
                <th scope="col" class="px-5 py-3">Nombre</th>
                <th scope="col" class="px-5 py-3">Compañía</th>
                <th scope="col" class="px-5 py-3">Correo electrónico</th>
                <th scope="col" class="px-5 py-3">Función</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr class="border-b hover:bg-gray-50">
                    <th scope="row" class="px-5 py-4 font-medium text-gray-900 whitespace-nowrap dark\:text-white">
                        <a href="/admin/user/<?= htmlspecialchars($user->getId()); ?>/edit">
                            <?= htmlspecialchars($user->name . ' ' . $user->surname); ?>
                        </a>
                    </th>
                    <td class="px-5 py-4">
                        <?= htmlspecialchars($user->company); ?>
                    </td>
                    <td class="px-5 py-4">
                        <?= htmlspecialchars($user->email); ?>
                    </td>
                    <td class="px-5 py-4">
                        <?= htmlspecialchars($user->role_name($user->role)); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>