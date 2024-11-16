<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Company</th>
                <th class="px-4 py-2 border-b">Name</th>
                <th class="px-4 py-2 border-b">DNI</th>
                <th class="px-4 py-2 border-b">Email</th>
                <th class="px-4 py-2 border-b">Role Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($workers as $worker): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $worker->getId(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $worker->company; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $worker->name; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $worker->dni; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $worker->email; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $worker->role()->name; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
