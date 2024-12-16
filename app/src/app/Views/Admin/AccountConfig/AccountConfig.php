<div class="mt-8">
    <h1 class="text-5xl font-semibold"><?= $title ?></h1>
    <p class="text-md text-gray-600 mt-3">Aquí podrás configurar tu cuenta.</p>
    <article class="mt-8 grid grid-cols-2 gap-2">
        <h2 class="text-3xl font-semibold col-span-2">Información personal</h2>
        <!-- avatar info -->
        <div class="p-4 bg-white shadow-md rounded-xl w-fit flex items-center gap-4">
            <img class="h-25 w-25 rounded-full" src="/assets/images/avatar.png" alt="User Avatar">
            <div class="flex flex-col items-center">
                <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Cambiar imagen</button>
                <p class="text-sm text-gray-600 mt-2">JPG or PNG. 1MB max.</p>
            </div>
        </div>

        <!-- user info -->
        <div class="p-4 bg-white shadow-md rounded-xl w-fit">
            <form class="flex flex-col gap-4">
                <div class="flex flex-col">
                    <label for="first-name" class="text-sm font-semibold text-gray-700">First Name</label>
                    <input 
                        type="text" 
                        id="first-name" 
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100 cursor-not-allowed" 
                        value="<?= $_SESSION['user']['name']; ?>" 
                        disabled
                    >
                </div>
                <div class="flex flex-col">
                    <label for="surname" class="text-sm font-semibold text-gray-700">Surname</label>
                    <input 
                        type="text" 
                        id="surname" 
                        class="mt-1 px-3 py-2 border rounded-md text-gray-600 bg-gray-100 cursor-not-allowed" 
                        value="<?= $_SESSION['user']['surname']; ?>" 
                        disabled
                    >
                </div>
            </form>
        </div>

    </article>
</div>
