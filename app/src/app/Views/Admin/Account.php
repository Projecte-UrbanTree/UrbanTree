<div class="mt-8">
    <!-- Main Configuration Card -->
    <div class="bg-white rounded-lg p-6 border border-gray-200">
        <h2 class="text-2xl font-semibold mb-5">Configuración de cuenta</h2>
        <form action="/admin/account" method="POST" id="accountForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Side: Personal Information -->
                <div class="flex flex-col gap-6">
                    <!-- Name and Surname -->
                    <div class="flex flex-col gap-4">
                        <label for="first-name" class="text-sm font-semibold text-gray-700">First Name</label>
                        <input
                            type="text"
                            id="first-name"
                            name="name"
                            value="<?= $user->name ?>"
                            data-original-value="<?= $user->name ?>"
                            class="px-3 py-2 border rounded-md text-gray-600"
                            oninput="checkChanges()">
                    </div>

                    <div class="flex flex-col gap-4">
                        <label for="surname" class="text-sm font-semibold text-gray-700">Surname</label>
                        <input
                            type="text"
                            id="surname"
                            name="surname"
                            value="<?= $user->surname ?>"
                            data-original-value="<?= $user->surname ?>"
                            class="px-3 py-2 border rounded-md text-gray-600"
                            oninput="checkChanges()">
                    </div>

                    <!-- DNI (disabled) -->
                    <div class="flex flex-col gap-4">
                        <label for="dni" class="text-sm font-semibold text-gray-700">DNI</label>
                        <input
                            type="text"
                            id="dni"
                            value="<?= $user->dni ?>"
                            class="px-3 py-2 border rounded-md text-gray-600 bg-gray-100 cursor-not-allowed"
                            disabled>
                    </div>

                    <!-- Email (disabled) -->
                    <div class="flex flex-col gap-4">
                        <label for="email" class="text-sm font-semibold text-gray-700">Email</label>
                        <input
                            type="text"
                            id="email"
                            value="<?= $user->email ?>"
                            class="px-3 py-2 border rounded-md text-gray-600 bg-gray-100 cursor-not-allowed"
                            disabled>
                    </div>
                </div>

                <!-- Right Side: Password Change -->
                <div class="flex flex-col gap-6">
                    <!-- Password Change Section -->
                    <div class="flex flex-col gap-4">
                        <label for="current-password" class="text-sm font-semibold text-gray-700">Contraseña actual</label>
                        <input
                            type="password"
                            id="current-password"
                            name="current_password"
                            class="px-3 py-2 border rounded-md text-gray-600"
                            oninput="checkChanges()">
                    </div>

                    <div class="flex flex-col gap-4">
                        <label for="new-password" class="text-sm font-semibold text-gray-700">Nueva contraseña</label>
                        <input
                            type="password"
                            id="new-password"
                            name="password"
                            class="px-3 py-2 border rounded-md text-gray-600"
                            oninput="checkChanges()"
                            minlength="8">
                    </div>

                    <div class="flex flex-col gap-4">
                        <label for="confirm-password" class="text-sm font-semibold text-gray-700">Confirmar contraseña</label>
                        <input
                            type="password"
                            id="confirm-password"
                            name="password_confirmation"
                            class="px-3 py-2 border rounded-md text-gray-600"
                            oninput="checkChanges()"
                            minlength="8">
                    </div>
                    <p class="text-xs text-gray-600 mt-2">La contraseña solo se actualizará si se establece una nueva.</p>
                </div>
            </div>

            <!-- Save Button -->
            <div class="mt-8 text-right">
                <button
                    id="button-save"
                    type="submit"
                    class="bg-gray-400 text-gray-500 py-2 px-6 rounded-lg cursor-not-allowed disabled:bg-gray-400 disabled:text-white"
                    disabled>
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
