<div class="flex w-full h-screen-app p-4">
    <!-- Map Container -->
    <div class="map w-2/3 h-full">
        <div id="map" class="h-full"></div>
    </div>
    <!-- Inventory Sidebar -->
    <div class="inventory w-1/3 px-4 border-l border-gray-300 overflow-y-auto">
        <div id="filters" class="space-y-4">
            <!-- Example filters -->
            <div class="p-2 border rounded">Filter 1</div>
            <div class="p-2 border rounded">Filter 2</div>
            <div class="p-2 border rounded">Filter 3</div>
        </div>
    </div>
</div>

<!-- Element Modal -->
<div id="element-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <h2 id="element-modal-title" class="text-xl font-bold mb-4">Element Information</h2>
        <p id="element-modal-content" class="text-gray-700"></p>
        <button id="element-modal-close" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Close</button>
    </div>
</div>

<!-- Create Element Modal -->
<div id="create-element-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <h2 class="text-xl font-bold mb-4">Add Element</h2>
        <form id="create-element-form">
            <div class="mb-4">
                <label for="element-type" class="block text-gray-700">Element Type</label>
                <select id="element-type" class="w-full p-2 border rounded">
                </select>
            </div>
            <div class="mb-4">
                <label for="element-description" class="block text-gray-700">Description</label>
                <textarea id="element-description" class="w-full p-2 border rounded"></textarea>
            </div>
            <div class="mb-4 hidden" id="tree-type-container">
                <label for="element-tree-type" class="block text-gray-700">Tree Type</label>
                <select id="element-tree-type" class="w-full p-2 border rounded">
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" id="create-element-cancel" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add</button>
            </div>
        </form>
    </div>
</div>
