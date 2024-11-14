<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Contract Type</th>
                <th class="px-4 py-2 border-b">Start Date</th>
                <th class="px-4 py-2 border-b">End Date</th>
                <th class="px-4 py-2 border-b">Salary</th>
                <th class="px-4 py-2 border-b">Worker ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contracts as $contract): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $contract->getId(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->getContractType(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->getStartDate(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->getEndDate(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo number_format($contract->getSalary(), 2); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $contract->getWorkerId(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
