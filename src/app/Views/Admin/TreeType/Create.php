<div class="mb-4 flex justify-end">
    <a href="/admin/tree-types"
        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500 flex items-center space-x-2">
        <!-- Heroicon for return/back (chevron-left) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Return to Tree Types</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Tree Type</h2>

    <form id="treeForm" method="POST" action="your-action-url.php">
    <div id="errorMessages" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"></div>
        <!-- Family -->
        <div>
            <label for="family" class="block text-sm font-medium text-gray-700 mb-1">Family</label>
            <input type="text" id="family" name="family"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

        <!-- Genus -->
        <div>
            <label for="genus" class="block text-sm font-medium text-gray-700 mb-1">Genus</label>
            <input type="text" id="genus" name="genus"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

        <!-- Species -->
        <div>
            <label for="species" class="block text-sm font-medium text-gray-700 mb-1">Species</label>
            <input type="text" id="species" name="species"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center mt-4">
        <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
            Create Tree Type
        </button>
            <script src="/assets/js/app.js"></script>
            <script>
                document.getElementById('submitBtn').addEventListener('click', function(event) {
                    validateFormTreeType(event);
                });
            </script>

                </form>
            </div>
        </div>
    </form>
</div>