<div class="mb-4 flex justify-end">
    <a href="/admin/work-order/create" class="btn-create">
        Nueva órden de trabajo
    </a>
</div>

<div class="relative overflow-x-auto scrollbar-none shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="bg-neutral-700 text-white uppercase">
            <tr>
                <th scope="col" class="px-5 py-3">Fecha</th>
                <th scope="col" class="px-5 py-3">Zonas</th>
                <th scope="col" class="px-5 py-3">Tareas</th>
                <th scope="col" class="px-5 py-3">Operarios</th>
                <th scope="col" class="px-5 py-3">Notas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($work_orders as $work_order) { ?>
                <?php foreach ($work_order->tasks() as $task) { ?>
                    <tr class="border-b hover:bg-gray-50">
                        <th scope="row" class="px-5 py-4 font-medium text-gray-900 whitespace-nowrap dark\:text-white">
                            <?= $work_order->getCreatedAt(); ?>
                        </th>
                        <td class="px-5 py-4">
                            <?php
                            $zoneNames = [];
                            foreach ($task->zones() as $zone)
                                $zoneNames[] = $zone->name ?? 'No se encuentra en una zona predefinida';
                            echo implode(', ', $zoneNames);
                            ?>
                        </td>
                        <td class="px-5 py-4">
                            <?= $task->taskType()->name; ?>
                        </td>
                        <td class="px-5 py-4">
                            <?php
                            $users = [];
                            foreach ($task->users() as $user)
                                $users[] = $user->name . " " . substr($user->surname, 0, 1);
                            echo implode(', ', $users);
                            ?>
                        </td>
                        <td class="px-5 py-4">
                            <?= $task->notes; ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
