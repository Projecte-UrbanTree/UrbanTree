<div class="mb-4 flex justify-end">
    <a href="/users"
        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500 flex items-center space-x-2">
        <!-- Heroicon for return/back (chevron-left) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Return to Users</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit User</h2>
    <form
        action="/user/<?php echo htmlspecialchars($user->getId()); ?>/update"
        method="POST" class="space-y-6">

        <!-- Company -->
        <div>
            <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
            <input type="text" id="company" name="company"
                value="<?php echo htmlspecialchars($user->company); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" id="name" name="name"
                value="<?php echo htmlspecialchars($user->name); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- DNI -->
        <div>
            <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI</label>
            <input type="text" id="dni" name="dni"
                value="<?php echo htmlspecialchars($user->dni); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email"
                value="<?php echo htmlspecialchars($user->email); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select id="role" name="role"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                <option value="1" <?php echo $user->role == 1 ? 'selected' : ''; ?>>Admin
                </option>
                <option value="2" <?php echo $user->role == 2 ? 'selected' : ''; ?>>User
                </option>
                <option value="3" <?php echo $user->role == 3 ? 'selected' : ''; ?>>Guest
                </option>
            </select>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current password"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Submit Button -->
        <div class="flex items-center">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                Update User
            </button>
        </div>
    </form>
</div>
