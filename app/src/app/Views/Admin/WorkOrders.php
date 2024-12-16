<?php

use App\Core\Session;

?>

<?php if (Session::has('success')) { ?>
    <div id="alert-msg" class="bg-blue-500 text-white px-4 py-3 rounded-lg mb-6" role="alert">
        <strong class="font-bold">Success: </strong>
        <span><?= htmlspecialchars(Session::get('success')); ?></span>
    </div>
<?php } ?>

<div class="mb-4 flex justify-end">
    <a href="/admin/work-order/create"
        class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500">
        Create Work Order
    </a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full table-fixed bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-700 text-white text-left h-14">
                <th class="py-2 px-4 border-b">Contracte</th>
                <th class="py-2 px-4 border-b">Fecha</th>
                <th class="py-2 px-4 border-b">Operarios</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($workOrders as $index => $workOrder) { ?>
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-2 px-4 flex items-center">
                        <button id="accordionButton<?php echo $index; ?>" onclick="toggleAccordion(<?php echo $index; ?>)"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <!-- SVG Acordeon-->
                            <svg id="accordionIcon<?php echo $index; ?>" xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <!-- Acordeon Right -->
                                <path id="accordionPath<?php echo $index; ?>" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <?php echo $workOrder->contract()->name; ?>
                    </td>
                    <td class="py-2 px-4">
                        <?php echo $workOrder->date; ?>
                    </td>
                    <td class="py-2 px-4">
                        <?php
                        $users = [];
                        foreach ($workOrder->users() as $user) {
                            $users[] = $user->name . " " . $user->surname;
                        }
                        echo implode(', ', $users);
                        ?>
                    </td>
                    <td class="px-4 py-3 border-b text-center flex space-x-4">
                        <!-- Edit Button (Pencil Icon) -->
                        <a href="/work-order/<?php echo htmlspecialchars($workOrder->getId()); ?>/edit"
                            class="text-blue-500 hover:text-blue-700" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <!-- Delete Button (Trash Icon) -->
                        <a href="/work-order/<?php echo htmlspecialchars($workOrder->getId()); ?>/delete"
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
                    <td colspan="4" class="py-2 px-4 bg-gray-100">
                        <?php foreach ($workOrder->blocks() as $block) { ?>
                            <div class="mb-4">
                                <strong>Bloque </strong> <?php echo htmlspecialchars($block->getId()); ?>
                            </div>
                            <div>
                                <strong>Zona:</strong>
                                <?php
                                $zones = $block->zones();
                                $zoneNames = [];
                                foreach ($zones as $zone) {
                                    $zoneNames[] = htmlspecialchars($zone->name);
                                }
                                echo implode(', ', $zoneNames); ?>
                            </div>
                            <div>
                                <strong>Tipo de Tarea:</strong>
                                <?php echo htmlspecialchars($block->task()->name); ?>
                            </div>

                            <?php if ($block->notes) { ?>
                                <div>
                                    <strong>Notas:</strong>
                                    <?php echo htmlspecialchars($block->notes); ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    function toggleAccordion(index) {
        console.log('toggleAccordion ejecutado con index:', index);

        var contentRow = document.getElementById('accordionContent' + index);
        var path = document.getElementById('accordionPath' + index);

        if (contentRow.classList.contains('hidden')) {
            contentRow.classList.remove('hidden');
            path.setAttribute('d', 'M5 9l7 7 7-7');
        } else {
            contentRow.classList.add('hidden');
            path.setAttribute('d', 'M9 5l7 7-7 7');
        }
    }
</script>