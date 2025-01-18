<div class="mb-4 flex justify-end">
    <a href="/admin/users"
        class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a usuarios</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editando usuario</h2>
    <form action="/admin/user/<?= htmlspecialchars($user->getId()); ?>/update" method="POST"
        class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Error Messages -->
        <div id="errorMessages"
            class="hidden col-span-1 md:col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        </div>

        <!-- Company -->
        <div>
            <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Compañía</label>
            <input type="text" id="company" name="company" value="<?= htmlspecialchars($user->company); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user->name); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Surname -->
        <div>
            <label for="surname" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
            <input type="text" id="surname" name="surname" value="<?= htmlspecialchars($user->surname); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- DNI -->
        <div>
            <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">Documento identificativo</label>
            <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($user->dni); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->email); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Función</label>
            <select id="role" name="role"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                <?php for ($i = 0; $i <= 2; $i++) { ?>
                    <option value="<?= $i; ?>" <?= $user->role == $i ? 'selected' : ''; ?>>
                        <?= $user->getRoleName($i); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
            <input type="password" id="password" name="password"
                placeholder="Dejar en blanco para mantener la contraseña actual"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                minlength="8">
        </div>

        <!-- Submit Button -->
        <div class="col-span-1 md:col-span-2 flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white shadow-sm hover:bg-blue-600 transition-all duration-200 rounded">
                Actualizar
            </button>
        </div>
    </form>
</div>
