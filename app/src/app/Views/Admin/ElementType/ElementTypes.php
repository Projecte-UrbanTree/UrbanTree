<div class="mb-4 flex justify-end">
    <a href="/admin/element-type/create" class="btn-create">
        Nuevo tipo de elemento
    </a>
</div>

<div class="relative overflow-x-auto scrollbar-none shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="bg-neutral-700 text-white uppercase">
            <tr>
                <th scope="col" class="px-5 py-3">Nombre</th>
                <th scope="col" class="px-5 py-3">Descripción</th>
                <th scope="col" class="px-5 py-3">Requiere tipo de árbol</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($element_types as $element_type) { ?>
                <tr class="border-b hover:bg-gray-50">
                    <th scope="row" class="px-5 py-4 font-medium text-gray-900 whitespace-nowrap dark\:text-white">
                        <a href="/admin/element-type/<?= htmlspecialchars($element_type->getId()); ?>/edit">
                            <?= $element_type->name; ?>
                        </a>
                    </th>
                    <td class="px-5 py-4">
                        <?= $element_type->description; ?>
                    </td>
                    <td class="px-5 py-4">
                        <?= $element_type->requires_tree_type ? "Sí" : "No"; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
