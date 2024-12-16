<div class="mb-4 flex justify-end">
    <a href="/admin/work-order/create" class="btn-create">
        New work order
    </a>
</div>

<div class="rounded-lg shadow-md overflow-hidden overflow-x-auto">
    <table class="table-auto w-full text-sm text-left text-gray-700">
        <thead class="bg-neutral-700 text-white uppercase">
            <tr>
                <th class="px-4 py-2">Contracte</th>
                <th class="px-4 py-2">Data</th>
                <th class="px-4 py-2">Zones</th>
                <th class="px-4 py-2">Tasca</th>
                <th class="px-4 py-2">Operaris</th>
                <th class="px-4 py-2">Notes</th>
                <th class="actions-column">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($workOrders as $workOrder) { ?>
                <?php foreach ($workOrder->tasks() as $task) { ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-2 px-4">
                            <?= $workOrder->contract()->name; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?= $workOrder->getCreatedAt(); ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php
                            $zoneNames = [];
                            foreach ($task->zones() as $zone)
                                $zoneNames[] = $zone->predefined()->name ?? 'Not on a predefined zone';
                            echo implode(', ', $zoneNames);
                            ?>
                        </td>
                        <td class="py-2 px-4">
                            <?= $task->taskType()->name; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php
                            $users = [];
                            foreach ($task->users() as $user)
                                $users[] = $user->name . " " . substr($user->surname, 0, 1);
                            echo implode(', ', $users);
                            ?>
                        </td>
                        <td class="py-2 px-4"><?= $task->notes; ?>
                        </td>

                        <td class="px-4 py-3 border-b text-center flex justify-center space-x-4">
                            <!-- Edit Button (Pencil Icon) -->
                            <a href="/admin/work-order/<?= htmlspecialchars($workOrder->getId()); ?>/edit"
                                class="text-blue-500 hover:text-blue-700" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <!-- Delete Button (Trash Icon) -->
                            <a href="/admin/work-order/<?= htmlspecialchars($workOrder->getId()); ?>/delete"
                                onclick="return confirm('Are you sure you want to delete this work order?');"
                                class="text-red-500 hover:text-red-700" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>