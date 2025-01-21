<div class="mb-4 flex justify-end">
    <a href="/admin/work-order/create"
        class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded">
        <i class="fas fa-plus mr-2"></i> Nueva órden de trabajo
    </a>
</div>
<div class="relative overflow-x-auto rounded">
    <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
        <thead class="bg-gray-700 text-white">
            <tr class="h-12">
                <th scope="col" class="px-4 py-3 font-medium rounded-tl-lg">Órden de trabajo</th>
                <th scope="col" class="px-4 py-3 font-medium">Contrato</th>
                <th scope="col" class="px-4 py-3 font-medium">Fecha</th>
                <th scope="col" class="px-4 py-3 font-medium">Operarios</th>
                <th scope="col" class="px-4 py-3 font-medium">Estatus</th>
                <th scope="col" class="px-4 py-3 text-right font-medium w-32 rounded-tr-lg">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <?php if (empty($work_orders)) { ?>
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">No hay órdenes de trabajo disponibles.</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($work_orders as $index => $work_order) { ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-300">
                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                            <button id="accordionButton<?= $index; ?>" onclick="toggleAccordion(<?= $index; ?>)"
                                aria-expanded="false" class="text-gray-500 hover:text-gray-700 focus:outline-none mr-2">
                                <svg id="accordionIcon<?= $index; ?>" xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path id="accordionPath<?= $index; ?>" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            <?= 'OT-'.htmlspecialchars($work_order->getId()); ?>
                        </th>
                        <td class="px-4 py-3">
                            <?= htmlspecialchars($work_order->contract()->name); ?>
                        </td>
                        <td class="px-4 py-3">
                            <?= date('d/m/Y', strtotime($work_order->date)); ?>
                        </td>
                        <td class="px-4 py-3">
                            <?php
                            $users = [];
                    foreach ($work_order->users() as $user) {
                        $users[] = $user->name.' '.$user->surname;
                    }
                    echo implode(', ', $users);
                    ?>
                        </td>
                        <td class="px-4 py-3">
                            <?php if ($work_order->report()) { ?>
                                <span class="px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded-full">Parte entregado</span>
                            <?php } else { ?>
                                <?php if ($work_order->status() == 0) { ?>
                                    <span class="px-2 py-1 text-sm font-medium text-white bg-red-500 rounded-full">No
                                        iniciado</span>
                                <?php } elseif ($work_order->status() == 1) { ?>
                                    <span class="px-2 py-1 text-sm font-medium text-white bg-orange-500 rounded-full">En
                                        progreso</span>
                                <?php } elseif ($work_order->status() == 2) { ?>
                                    <span class="px-2 py-1 text-sm font-medium text-white bg-green-500 rounded-full">Completado</span>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end space-x-3">
                                <?php if (! $work_order->report()) { ?>
                                    <a href="/admin/work-order/<?= htmlspecialchars($work_order->getId()); ?>/edit"
                                        class="p-2 text-gray-700 border border-transparent hover:text-gray-500 transition-all duration-200"
                                        title="Editar"
                                        aria-label="Editar orden de trabajo OT-<?= htmlspecialchars($work_order->contract()->getId()); ?>">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <a href="/admin/work-order/<?= htmlspecialchars($work_order->getId()); ?>/delete"
                                        onclick="return confirm('¿Está seguro de que desea eliminar esta orden de trabajo OT-<?= htmlspecialchars($work_order->contract()->getId()); ?>?');"
                                        class="p-2 text-gray-700 border border-transparent hover:text-red-500 transition-all duration-200"
                                        title="Eliminar"
                                        aria-label="Eliminar orden de trabajo OT-<?= htmlspecialchars($work_order->contract()->getId()); ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                <?php } ?>
                                <?php if ($work_order->report()) { ?>
                                    <a href="/admin/work-report/<?= $work_order->report()->getId(); ?>"
                                        class="p-2 text-gray-700 border border-transparent hover:text-blue-500 transition-all duration-200"
                                        title="Ver Parte de Trabajo">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                    <tr id="accordionContent<?= $index; ?>" class="hidden">
                        <td colspan="6" class="py-4 px-4">
                            <?php foreach ($work_order->blocks() as $block) { ?>
                                <div class="mb-6 border rounded shadow-sm overflow-hidden">
                                    <table class="w-full text-sm text-left text-gray-700 bg-white divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 font-medium">Zonas</th>
                                                <th scope="col" class="px-4 py-3 font-medium">Tareas</th>
                                                <th scope="col" class="px-4 py-3 font-medium">Notas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="hover:bg-gray-100 transition-colors duration-300">
                                                <td class="px-4 py-3 w-1/3">
                                                    <ul>
                                                        <?php foreach ($block->zones() as $blockZones) { ?>
                                                            <li>• <?= htmlspecialchars($blockZones->name); ?></li>
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                                <td class="px-4 py-3 w-1/3">
                                                    <ul>
                                                        <?php foreach ($block->tasks() as $blockTask) { ?>
                                                            <li>• <?= htmlspecialchars($blockTask->task()->name); ?>
                                                                <?= htmlspecialchars(' '.$blockTask->elementType()->name); ?>
                                                                <?php if ($blockTask->treeType() != null) {
                                                                    echo '('.htmlspecialchars($blockTask->treeType()->species.')');
                                                                } ?>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </td>
                                                <td class="px-4 py-3 w-1/3">
                                                    <?php if ($block->notes !== null) {
                                                        echo htmlspecialchars($block->notes);
                                                    } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
