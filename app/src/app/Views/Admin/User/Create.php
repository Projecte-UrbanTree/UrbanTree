<div class="mb-4 flex justify-end">
    <a href="/admin/users" class="btn-create flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Volver a usuarios</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Crear nuevo usuario</h2>
    <form action="/admin/user/store" method="POST" class="space-y-6">
        <div>
            <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Compañía</label>
            <input type="text" id="company" name="company" placeholder="Nombre de la compañía"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" id="name" name="name" placeholder="Nombre del usuario"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="surname" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
            <input type="text" id="surname" name="surname" placeholder="Apellido del usuario"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">Documento identificativo</label>
            <input type="text" id="dni" name="dni" placeholder="Número de identificación"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="Correo electrónico"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Función</label>
            <select id="role" name="role"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                <option value="0">
                    Cliente
                </option>
                <option value="1">
                    Operario
                </option>
                <option value="2">
                    Admin
                </option>
            </select>
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Ingrese una contraseña"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex items-center">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                Crear usuario
            </button>
        </div>
    </form>
</div>
