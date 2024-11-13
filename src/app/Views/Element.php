<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Name</th>
                <th class="px-4 py-2 border-b">Latitud</th>
                <th class="px-4 py-2 border-b">Longitud</th>
                <th class="px-4 py-2 border-b">Created At</th>
                <th class="px-4 py-2 border-b">Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($elements as $element): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $element['id']; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element['name']; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element['latitude']; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element['longitude']; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element['created_at']; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element['updated_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>