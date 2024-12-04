<h2 class="text-xl font-bold mb-4">Create New Element Type</h2>

<form action="/admin/element-types/store" method="POST">
    <div class="mb-4">
        <label for="name" class="block text-gray-700">Name</label>
        <input type="text" id="name" name="name" class="border p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="description" class="block text-gray-700">Description</label>
        <textarea id="description" name="description" class="border p-2 w-full" required></textarea>
    </div>

    <div class="mb-4 flex justify-end">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg">
            Create
        </button>
    </div>
</form>