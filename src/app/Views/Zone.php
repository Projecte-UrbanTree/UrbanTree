<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Name</th>
                <th class="px-4 py-2 border-b">Postal Code</th>
                <th class="px-4 py-2 border-b">Latitude</th>
                <th class="px-4 py-2 border-b">Longitude</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($zones as $zone): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $zone->getId(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $zone->name; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $zone->postal_code; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $zone->point()->latitude; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $zone->point()->longitude; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>