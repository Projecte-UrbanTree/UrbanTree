<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Type of Task</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($task_types as $task_type): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $task_type->getId(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($task_type->getName()); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
