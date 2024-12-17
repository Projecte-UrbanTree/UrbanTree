<div class="mt-8">
    <h1 class="text-5xl font-semibold">Configuración</h1>
    <p class="text-md text-gray-600 mt-3">Aquí podrás configurar tu cuenta.</p>
    <article>
        <h2 class="text-3xl font-semibold col-span-4 mb-5">Informacíon personal</h2>

        <form action="/admin/configuration/<?= $user->getId() ?>/update" method="POST" class="grid grid-cols-4 gap-4">
            <!-- user info -->
            <div class="flex flex-col justify-between h-full">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col">
                        <label for="first-name" class="text-sm font-semibold text-gray-700">First Name</label>
                        <input
                            type="text"
                            id="first-name"
                            class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                            value="<?= $user->name ?>"
                            data-original-value="<?= $user->name ?>"
                            name="name"
                            oninput="checkChanges()">
                    </div>

                    <div class="flex flex-col">
                        <label for="dni" class="text-sm font-semibold text-gray-700">DNI</label>
                        <input
                            type="text"
                            id="dni"
                            class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100 cursor-not-allowed"
                            value="<?= $user->dni ?>"
                            data-original-value="<?= $user->dni ?>"
                            oninput="checkChanges()"
                            disabled>
                    </div>
                </div>
            </div>

            <div class="flex flex-col justify-between h-full">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col">
                        <label for="surname" class="text-sm font-semibold text-gray-700">Surname</label>
                        <input
                            type="text"
                            id="surname"
                            class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                            value="<?= $user->surname ?>"
                            data-original-value="<?= $user->surname ?>"
                            name="surname"
                            oninput="checkChanges()">
                    </div>

                    <div class="flex flex-col">
                        <label for="email" class="text-sm font-semibold text-gray-700">Email</label>
                        <input
                            type="text"
                            id="email"
                            class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100 cursor-not-allowed"
                            value="<?= $user->email ?>"
                            data-original-value="<?= $user->email ?>"
                            oninput="checkChanges()"
                            disabled>
                    </div>
                </div>
            </div>

            <!-- avatar info -->
            <div class="flex flex-col justify-between h-full justify-center items-center">
                <img class="h-20 w-20 rounded-full" src="/assets/images/avatar.png" alt="User Avatar">
                <div class="flex flex-col items-center mt-3">
                    <button type="button" class="px-3 py-1.5 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                        Cambiar imagen
                    </button>
                    <p class="text-xs text-gray-600 mt-1.5">JPG or PNG. 1MB max.</p>
                </div>
            </div>

            <!-- save button -->
            <div class="col-span-4 flex justify-end">
                <button
                    id="button-save"
                    type="submit"
                    class="bg-gray-400 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed disabled:bg-gray-400 disabled:text-white"
                    disabled>
                    Guardar cambios
                </button>
            </div>
        </form>
    </article>



    <hr class="mt-8">
    <article>
        <h1 class="text-3xl font-semibold col-span-4 mt-12">Cambiar contraseña</h1>

        <form action="/admin/configuration/<?= $user->getId() ?>/update-password" method="POST" class="flex flex-col justify-between h-full">
            <div class="mt-4 mb-10 grid grid-cols-4 gap-4">
                <div class="flex flex-col">
                    <label for="current-password" class="text-sm font-semibold text-gray-700">Contraseña actual</label>
                    <input
                        type="password"
                        id="current-password"
                        name="current_password"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        oninput="checkPasswordFields()">
                </div>
                <div class="flex flex-col">
                    <label for="new-password" class="text-sm font-semibold text-gray-700">Nueva contraseña</label>
                    <input
                        type="password"
                        id="new-password"
                        name="password"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        oninput="checkPasswordFields()">
                </div>
                <div class="flex flex-col">
                    <label for="confirm-password" class="text-sm font-semibold text-gray-700">Confirmar contraseña</label>
                    <input
                        type="password"
                        id="confirm-password"
                        name="password_confirmation"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        oninput="checkPasswordFields()">
                </div>

                <!-- Botón Guardar -->
                <div class="col-span-4 flex justify-end">
                    <button
                        id="button-save-password"
                        type="submit"
                        class="bg-gray-400 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed disabled:bg-gray-400 disabled:text-white"
                        disabled>
                        Guardar cambios
                    </button>
                </div>
            </div>
        </form>

    </article>


</div>