<div class="mb-4 flex justify-end">
    <a href="/admin/work-order/create" class="btn-create">
        Nueva órden de trabajo
    </a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-700 text-white text-left h-14">
                <th class="py-2 px-4 border-b">Orden de Trabajo</th>
                <th class="py-2 px-4 border-b">Fecha</th>
                <th class="py-2 px-4 border-b">Operarios</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($work_orders as $index => $work_order) { ?>
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-2 px-4 flex items-center">
                        <button id="accordionButton<?php echo $index; ?>" onclick="toggleAccordion(<?php echo $index; ?>)"
                            aria-expanded="false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <!-- SVG Acordeon-->
                            <svg id="accordionIcon<?php echo $index; ?>" xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <!-- Acordeon Right -->
                                <path id="accordionPath<?php echo $index; ?>" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <?php echo "OT-" . htmlspecialchars($work_order->contract()->getId()); ?>
                    </td>
                    <td>
                        <?= date('d/m/Y', strtotime($work_order->date)); ?>
                    </td>
                    <td class="py-2 px-4">
                        <?php
                        $users = [];
                        foreach ($work_order->users() as $user) {
                            $users[] = $user->name . " " . $user->surname;
                        }
                        echo implode(', ', $users);
                        ?>
                    </td>
                    <td class="px-4 py-3 border-b text-center flex space-x-4">
                        <!-- Edit Button (Pencil Icon) -->
                        <a href="/admin/work-order/<?php echo htmlspecialchars($work_order->getId()); ?>/edit"
                            class="text-blue-500 hover:text-blue-700" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <!-- Delete Button (Trash Icon) -->
                        <a href="/admin/work-order/<?php echo htmlspecialchars($work_order->getId()); ?>/delete"
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

                <!-- Row Accordeon -->
                <tr id="accordionContent<?php echo $index; ?>" class="hidden">
                    <!-- Accordeon Content -->
                    <td colspan="4" class="py-2 px-3 bg-gray-50">
                        <?php foreach ($work_order->blocks() as $block) { ?>
                            <table class="w-full border-collapse border border-gray-300 rounded-lg">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-700 text-center">
                                        <th class="border p-2">Zonas</th>
                                        <th class="border p-2">Tipo de Tareas</th>
                                        <th class="border p-2">Notas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="hover:bg-gray-100">
                                        <td class="border px-2 py-1 align-top w-1/5">
                                            <?php foreach ($block->zones() as $blockZones) { ?>
                                                <div class="mb-1">•
                                                    <?php echo htmlspecialchars($blockZones->name); ?>
                                                </div>
                                            <?php } ?>
                                        </td>

                                        <td class="border px-2 py-1 align-top w-2/5">
                                            <?php foreach ($block->tasks() as $blockTask) { ?>
                                                <div class="mb-1">•
                                                    <?php echo htmlspecialchars($blockTask->task()->name);
                                                    if ($blockTask->treeType() != null) {
                                                        echo ": " . htmlspecialchars($blockTask->treeType()->species);
                                                    } ?>
                                                </div>
                                            <?php } ?>
                                        </td>

                                        <td class="border px-2 py-1 align-top w-2/5">
                                            <?php if ($block->notes !== null) {
                                                echo htmlspecialchars($block->notes);
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>