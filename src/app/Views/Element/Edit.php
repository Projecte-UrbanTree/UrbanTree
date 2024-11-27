<div class="mb-4 flex justify-end">
    <a href="/elements"
        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500 flex items-center space-x-2">
        <!-- Heroicon for return/back (chevron-left) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Return to Elements</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Element</h2>
    <form
        action="/element/<?php echo htmlspecialchars($element->getId()); ?>/update"
        method="POST" class="space-y-6">

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" id="name" name="name"
                value="<?php echo htmlspecialchars($element->name); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <!-- Contract -->
        <div>
            <label for="contract_id" class="block text-sm font-medium text-gray-700 mb-1">Zone</label>
            <input type="text" id="contract_id" name="contract_id"
                value="<?php echo htmlspecialchars($element->contract_id); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <!-- Zone Name -->
        <div>
            <label for="zone_id" class="block text-sm font-medium text-gray-700 mb-1">Zone</label>
            <input type="text" id="zone_id" name="zone_id"
                value="<?php echo htmlspecialchars($element->zone_id); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Tree Type -->
        <div>
            <label for="tree_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tree Type</label>
            <input type="tree_type_id" id="tree_type_id" name="tree_type_id"
                value="<?php echo htmlspecialchars($element->tree_type_id); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Latitude
        <div>
            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
            <input type="latitude" id="latitude" name="latitude"
                value="<?php //echo htmlspecialchars($element->latitude); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div> -->

        <!-- Longitude
        <div>
            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
            <input type="longitude" id="longitude" name="longitude"
                value="<?php //echo htmlspecialchars($element->longitude); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div> -->

        <!-- Submit Button -->
        <div class="flex items-center">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                Update User
            </button>
        </div>
    </form>
</div>
