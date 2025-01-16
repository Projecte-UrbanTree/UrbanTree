function toggleAccordion(index) {
    const contentRow = document.getElementById("accordionContent" + index);
    const path = document.getElementById("accordionPath" + index);

    contentRow.classList.toggle("hidden");
    path.setAttribute("d", contentRow.classList.contains("hidden") ? "M9 5l7 7-7 7" : "M5 9l7 7 7-7");
}

let currentInputId = null;

function openModal(modalId, inputId) {
    currentInputId = inputId;
    const input = document.getElementById(inputId);
    const selectedValues = input.value.split(",").map(val => val.trim());

    const modal = document.getElementById(modalId);
    const checkboxes = modal.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectedValues.includes(checkbox.nextElementSibling.textContent.trim());
    });

    modal.classList.remove("hidden");
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add("hidden");
}

function saveSelection(modalId) {
    const modal = document.getElementById(modalId);
    const checkboxes = modal.querySelectorAll('input[type="checkbox"]:checked');

    const selectedNames = Array.from(checkboxes).map(checkbox => checkbox.nextElementSibling.textContent.trim());
    const selectedIds = Array.from(checkboxes).map(checkbox => checkbox.value);

    if (currentInputId) {
        const input = document.getElementById(currentInputId);
        input.value = selectedNames.join(", ");

        if (currentInputId === "workersInput") {
            document.getElementById("userIdsInput").value = selectedIds.join(",");
        } else if (currentInputId.startsWith("zonesInput_")) {
            const blockIndex = currentInputId.split("_")[1];
            document.getElementById(`zonesIdsInput_${blockIndex}`).value = selectedIds.join(",");
        }
    }

    closeModal(modalId);
    currentInputId = null;
}

const taskTypeOptions = generateOptions(taskTypes, "Seleccione una tarea");
const speciesOptions = generateOptions(treeTypes, "Opcional");
const elementTypeOptions = generateOptions(elementTypes, "Seleccione un elemento");

function generateOptions(items, defaultText) {
    let options = `<option value="" disabled selected>${defaultText}</option>`;
    items.forEach(item => {
        options += `<option value="${item.id}">${item.name || item.species}</option>`;
    });
    return options;
}

function updateBlock() {
    const blocks = document.querySelectorAll("#blocksContainer .workorder-block");
    blocks.forEach((block, index) => {
        block.dataset.blockIndex = index;
        block.querySelector(".block-number").textContent = index + 1;

        updateElement(block, "zonesInput_", index, "zonesIdsInput_", "blocks", "zonesIds");
        updateElement(block, "notes_", index, "notes_", "blocks", "notes");

        const taskRows = block.querySelectorAll(".task-row");
        taskRows.forEach((taskRow, taskIndex) => {
            taskRow.dataset.taskIndex = taskIndex;
            updateTaskRow(taskRow, index, taskIndex);
        });
    });
}

function updateElement(block, inputPrefix, index, hiddenInputPrefix, blockName, elementName) {
    const input = block.querySelector(`[id^='${inputPrefix}']`);
    const label = block.querySelector(`label[for^='${inputPrefix}']`);
    if (input && label) {
        const newId = `${inputPrefix}${index}`;
        input.id = newId;
        // Only set onclick attribute if the input is not a textarea
        if (input.tagName.toLowerCase() !== 'textarea') {
            input.setAttribute("onclick", `openModal('modalZones', '${newId}')`);
        }
        label.setAttribute("for", newId);
    }

    const hiddenInput = block.querySelector(`[id^='${hiddenInputPrefix}']`);
    if (hiddenInput) {
        hiddenInput.id = `${hiddenInputPrefix}${index}`;
        hiddenInput.name = `${blockName}[${index}][${elementName}]`;
    }
}

function updateTaskRow(taskRow, blockIndex, taskIndex) {
    updateTaskElement(taskRow, "taskType", blockIndex, taskIndex);
    updateTaskElement(taskRow, "elementType", blockIndex, taskIndex);
    updateTaskElement(taskRow, "species", blockIndex, taskIndex);
}

function updateTaskElement(taskRow, elementName, blockIndex, taskIndex) {
    const element = taskRow.querySelector(`select[name^='blocks'][name*='[${elementName}]']`);
    if (element) {
        element.name = `blocks[${blockIndex}][tasks][${taskIndex}][${elementName}]`;
        element.id = `${elementName}_${blockIndex}_${taskIndex}`;

        const label = taskRow.querySelector(`label[for^='${elementName}_']`);
        if (label) {
            label.setAttribute("for", element.id);
        }
    }
}

function addBlock() {
    const blocksContainer = document.getElementById("blocksContainer");
    const blockCount = blocksContainer.children.length;

    const block = document.createElement("div");
    block.className = "workorder-block border border-gray-300 rounded-lg shadow p-6 bg-gray-50 mb-6";
    block.dataset.blockIndex = blockCount;

    block.innerHTML = `
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Bloque <span class="block-number">${blockCount + 1}</span></h3>
            <button type="button" onclick="removeBlock(this)" class="text-red-500 hover:text-red-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
        </div>
        <div class="mb-4">
            <label for="zonesInput_${blockCount}" class="block text-sm font-medium text-gray-700 mb-1">Zonas</label>
            <input type="text" id="zonesInput_${blockCount}" readonly onclick="openModal('modalZones', 'zonesInput_${blockCount}')" placeholder="Seleccionar Zonas" class="w-full px-4 py-2 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">
            <input type="hidden" name="blocks[${blockCount}][zonesIds]" id="zonesIdsInput_${blockCount}">
        </div>
        <div class="tasksContainer space-y-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-800 my-3">Seleccionar Tareas</h3>
            <div class="task-row flex space-x-4 items-end" data-task-index="0">
                <div class="flex-auto">
                    <label for="taskType_${blockCount}_0" class="block text-sm font-medium text-gray-700 mb-1">Tarea</label>
                    <select name="blocks[${blockCount}][tasks][0][taskType]" id="taskType_${blockCount}_0" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                        ${taskTypeOptions}
                    </select>
                </div>
                <div class="flex-auto">
                    <label for="elementType_${blockCount}_0" class="block text-sm font-medium text-gray-700 mb-1">Elemento</label>
                    <select name="blocks[${blockCount}][tasks][0][elementType]" id="elementType_${blockCount}_0" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                        ${elementTypeOptions}
                    </select>
                </div>
                <div class="flex-auto">
                    <label for="species_${blockCount}_0" class="block text-sm font-medium text-gray-700 mb-1">Species</label>
                    <select name="blocks[${blockCount}][tasks][0][species]" id="species_${blockCount}_0" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                        ${speciesOptions}
                    </select>
                </div>
                <button type="button" onclick="removeTaskRow(this)" class="text-red-500 hover:text-red-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
            </div>
        </div>
        <button type="button" onclick="addTask(this)" class="px-4 py-2 bg-green-500 text-white shadow-sm hover:bg-green-600 transition-all duration-200 rounded">
            Añadir Tarea
        </button>
        <div class="mt-4">
            <label for="notes_${blockCount}" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
            <textarea name="blocks[${blockCount}][notes]" id="notes_${blockCount}" rows="4" placeholder="Añadir notas aquí..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
        </div>
    `;

    blocksContainer.appendChild(block);
    updateBlock();
}

function addTask(button) {
    const blockContainer = button.closest(".workorder-block");
    const tasksContainer = blockContainer.querySelector(".tasksContainer");
    const taskCount = tasksContainer.querySelectorAll(".task-row").length;
    const blockIndex = blockContainer.dataset.blockIndex;

    const taskRow = document.createElement("div");
    taskRow.className = "task-row flex space-x-4 items-end";
    taskRow.dataset.taskIndex = taskCount;

    taskRow.innerHTML = `
        <div class="flex-auto">
            <label for="taskType_${blockIndex}_${taskCount}" class="block text-sm font-medium text-gray-700 mb-1">Tarea</label>
            <select name="blocks[${blockIndex}][tasks][${taskCount}][taskType]" id="taskType_${blockIndex}_${taskCount}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                ${taskTypeOptions}
            </select>
        </div>
        <div class="flex-auto">
            <label for="elementType_${blockIndex}_${taskCount}" class="block text-sm font-medium text-gray-700 mb-1">Elemento</label>
            <select name="blocks[${blockIndex}][tasks][${taskCount}][elementType]" id="elementType_${blockIndex}_${taskCount}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                ${elementTypeOptions}
            </select>
        </div>
        <div class="flex-auto">
            <label for="species_${blockIndex}_${taskCount}" class="block text-sm font-medium text-gray-700 mb-1">Species</label>
            <select name="blocks[${blockIndex}][tasks][${taskCount}][species]" id="species_${blockIndex}_${taskCount}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                ${speciesOptions}
            </select>
        </div>
        <button type="button" onclick="removeTaskRow(this)" class="text-red-500 hover:text-red-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        </button>
    `;

    tasksContainer.appendChild(taskRow);
    updateBlock();
}

document.addEventListener("DOMContentLoaded", () => {
    const blocksContainer = document.getElementById("blocksContainer");

    if (blocksContainer.querySelectorAll(".workorder-block").length === 0) {
        addBlock();
    }
});

function removeTaskRow(button) {
    const blockContainer = button.closest(".workorder-block");
    const tasksContainer = blockContainer.querySelector(".tasksContainer");
    const allTasks = tasksContainer.querySelectorAll(".task-row");

    if (allTasks.length === 1) {
        alert("No se puede eliminar esta tarea, debe haber al menos una tarea en este bloque.");
        return;
    }

    button.closest(".task-row").remove();
    updateBlock();
}

function removeBlock(button) {
    const blocksContainer = document.getElementById("blocksContainer");
    const allBlocks = blocksContainer.querySelectorAll(".workorder-block");

    if (allBlocks.length === 1) {
        alert("No se puede eliminar este bloque, debe haber al menos un bloque.");
        return;
    }

    button.closest(".workorder-block").remove();
    updateBlock();
}
