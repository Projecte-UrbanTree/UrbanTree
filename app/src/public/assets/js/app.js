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

    const contentRow = document.getElementById('accordionContent' + index);
    const path = document.getElementById('accordionPath' + index);

    if (contentRow.classList.contains('hidden')) {
        contentRow.classList.remove('hidden');
        path.setAttribute('d', 'M5 9l7 7 7-7');
    } else {
        contentRow.classList.add('hidden');
        path.setAttribute('d', 'M9 5l7 7-7 7');
    }
}

function openModal(modalId) {
    document.getElementById(modalId).classList.remove("hidden");
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add("hidden");
}

function saveSelection(modalId, inputId) {
    const modal = document.getElementById(modalId);
    const checkboxes = modal.querySelectorAll('input[type="checkbox"]:checked');
    const selectedValues = Array.from(checkboxes).map(checkbox => checkbox.nextElementSibling.textContent.trim());

    const input = document.getElementById(inputId);
    input.value = selectedValues.join(", ");

    closeModal(modalId);
}

function addTask() {
    const tasksContainer = document.getElementById('tasksContainer');

    const taskRow = document.createElement('div');
    taskRow.className = 'task-row flex space-x-4 items-end';

    taskRow.innerHTML = `
        <div class="w-1/2">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Seleccionar Tareas</h3>
            <select name="taskType" id="taskType"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled selected>Seleccione una tarea</option>
                <?php foreach ($task_types as $task_type) { ?>
                    <option value="<?php echo htmlspecialchars($task_type->getId()); ?>">
                        <?php echo htmlspecialchars($task_type->name); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="w-1/2 flex items-center space-x-2">
            <span class="block text-lg font-semibold text-gray-800">Species</span>
            <select name="species" id="species"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                <option value="" selected>Opcional</option>
                <?php foreach ($tree_types as $tree_type) { ?>
                    <option value="<?php echo htmlspecialchars($tree_type->getId()); ?>">
                        <?php echo htmlspecialchars($tree_type->species); ?>
                    </option>
                <?php } ?>
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

    tasksContainer.appendChild(taskRow);
}

function removeTaskRow(button) {
    const row = button.parentNode.parentNode;
    row.remove();
}