<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Species</th>
                <th class="px-4 py-2 border-b">Subspecies</th>
                <th class="px-4 py-2 border-b">Family</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tree_types as $treeType): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b"><?php echo $treeType->getId(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $treeType->getSpecies(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $treeType->getSubspecies(); ?></td>
                    <td class="px-4 py-2 border-b"><?php echo $treeType->getFamily(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

