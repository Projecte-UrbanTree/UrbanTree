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
                <tr class="hover:bg-gray-100 transition-all duration-200 ease-in-out hover:scale-105">
                    <td class="px-6 py-4 border border-transparent">
                        <div class="transition-all duration-200">
                            <a href="#" class="text-blue-600" data-id="<?= $incidence->getId(); ?>" onclick="openModal(<?= $incidence->getId(); ?>)">
                                <?= $incidence->name; ?>
                            </a>
                        </div>
                    </td>
                    <td class="px-6 py-4 border border-transparent"><?php echo $incidence->element()->name; ?></td>
                    <td class="px-6 py-4 border border-transparent"><?php echo $incidence->description; ?></td>
                    <td class="px-6 py-4 border border-transparent"><?php echo $incidence->photo ?? 'No photo'; ?></td>
                    <td class="px-6 py-4 border border-transparent"><?php echo $incidence->getCreatedAt(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal (escondido inicialmente) -->
<div id="incidenceModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
    <div class="bg-white p-8 rounded-lg shadow-xl max-w-lg w-full">
        <h2 class="text-xl font-semibold mb-4"></h2>
        <div id="modalContent">

        </div>
        
    </div>
</div>