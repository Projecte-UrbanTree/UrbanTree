<div class="mb-4 flex justify-end">
    <a href="/admin/task-types/create" class="btn-create">
        Nuevo tipo de tarea
    </a>
</div>

<div class="relative overflow-x-auto scrollbar-none shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="bg-neutral-700 text-white uppercase">
            <tr>
                <th scope="col" class="px-5 py-3">Nombre</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($task_types as $task_type) { ?>
                <tr class="border-b hover:bg-gray-50">
                    <th scope="row" class="px-5 py-4 font-medium text-gray-900 whitespace-nowrap dark\:text-white">
                        <a href="/admin/task-types/<?= htmlspecialchars($task_type->getId()); ?>/edit">
                            <?= $task_type->name; ?>
                        </a>
                    </th>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>