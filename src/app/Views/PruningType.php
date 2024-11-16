<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Name</th>
                <th class="px-4 py-2 border-b">Description</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($pruning_types as $pruning_type): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $pruning_type->getId(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $pruning_type->name; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $pruning_type->description; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>