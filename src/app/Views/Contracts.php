<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Name</th>
                <th class="px-4 py-2 border-b">Start Date</th>
                <th class="px-4 py-2 border-b">End Date</th>
                <th class="px-4 py-2 border-b">Invoice proposed</th>
                <th class="px-4 py-2 border-b">Invoice agreed</th>
                <th class="px-4 py-2 border-b">Invoice paid</th>
                <th class="px-4 py-2 border-b">Created at</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contracts as $contract): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $contract->getId(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->name; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->start_date; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->end_date; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->invoice_proposed; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->invoice_agreed; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->invoice_paid; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->created_at; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
