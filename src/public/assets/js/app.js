// Variable global para saber qué input se está editando
let currentInput = null;
let rowIndex = 0;

document.getElementById('addRow').addEventListener('click', addRow);

function addRow(event) {
    event.preventDefault();

    const table = document.getElementById('workOrderTable').getElementsByTagName('tbody')[0];;
    const newRow = table.insertRow();
    rowIndex++;

    newRow.innerHTML = `
    <td class="border px-4 py-2">
        <input type="text" name="zones[]" id="zonesDisplay_${rowIndex}"
            class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
            onclick="openModal('zonesDisplay_${rowIndex}', data.zones)">
    </td>
    <td class="border px-4 py-2">
        <input type="text" name="tasks[]" id="tasksDisplay_${rowIndex}"
            class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
            onclick="openModal('tasksDisplay_${rowIndex}', data.tasks)">
    </td>
    <td class="border px-4 py-2">
        <input type="text" name="workers[]" id="workersDisplay_${rowIndex}"
            class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
            onclick="openModal('workersDisplay_${rowIndex}', data.workers)">
    </td>
    <td class="border px-4 py-2">
        <input type="text" name="notes[]" class="w-full px-2 py-1 border rounded-lg">
    </td>
    <td class="border px-4 py-2 text-center">
        <button type="button" class="bg-red-500 text-white px-2 py-1 rounded"
            onclick="removeRow(this)">Eliminar</button>
    </td>   
    `;

}

function removeRow(button) {
    const ROW = button.parentNode.parentNode;
    ROW.remove();
}

// Función para abrir el modal
function openModal(inputId, options) {
    currentInput = document.getElementById(inputId); // Guarda el input que activó el modal
    const modal = document.getElementById('selectionModal'); // Obtén el modal
    const modalOptions = document.getElementById('modalOptions'); // Contenedor de opciones

    // Limpia opciones anteriores
    modalOptions.innerHTML = '';

    // Agrega las opciones al modal
    options.forEach(option => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `
            <label>
                <input type="checkbox" value="${option}" class="mr-2">
                ${option}
            </label>
        `;
        modalOptions.appendChild(listItem);
    });

    // Marca los checkboxes si el input ya tiene valores
    if (currentInput.value) {
        const selectedValues = currentInput.value.split(',').map(value => value.trim());
        modalOptions.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            if (selectedValues.includes(checkbox.value.trim())) {
                checkbox.checked = true;
            }
        });
    }

    // Muestra el modal
    modal.classList.remove('hidden');
}

// Función para cerrar el modal
function closeModal() {
    const modal = document.getElementById('selectionModal');
    modal.classList.add('hidden'); // Oculta el modal
}

// Función para aplicar la selección
function applySelection() {
    const selectedOptions = []; // Lista para guardar opciones seleccionadas
    const checkboxes = document.querySelectorAll('#modalOptions input:checked');

    // Obtén las opciones seleccionadas
    checkboxes.forEach(checkbox => {
        selectedOptions.push(checkbox.value.trim());
    });

    // Coloca las opciones seleccionadas en el input actual
    if (currentInput) {
        currentInput.value = selectedOptions.join(', '); // Muestra seleccionadas separadas por coma
    }

    // Cierra el modal
    closeModal();
}
