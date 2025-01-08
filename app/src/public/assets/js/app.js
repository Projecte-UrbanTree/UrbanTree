const errorMessagesDiv = document.getElementById("errorMessages");

const regexPatterns = [
    {
        name: "lettersAndSpaces",
        regex: /^[a-zA-Z\s]+$/,
        explanation: "El campo solo puede contener letras y espacios.",
    },
    {
        name: "numbersOnly",
        regex: /^\d+$/,
        explanation: "El campo solo puede contener números.",
    },
];

function createErrorElement(message) {
    const errorMsg = document.createElement("p");
    errorMsg.textContent = message;
    errorMessagesDiv.appendChild(errorMsg);
    return false;
}

/**
 * Validate if a field is empty and return an error message if it is
 */
function validateEmptyField(value, fieldName) {
    return !value
        ? createErrorElement(`${fieldName}: El campo no puede estar vacío.`)
        : true;
}

/**
 * Validate a field based on a regex pattern name and return an error message if invalid
 */
function validateField(value, regexName, fieldName) {
    const pattern = regexPatterns.find((pattern) => pattern.name === regexName);
    const explanation = pattern
        ? pattern.explanation
        : "El valor no es válido.";
    return pattern && !pattern.regex.test(value)
        ? createErrorElement(`${fieldName}: ${explanation}`)
        : true;
}

/**
 * Validate that one date is not after another date
 */
function dateCannotBeAfter(startDate, endDate, fieldName) {
    return new Date(startDate) > new Date(endDate)
        ? createErrorElement(
            `${fieldName}: La fecha inicial no puede ser posterior a la fecha final.`
        )
        : true;
}

/**
 * Validate that a field contains a positive integer
 */
function validatePositiveInteger(value, fieldName) {
    const pattern = /^[+]?\d+([eE][+]?\d+)?$/;
    return pattern.test(value) && parseFloat(value) > 0
        ? true
        : createErrorElement(
            `${fieldName}: El valor debe ser un número entero positivo.`
        );
}

/**
 * Validate that a field does not exceed the maximum value
 */
function validateMaxValue(value, max, fieldName) {
    return parseFloat(value) <= max
        ? true
        : createErrorElement(
            `${fieldName}: El valor no puede ser mayor a ${max}.`
        );
}

function getFieldName(fieldId) {
    const label = document.querySelector(`label[for="${fieldId}"]`);
    return label ? label.textContent.trim() : fieldId;
}

function validateForm(event, fields) {
    errorMessagesDiv.innerHTML = "";
    errorMessagesDiv.classList.add("hidden");

    let isValid = true;
    fields.forEach((field) => {
        const element = document.getElementById(field.id);
        const value = element ? element.value.trim() : null;
        const fieldName = getFieldName(field.id);
        const max = element ? parseFloat(element.max) : null;

        for (const check of field.checks) {
            let validation;
            switch (check.type) {
                case "empty":
                    validation = validateEmptyField(value, fieldName);
                    break;
                case "regex":
                    validation = validateField(
                        value,
                        check.regexName,
                        fieldName
                    );
                    break;
                case "daterange":
                    const startDate = document
                        .getElementById(check.startDateId)
                        .value.trim();
                    const endDate = document
                        .getElementById(check.endDateId)
                        .value.trim();
                    validation = dateCannotBeAfter(
                        startDate,
                        endDate,
                        fieldName
                    );
                    break;
                case "positiveInteger":
                    validation = validatePositiveInteger(value, fieldName);
                    break;
                case "maxValue":
                    validation = validateMaxValue(value, max, fieldName);
                    break;
                default:
                    validation = true;
            }
            if (!validation) {
                isValid = false;
                break;
            }
        }
    });

    if (!isValid) {
        event.preventDefault();
        errorMessagesDiv.classList.remove("hidden");
    }
}

function addFormValidation(formId, fields) {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener("submit", (event) => {
            validateForm(event, fields);
        });
    }
}

/**
 * Event listeners for form validation
 */
addFormValidation("contractForm", [
    {
        id: "name",
        checks: [
            {
                type: "empty",
            },
            {
                type: "regex",
                regexName: "lettersAndSpaces",
            },
        ],
    },
    {
        id: "start_date",
        checks: [
            {
                type: "empty",
            },
        ],
    },
    {
        id: "end_date",
        checks: [
            {
                type: "daterange",
                startDateId: "start_date",
                endDateId: "end_date",
            },
        ],
    },
    {
        id: "invoice_proposed",
        checks: [
            {
                type: "empty",
            },
            {
                type: "positiveInteger",
            },
            {
                type: "maxValue",
            },
        ],
    },
    {
        id: "invoice_agreed",
        checks: [
            {
                type: "empty",
            },
            {
                type: "positiveInteger",
            },
            {
                type: "maxValue",
            },
        ],
    },
    {
        id: "invoice_paid",
        checks: [
            {
                type: "empty",
            },
            {
                type: "positiveInteger",
            },
            {
                type: "maxValue",
            },
        ],
    },
]);

addFormValidation("treeTypeForm", [
    {
        id: "family",
        checks: [
            {
                type: "empty",
            },
            {
                type: "regex",
                regexName: "lettersAndSpaces",
            },
        ],
    },
    {
        id: "genus",
        checks: [
            {
                type: "empty",
            },
            {
                type: "regex",
                regexName: "lettersAndSpaces",
            },
        ],
    },
    {
        id: "species",
        checks: [
            {
                type: "empty",
            },
            {
                type: "regex",
                regexName: "lettersAndSpaces",
            },
        ],
    },
]);

// func to active the button if detect changes in the form
function checkChanges() {
    const inputs = document.querySelectorAll("input");
    const button = document.getElementById("button-save");

    let changesDetected = false;

    inputs.forEach((input) => {
        const originalValue = input.getAttribute("data-original-value");
        if (input.value !== originalValue) {
            changesDetected = true;
        }
    });

    if (changesDetected) {
        button.disabled = false;
        button.classList.remove(
            "bg-gray-400",
            "cursor-not-allowed",
            "text-gray-500"
        );
        button.classList.add(
            "bg-green-500",
            "hover:bg-green-600",
            "text-white"
        );
    } else {
        button.disabled = true;
        button.classList.add(
            "bg-gray-400",
            "cursor-not-allowed",
            "text-gray-500"
        );
        button.classList.remove(
            "bg-green-500",
            "hover:bg-green-600",
            "text-white"
        );
    }
}

function toggleAccordion(index) {
    const contentRow = document.getElementById("accordionContent" + index);
    const path = document.getElementById("accordionPath" + index);

    if (contentRow.classList.contains("hidden")) {
        contentRow.classList.remove("hidden");
        path.setAttribute("d", "M5 9l7 7 7-7");
    } else {
        contentRow.classList.add("hidden");
        path.setAttribute("d", "M9 5l7 7-7 7");
    }
}

let currentInputId = null;

function openModal(modalId, inputId) {
    currentInputId = inputId;
    const input = document.getElementById(inputId);
    const selectedValues = input.value.split(",").map((val) => val.trim());

    const modal = document.getElementById(modalId);
    const checkboxes = modal.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach((checkbox) => {
        checkbox.checked = false;
    });

    checkboxes.forEach((checkbox) => {
        const label = checkbox.nextElementSibling.textContent.trim();
        if (selectedValues.includes(label)) {
            checkbox.checked = true;
        }
    });

    modal.classList.remove("hidden");
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add("hidden");
}

function saveSelection(modalId) {
    const modal = document.getElementById(modalId);
    const checkboxes = modal.querySelectorAll('input[type="checkbox"]:checked');

    // Get selected names and IDs
    const selectedNames = Array.from(checkboxes).map((checkbox) =>
        checkbox.nextElementSibling.textContent.trim()
    );
    const selectedIds = Array.from(checkboxes).map(
        (checkbox) => checkbox.value
    );

    if (currentInputId) {
        const input = document.getElementById(currentInputId);
        input.value = selectedNames.join(", "); // Display names in the visible input

        if (currentInputId === "workersInput") {
            const hiddenInput = document.getElementById("userIdsInput");
            hiddenInput.value = selectedIds.join(","); // Store IDs in the hidden input
        }

        if (currentInputId.startsWith("zonesInput_")) {
            const blockIndex = currentInputId.split("_")[1];
            const hiddenInput = document.getElementById(
                `zonesIdsInput_${blockIndex}`
            );
            hiddenInput.value = selectedIds.join(","); // Store IDs in the hidden input
        }
    }

    modal.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
        checkbox.checked = false;
    });

    closeModal(modalId);
    currentInputId = null;
}

// Definir taskTypes antes de su uso
const taskTypes = [
    { id: 1, name: "Tarea 1" },
    { id: 2, name: "Tarea 2" },
    { id: 3, name: "Tarea 3" },
];

// Definir treeTypes antes de su uso
const treeTypes = [
    { id: 1, species: "Especie 1" },
    { id: 2, species: "Especie 2" },
    { id: 3, species: "Especie 3" },
];

let taskTypeOptions = `<option value="" disabled selected>Seleccione una tarea</option>`;
taskTypes.forEach((task_type) => {
    taskTypeOptions += `
        <option value="${task_type.id}">
            ${task_type.name}
        </option>
    `;
});

let speciesOptions = `<option value="" selected>Opcional</option>`;
treeTypes.forEach((tree_type) => {
    speciesOptions += `
        <option value="${tree_type.id}">
            ${tree_type.species}
        </option>
    `;
});

function addBlock() {
    const blocksContainer = document.getElementById("blocksContainer");
    const blockCount = blocksContainer.children.length;
    const zoneInputId = `zonesInput_${blockCount}`;
    const notesId = `notes_${blockCount}`;

    const block = document.createElement("div");
    block.className =
        "workorder-block border border-gray-300 rounded-lg shadow p-4 bg-gray-50 mb-4";
    block.dataset.blockIndex = blockCount;

    block.innerHTML = `
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Bloque <span class="block-number">${blockCount + 1
        }</span></h3>
            <button type="button" onclick="removeBlock(this)"
                class="text-red-500 hover:text-red-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
        </div>
        <div>
            <label for="${zoneInputId}" class="block text-sm font-medium text-gray-700 mb-1">Zonas</label>
            <input type="text" id="${zoneInputId}" readonly onclick="openModal('modalZones', '${zoneInputId}')"
                placeholder="Seleccionar Zonas"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-pointer focus:outline-none">
            <input type="hidden" name="blocks[${blockCount}][zonesIds]" id="zonesIdsInput_${blockCount}">
        </div>
        <div class="tasksContainer space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 my-3">Seleccionar Tareas</h3>
            </div>
        </div>
        <button type="button" onclick="addTask(this)" class="btn-create mt-4">
            Añadir Tarea
        </button>
        <div class="mt-4">
            <label for="notes_${notesId}" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
            <textarea name="blocks[${blockCount}][notes]" id="notes_${notesId}" rows="4" placeholder="Añadir notas aquí..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
        </div>
    `;

    blocksContainer.appendChild(block);
    addTask(block.querySelector(".btn-create"));
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
            <select name="blocks[${blockIndex}][tasks][${taskCount}][taskType]"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                ${taskTypeOptions}
            </select>
        </div>
        <div class="flex-auto flex items-center space-x-2">
            <span class="block text-lg font-semibold text-gray-800">Species</span>
            <select name="blocks[${blockIndex}][tasks][${taskCount}][species]"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                ${speciesOptions}
            </select>
        </div>
        <button type="button" onclick="removeTaskRow(this)"
            class="text-red-500 hover:text-red-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        </button>
    `;

    tasksContainer.appendChild(taskRow);
    updateBlock();
}

function updateBlock() {
    const blocks = document.querySelectorAll("#blocksContainer .workorder-block");
    blocks.forEach((block, index) => {
        block.dataset.blockIndex = index;
        block.querySelector(".block-number").textContent = index + 1;

        const zoneInput = block.querySelector("[id^='zonesInput_']");
        if (zoneInput) {
            zoneInput.id = `zonesInput_${index}`;
            zoneInput.setAttribute(
                "onclick",
                `openModal('modalZones', 'zonesInput_${index}')`
            );
        }

        const notesTextarea = block.querySelector("[id^='notes_']");
        if (notesTextarea) {
            notesTextarea.id = `notes_${index}`;
            notesTextarea.name = `blocks[${index}][notes]`;
        }

        const taskRows = block.querySelectorAll(".task-row");
        taskRows.forEach((taskRow, taskIndex) => {
            const taskTypeSelect = taskRow.querySelector(
                "select[name^='blocks'][name*='[taskType]']"
            );
            const speciesSelect = taskRow.querySelector(
                "select[name^='blocks'][name*='[species]']"
            );
            taskTypeSelect.name = `blocks[${index}][tasks][${taskIndex}][taskType]`;
            speciesSelect.name = `blocks[${index}][tasks][${taskIndex}][species]`;
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const blocksContainer = document.getElementById("blocksContainer");

    if (blocksContainer && blocksContainer.querySelectorAll(".workorder-block").length === 0) {
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

    const row = button.parentNode;
    row.remove();
    updateBlock();
}

function removeBlock(button) {
    const blocksContainer = document.getElementById("blocksContainer");
    const allBlocks = blocksContainer.querySelectorAll(".workorder-block");

    if (allBlocks.length === 1) {
        alert("No se puede eliminar este bloque, debe haber al menos un bloque.");
        return;
    }

    const block = button.parentNode.parentNode;
    block.remove();
    updateBlock();
}

// Function to POST on set-contract and then update the session values
async function setCurrentContract(contractId) {
    try {
        const response = await fetch('/admin/set-contract', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Set the content type to JSON
            },
            body: JSON.stringify({ contractId }), // Stringify the body
        });

        const data = await response.json();

        if (data.success) {
            window.location.reload();
        } else {
            console.error('Error:', data);
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
}
