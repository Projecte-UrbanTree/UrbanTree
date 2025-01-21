<div class="flex w-full h-screen-app-c p-4">
    <!-- Map Container -->
    <div class="map w-full md:w-2/3 h-full">
        <div id="map" class="h-full"></div>
    </div>
    <!-- Inventory Sidebar -->
    <div class="inventory-sidebar w-full md:w-1/3 px-4 border-l border-gray-300 overflow-y-auto hidden md:block py-4 md:py-0">
        <div id="filters"></div>
    </div>
</div>

<!-- Toggle Button for Mobile -->
<button id="inventory-sidebar-toggle" class="fixed bottom-8 left-8 bg-white text-black px-4 py-2 rounded shadow md:hidden">
    <i class="fas fa-layer-group"></i>
</button>

<!-- Element Modal -->
<div id="element-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded shadow-lg p-6 w-5/6 md:w-3/6 lg:w-2/3 h-3/5 overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 id="element-modal-title" class="text-xl font-bold"></h2>
            <button id="element-modal-close" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex mb-4 border-b border-gray-200">
            <button class="element-modal-tab px-4 py-2 text-gray-700 border-b-2 border-primary focus:outline-none" data-target="element-modal-info">Información</button>
            <button class="element-modal-tab px-4 py-2 text-gray-700 border-b-2 border-transparent focus:outline-none" data-target="element-modal-incidences">Incidencias</button>
            <button class="element-modal-tab px-4 py-2 text-gray-700 border-b-2 border-transparent focus:outline-none" data-target="element-modal-history">Historial</button>
        </div>
        <div id="element-modal-info" class="element-modal-tab-content">
            <!-- Information content will be injected here -->
        </div>
        <div id="element-modal-incidences" class="element-modal-tab-content hidden">
            <!-- Incidences content will be injected here -->
        </div>
        <div id="element-modal-history" class="element-modal-tab-content hidden">
            <!-- History content will be injected here -->
        </div>
    </div>
</div>

<!-- Create Element Modal -->
<div id="create-element-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded shadow-lg p-6 w-5/6 md:w-3/6 lg:w-1/3">
        <h2 class="text-xl font-bold mb-4">Añadir Elemento</h2>
        <form id="create-element-form">
            <div class="mb-4">
                <label for="element-type" class="block text-gray-700">Tipo de Elemento</label>
                <select id="element-type" class="w-full p-2 border rounded"></select>
            </div>
            <div class="mb-4">
                <label for="element-description" class="block text-gray-700">Descripción</label>
                <textarea id="element-description" class="w-full p-2 border rounded"></textarea>
            </div>
            <div class="mb-4 hidden" id="tree-type-container">
                <label for="element-tree-type" class="block text-gray-700">Especie</label>
                <select id="element-tree-type" class="w-full p-2 border rounded"></select>
            </div>
            <div class="flex justify-end">
                <button type="button" id="create-element-cancel" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Añadir</button>
            </div>
        </form>
    </div>
</div>

<!-- Sensor Modal -->
<div id="sensor-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded shadow-lg p-6 w-5/6 md:w-3/6 lg:w-1/3">
        <div class="flex justify-between items-center mb-4">
            <h2 id="sensor-modal-title" class="text-xl font-bold"></h2>
            <button id="sensor-modal-close" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="sensor-modal-content">
            <!-- Sensor information will be injected here -->
        </div>
    </div>
</div>
