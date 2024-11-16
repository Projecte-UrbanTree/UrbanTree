<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Element Name</th>
                <th class="px-4 py-2 border-b">Name</th>
                <th class="px-4 py-2 border-b">Description</th>
                <th class="px-4 py-2 border-b">Photo</th>
                <th class="px-4 py-2 border-b">Incident Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidences as $incidence): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $incidence->getId(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $incidence->name; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $incidence->element()->name; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $incidence->description; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $incidence->photo; ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $incidence->getCreatedAt(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>