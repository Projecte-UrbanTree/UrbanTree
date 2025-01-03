class Validator {
    constructor(errorMessagesDiv) {
        this.errorMessagesDiv = errorMessagesDiv;
        this.regexPatterns = [
            {
                name: "lettersAndSpaces",
                regex: /^[a-zA-Z\s]+$/,
                explanation: "El campo solo puede contener letras y espacios.",
            },
            {
                name: "numbersOnly",
                regex: /^\d+([eE][+-]?\d+)?$/,
                explanation: "El campo solo puede contener números o notación científica.",
            },
            {
                name: "numbersWithTwoDecimals",
                regex: /^\d+(\.\d{1,2})?([eE][+-]?\d+)?$/,
                explanation: "El campo solo puede contener números con hasta dos decimales o notación científica.",
            },
        ];
    }

    createErrorElement(message) {
        const errorMsg = document.createElement("p");
        errorMsg.textContent = message;
        this.errorMessagesDiv.appendChild(errorMsg);
        return false;
    }

    validateEmptyField(value, fieldName) {
        return !value
            ? this.createErrorElement(
                  `${fieldName}: El campo no puede estar vacío.`
              )
            : true;
    }

    validateField(value, regexName, fieldName) {
        const pattern = this.regexPatterns.find(
            (pattern) => pattern.name === regexName
        );
        const explanation = pattern
            ? pattern.explanation
            : "El valor no es válido.";
        return pattern && !pattern.regex.test(value)
            ? this.createErrorElement(`${fieldName}: ${explanation}`)
            : true;
    }

    dateCannotBeAfter(startDate, endDate, fieldName) {
        return new Date(startDate) > new Date(endDate)
            ? this.createErrorElement(
                  `${fieldName}: La fecha inicial no puede ser posterior a la fecha final.`
              )
            : true;
    }

    validatePositiveNumber(value, fieldName) {
        return parseFloat(value) > 0
            ? true
            : this.createErrorElement(
                  `${fieldName}: El valor debe ser un número positivo.`
              );
    }

    validateMaxValue(value, max, fieldName) {
        return parseFloat(value) <= max
            ? true
            : this.createErrorElement(
                  `${fieldName}: El valor no puede ser mayor a ${max}.`
              );
    }
}

class FormValidator {
    constructor(formId, fields) {
        this.form = document.getElementById(formId);
        this.fields = fields;
        this.errorMessagesDiv = document.getElementById("errorMessages");
        this.validator = new Validator(this.errorMessagesDiv);

        if (this.form) {
            this.form.addEventListener("submit", (event) =>
                this.validateForm(event)
            );
        }
    }

    getFieldName(fieldId) {
        const label = document.querySelector(`label[for="${fieldId}"]`);
        return label ? label.textContent.trim() : fieldId;
    }

    validateForm(event) {
        this.errorMessagesDiv.innerHTML = "";
        this.errorMessagesDiv.classList.add("hidden");

        let isValid = true;
        this.fields.forEach((field) => {
            const element = document.getElementById(field.id);
            const value = element ? element.value.trim() : null;
            const fieldName = this.getFieldName(field.id);
            const max = element ? parseFloat(element.max) : null;

            for (const check of field.checks) {
                let validation;
                switch (check.type) {
                    case "empty":
                        validation = this.validator.validateEmptyField(
                            value,
                            fieldName
                        );
                        break;
                    case "regex":
                        validation = this.validator.validateField(
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
                        validation = this.validator.dateCannotBeAfter(
                            startDate,
                            endDate,
                            fieldName
                        );
                        break;
                    case "positiveNumber":
                        validation = this.validator.validatePositiveNumber(
                            value,
                            fieldName
                        );
                        break;
                    case "maxValue":
                        validation = this.validator.validateMaxValue(
                            value,
                            max,
                            fieldName
                        );
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
            this.errorMessagesDiv.classList.remove("hidden");
        }
    }
}

// Initialize form validations
new FormValidator("contractForm", [
    {
        id: "name",
        checks: [
            { type: "empty" },
            { type: "regex", regexName: "lettersAndSpaces" },
        ],
    },
    {
        id: "start_date",
        checks: [{ type: "empty" }],
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
            { type: "empty" },
            { type: "regex", regexName: "numbersWithTwoDecimals" },
            { type: "positiveNumber" },
            { type: "maxValue" },
        ],
    },
    {
        id: "invoice_agreed",
        checks: [
            { type: "empty" },
            { type: "regex", regexName: "numbersWithTwoDecimals" },
            { type: "positiveNumber" },
            { type: "maxValue" },
        ],
    },
    {
        id: "invoice_paid",
        checks: [
            { type: "empty" },
            { type: "regex", regexName: "numbersWithTwoDecimals" },
            { type: "positiveNumber" },
            { type: "maxValue" },
        ],
    },
]);

new FormValidator("treeTypeForm", [
    {
        id: "family",
        checks: [
            { type: "empty" },
            { type: "regex", regexName: "lettersAndSpaces" },
        ],
    },
    {
        id: "genus",
        checks: [
            { type: "empty" },
            { type: "regex", regexName: "lettersAndSpaces" },
        ],
    },
    {
        id: "species",
        checks: [
            { type: "empty" },
            { type: "regex", regexName: "lettersAndSpaces" },
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
    const selectedValues = Array.from(checkboxes).map((checkbox) =>
        checkbox.nextElementSibling.textContent.trim()
    );

    if (currentInputId) {
        const input = document.getElementById(currentInputId);
        input.value = selectedValues.join(", ");
    }

    modal.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
        checkbox.checked = false;
    });

    closeModal(modalId);
    currentInputId = null;
}

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
    const blockCount = blocksContainer.children.length + 1;
    const zoneInputId = `zonesInput_${blockCount}`;
    const notesId = `notes_${blockCount}`;

    const block = document.createElement("div");
    block.className =
        "border border-gray-300 rounded-lg shadow p-4 bg-gray-50 mb-4";

    block.innerHTML = `
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Bloque ${blockCount}</h3>
            <button type="button" onclick="removeBlock(this)" class="text-red-500 hover:text-red-700 focus:outline-none">
                <!-- SVG Icon -->
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
        </div>
        <div class="flex justify-end mt-4">
            <button type="button" onclick="addTask(this)"
                class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500">
                Agregar Tareas
            </button>
        </div>
        <div class="tasksContainer space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Seleccionar Tareas</h3>
            <div class="task-row flex space-x-4 items-end">
                <!-- Dropdown Task Type -->
                <div class="w-1/2">
                    <select name="taskType[]" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                        ${taskTypeOptions}
                    </select>
                </div>

                <!-- Dropdown Species -->
                <div class="w-1/2 flex items-center space-x-2">
                    <span class="block text-lg font-semibold text-gray-800">Species</span>
                    <select name="species[]" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                        ${speciesOptions}
                    </select>
                </div>

                <!-- Button Delete -->
                <button type="button" onclick="removeTaskRow(this)"
                    class="text-red-500 hover:text-red-700 focus:outline-none">
                    <!-- SVG Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                     </svg>
                </button>
            </div>
            <div>
                <!-- Add new task row -->
            </div>
            <div class="mt-4">
                <label for="notes_${notesId}" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                <textarea name="notes[]" id="notes_${notesId}" rows="4" placeholder="Añadir notas aquí..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
            </div>
        </div>
    `;

    blocksContainer.appendChild(block);
}
function addTask(button) {
    const blockContainer = button.closest(".border");
    const tasksContainer = blockContainer.querySelector(".tasksContainer");
    const notesDiv = tasksContainer.querySelector(".mt-4");

    const taskRow = document.createElement("div");
    taskRow.className = "task-row flex space-x-4 items-end";

    taskRow.innerHTML = `
        <div class="w-1/2">
            <select name="taskType[]"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                ${taskTypeOptions}
            </select>
        </div>

        <div class="w-1/2 flex items-center space-x-2">
            <span class="block text-lg font-semibold text-gray-800">Species</span>
            <select name="species[]"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                ${speciesOptions}
            </select>
        </div>

        <!-- Button Delete-->
        <button type="button" onclick="removeTaskRow(this)"
            class="text-red-500 hover:text-red-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        </button>
    `;
    tasksContainer.insertBefore(taskRow, notesDiv);
}

function removeTaskRow(button) {
    const row = button.parentNode;
    row.remove();
}

function removeBlock(button) {
    const block = button.parentNode.parentNode;
    block.remove();
}
