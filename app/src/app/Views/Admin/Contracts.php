<div class="p-2 md:p-6">
    <!-- Contracts Table -->
    <div class="relative overflow-x-auto rounded-lg">
        <div class="mb-4 flex justify-end">
            <a href="/admin/contract/create" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded">
                <i class="fas fa-plus mr-2"></i> Nuevo contrato
            </a>
        </div>
        <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
            <thead class="bg-gray-700 text-white">
                <tr class="h-12"> <!-- Adjusted height -->
                    <th scope="col" class="px-4 py-3 font-medium rounded-tl-lg">Nombre</th>
                    <th scope="col" class="px-4 py-3 font-medium">Fecha inicial</th>
                    <th scope="col" class="px-4 py-3 font-medium">Fecha final</th>
                    <th scope="col" class="px-4 py-3 font-medium">Factura propuesta</th>
                    <th scope="col" class="px-4 py-3 font-medium">Factura aceptada</th>
                    <th scope="col" class="px-4 py-3 font-medium">Factura pagada</th>
                    <th scope="col" class="px-4 py-3 text-center font-medium w-32 rounded-tr-lg">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php if (empty($contracts)) { ?>
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">No hay contratos disponibles.</td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($contracts as $contract) { ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-300">
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                <?= htmlspecialchars($contract->name); ?>
                            </th>
                            <td class="px-4 py-3">
                                <?= date('d/m/Y', strtotime($contract->start_date)); ?>
                            </td>
                            <td class="px-4 py-3">
                                <?= date('d/m/Y', strtotime($contract->end_date)); ?>
                            </td>
                            <td class="px-4 py-3">
                                <?= htmlspecialchars($contract->invoice_proposed); ?> €
                            </td>
                            <td class="px-4 py-3">
                                <?= htmlspecialchars($contract->invoice_agreed); ?> €
                            </td>
                            <td class="px-4 py-3">
                                <?= htmlspecialchars($contract->invoice_paid); ?> €
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-3">
                                    <a href="/admin/contract/<?= htmlspecialchars($contract->getId()); ?>/edit"
                                       class="p-2 text-gray-700 border border-transparent hover:text-gray-500 transition-all duration-200"
                                       title="Editar" aria-label="Editar contrato <?= htmlspecialchars($contract->name); ?>">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <a href="/admin/contract/<?= htmlspecialchars($contract->getId()); ?>/delete"
                                       onclick="return confirm('¿Desea eliminar el contrato <?= htmlspecialchars($contract->name); ?>?');"
                                       class="p-2 text-gray-700 border border-transparent hover:text-red-500 transition-all duration-200"
                                       title="Eliminar" aria-label="Eliminar contrato <?= htmlspecialchars($contract->name); ?>">
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
</div>
