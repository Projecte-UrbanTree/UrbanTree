<div class="mb-4 flex justify-end">
    <a href="/admin/tree-type/create" class="btn-create">
        Nuevo tipo de árbol
    </a>
</div>

<div class="relative overflow-x-auto scrollbar-none shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="bg-neutral-700 text-white uppercase">
            <tr>
                <th scope="col" class="px-5 py-3">Especie</th>
                <th scope="col" class="px-5 py-3">Género</th>
                <th scope="col" class="px-5 py-3">Familia</th>
                <th scope="col" class="px-5 py-3">Árboles</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tree_types as $tree_type) { ?>
                <tr class="border-b hover:bg-gray-50">
                    <th scope="row" class="px-5 py-4 font-medium text-gray-900 whitespace-nowrap dark\:text-white">
                        <a href="/admin/tree-type/<?= htmlspecialchars($tree_type->getId()); ?>/edit">
                            <?= $tree_type->species; ?>
                        </a>
                    </th>
                    <td class="px-5 py-4">
                        <?= $tree_type->genus; ?>
                    </td>
                    <td class="px-5 py-4">
                        <?= $tree_type->family; ?>
                    </td>
                    <td class="px-5 py-4">
                        <?= count($tree_type->elements()); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
