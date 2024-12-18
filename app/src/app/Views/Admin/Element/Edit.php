<div class="mb-4 flex justify-end">
    <a href="/admin/elements" class="btn-create flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a elementos</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editando elemento</h2>
    <form action="/admin/element/<?= htmlspecialchars($element->getId()); ?>/update" method="POST" class="space-y-6">
        <div>
            <label for="contract_id" class="block text-sm font-medium text-gray-700 mb-1">Contrato</label>
            <select id="contract_id" name="contract_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
                <?php foreach ($contracts as $contract): ?>
                    <?= '<option value="' . $contract->getId() . '">' . $contract->name . '</option>'; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="element_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipo de elemento</label>
            <select id="element_type_id" name="element_type_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
                <?php foreach ($element_types as $element_type): ?>
                    <?= '<option value="' . $element_type->getId() . '">' . $element_type->name . '</option>'; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="tree_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipo de árbol</label>
            <select id="tree_type_id" name="tree_type_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                <?php foreach ($types as $type): ?>
                    <?= '<option value="' . $type->getId() . '">' . $type->species . '</option>'; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="zone_id" class="block text-sm font-medium text-gray-700 mb-1">Zona perteneciente</label>
            <select id="zone_id" name="zone_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                required>
                <?php foreach ($zones as $zone): ?>
                    <?= '<option value="' . $zone->getId() . '">' . $zone->name . '</option>'; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex items-center">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                Actualizar
            </button>
        </div>
    </form>
</div>
