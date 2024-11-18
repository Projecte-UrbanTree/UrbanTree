<div class="overflow-x-auto px-8 py-6 bg-gray-50 rounded-lg shadow-lg">
    <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Todas las Incidencias</h1>
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white">
                
                <th class="px-6 py-4 text-left font-semibold">Element Name</th>
                <th class="px-6 py-4 text-left font-semibold">Name</th>
                <th class="px-6 py-4 text-left font-semibold">Description</th>
                <th class="px-6 py-4 text-left font-semibold">Photo</th>
                <th class="px-6 py-4 text-left font-semibold">Incident Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidences as $incidence): ?>
                <tr class="hover:bg-gray-50 transition-all duration-200 ease-in-out">
                    
                    <td class="px-6 py-4 border-b text-sm text-gray-700"><?php echo $incidence->name; ?></td>
                    <td class="px-6 py-4 border-b text-sm text-gray-700"><?php echo $incidence->element()->name; ?></td>
                    <td class="px-6 py-4 border-b text-sm text-gray-700"><?php echo $incidence->description; ?></td>
                    <td class="px-6 py-4 border-b text-sm text-gray-700"><?php echo $incidence->photo ?? 'No photo'; ?></td>
                    <td class="px-6 py-4 border-b text-sm text-gray-700"><?php echo $incidence->getCreatedAt(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>