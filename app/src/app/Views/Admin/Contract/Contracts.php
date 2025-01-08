<div class="mb-4 flex justify-end">
    <a href="/admin/contract/create" class="btn-create">
        Nuevo contrato
    </a>
</div>

<div class="relative overflow-x-auto scrollbar-none shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <!-- <thead class="border-b text-gray-900 dark\:text-white uppercase"> -->
        <thead class="bg-neutral-700 text-white uppercase">
            <tr>
                <th scope="col" class="px-5 py-3">Nombre</th>
                <th scope="col" class="px-5 py-3">Fecha inicial</th>
                <th scope="col" class="px-5 py-3">Fecha final</th>
                <th scope="col" class="px-5 py-3">Factura propuesta</th>
                <th scope="col" class="px-5 py-3">Factura aceptada</th>
                <th scope="col" class="px-5 py-3">Factura pagada</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contracts as $contract) { ?>
                <tr class="border-b hover:bg-gray-50">
                    <th scope="row" class="px-5 py-4 font-medium text-gray-900 whitespace-nowrap dark\:text-white">
                        <a href="/admin/contract/<?= htmlspecialchars($contract->getId()); ?>/edit">
                            <?= $contract->name; ?>
                        </a>
                    </th>
                    <td class="px-5 py-4">
                        <?= date('d/m/Y', strtotime($contract->start_date)); ?>
                    </td>
                    <td class="px-5 py-4">
                        <?= date('d/m/Y', strtotime($contract->end_date)); ?>
                    </td>
                    <td class="px-5 py-4">
                        <?= $contract->invoice_proposed; ?> €
                    </td>
                    <td class="px-5 py-4">
                        <?= $contract->invoice_agreed; ?> €
                    </td>
                    <td class="px-5 py-4">
                        <?= $contract->invoice_paid; ?> €
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
