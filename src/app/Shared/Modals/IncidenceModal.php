<div>
    <h1 class="font-sans text-3xl text-gray-700 font-bold">
        Nombre incidencia:
        <input
            type="text"
            name="name"
            id="incidenceName"
            value="<?php echo htmlspecialchars($incidence->name); ?>"
            class="font-medium border-2 border-gray-300 rounded-md p-3 mt-1 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm"
            disabled />
    </h1>
</div>
<div class="mt-6">
    <h2 class="font-sans text-2xl text-gray-700 font-bold">
        Descripción:
    </h2>
    <textarea
        name="description"
        id="incidenceDescription"
        class="border-2 border-gray-300 rounded-md p-3 mt-1 w-full h-32 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm resize-none"><?php echo htmlspecialchars($incidence->description); ?></textarea>
</div>

<!-- Botones -->
<div class="flex justify-end gap-4 mt-6">
    <button
        onclick="closeModal()"
        class="bg-gray-500 hover:bg-gray-600 hover:scale-105 duration-200 text-white font-medium py-2 px-5 rounded-lg shadow focus:outline-none focus:ring focus:ring-gray-400">
        Cerrar
    </button>
    <button
        onclick="modifyIncidence()"
        class="bg-green-500 hover:bg-green-600 hover:scale-105 duration-200 text-white font-medium py-2 px-5 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-400">
        Modificar
    </button>
    <button
        onclick="window.location.href='/incidence/delete/<?= $incidence->getId(); ?>'"
        class="bg-red-500 hover:bg-red-600 hover:scale-105 duration-200 text-white font-medium py-2 px-5 rounded-lg shadow focus:outline-none focus:ring focus:ring-red-400">
        Eliminar
    </button>
</div>