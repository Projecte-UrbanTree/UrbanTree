<div class="mt-8">
    <h1 class="text-5xl font-semibold">Configuración</h1>
    <p class="text-md text-gray-600 mt-3">Aquí podrás configurar tu cuenta.</p>
    <article class="mt-8 grid grid-cols-4 gap-4">
        <h2 class="text-3xl font-semibold col-span-4">Información personal</h2>



        <!-- user info -->
        <div class="flex flex-col justify-between h-full ">
            <form class="flex flex-col gap-4">
                <div class="flex flex-col">
                    <label for="first-name" class="text-sm font-semibold text-gray-700">First Name</label>
                    <input
                        type="text"
                        id="first-name"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        value="<?= $user->name ?>"
                        oninput="checkChanges()">
                </div>
                <div class="flex flex-col">
                    <label for="surname" class="text-sm font-semibold text-gray-700">Surname</label>
                    <input
                        type="text"
                        id="surname"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        value="<?= $user->surname ?>"
                        oninput="checkChanges()">
                </div>
            </form>
        </div>

        <div class="flex flex-col justify-between h-full ">
            <form class="flex flex-col gap-4">
                <div class="flex flex-col">
                    <label for="dni" class="text-sm font-semibold text-gray-700">DNI</label>
                    <input
                        type="text"
                        id="dni"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        value="<?= $user->dni ?>"
                        oninput="checkChanges()"
                        disabled>

                </div>
                <div class="flex flex-col">
                    <label for="email" class="text-sm font-semibold text-gray-700">Email</label>
                    <input
                        type="text"
                        id="email"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        value="<?= $user->email ?>"
                        oninput="checkChanges()">
                </div>
            </form>


        </div>

        <!-- avatar info -->
        <div class="flex flex-col justify-between h-full ">
            <img class="h-20 w-20 rounded-full mx-auto" src="/assets/images/avatar.png" alt="User Avatar">
            <div class="flex flex-col items-center mt-3">
                <button class="px-3 py-1.5 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Cambiar imagen</button>
                <p class="text-xs text-gray-600 mt-1.5">JPG or PNG. 1MB max.</p>
            </div>
        </div>
    </article>


    <hr class="mt-8">
    <article class="">
        <h1 class="text-3xl font-semibold col-span-4 mt-12">Cambiar contraseña</h1>

        <div class=" flex flex-col justify-between h-full ">
            <form class="mt-4 mb-10 grid grid-cols-4 gap-4">
                <div class="flex flex-col">
                    <label for="current-password" class="text-sm font-semibold text-gray-700">Contraseña actual</label>
                    <input
                        type="password"
                        id="current-password"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        oninput="checkChanges()">
                </div>
                <div class="flex flex-col">
                    <label for="new-password" class="text-sm font-semibold text-gray-700">Nueva contraseña</label>
                    <input
                        type="password"
                        id="new-password"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        oninput="checkChanges()">
                </div>
                <div class="flex flex-col">
                    <label for="confirm-password" class="text-sm font-semibold text-gray-700">Confirmar contraseña</label>
                    <input
                        type="password"
                        id="confirm-password"
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100"
                        oninput="checkChanges()">
                </div>
                <div class="col-span-4 flex justify-end">
                    <button id="button-save" class="bg-green-500 text-white py-2 px-4 rounded-lg disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed" disabled>Guardar cambios</button>
                </div>
            </form>
        </div>

    </article>


</div>