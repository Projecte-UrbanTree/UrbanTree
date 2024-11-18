<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-700">Crear Incidencia</h1>
    <form action="/path/to/your/controller" method="POST" enctype="multipart/form-data">
        <div class="mb-6">
            <label for="element_id" class="block text-gray-700 text-sm font-bold mb-2">Elemento</label>
            <select id="element_id" name="element_id" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" required>
                <option value="" disabled selected>Selecciona un elemento</option>
                <?php foreach ($elements as $element): ?>
                    <?php echo '<option value="' . $element->getId() . '">' . $element->name . '</option>'; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-6">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la incidencia</label>
            <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" placeholder="Ejemplo: Rama caída" required>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
            <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500" placeholder="Describe la incidencia" rows="6" required></textarea>
        </div>

        <div class="mb-6">
            <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Foto (opcional)</label>
            <input type="file" id="photo" name="photo" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <div class="flex items-center justify-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline">
                Crear Incidencia
            </button>
        </div>
    </form>
</div>
