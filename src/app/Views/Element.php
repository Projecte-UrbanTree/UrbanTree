<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Name</th>
                <th class="px-4 py-2 border-b">Zone Name</th>
                <th class="px-4 py-2 border-b">Zone Postal Code</th>
                <th class="px-4 py-2 border-b">Latitude</th>
                <th class="px-4 py-2 border-b">Longitude</th>
                <th class="px-4 py-2 border-b">Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($elements as $element): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $element->getId(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element->name; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element->zone()->name; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element->zone()->postal_code; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element->point()->latitude; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element->point()->longitude; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $element->getCreatedAt(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>