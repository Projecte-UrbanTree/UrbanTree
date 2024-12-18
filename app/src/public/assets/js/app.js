function initDropdown(menuButtonId, dropdownMenuId, itemSelector) {
    document.addEventListener('DOMContentLoaded', function () {
      const menuButton = document.getElementById(menuButtonId);
      const dropdownMenu = document.getElementById(dropdownMenuId);
  
      // Mostrar o amagar el menú desplegable
      menuButton.addEventListener('click', function (event) {
        event.stopPropagation(); // Evitar que l'esdeveniment es propagui
        dropdownMenu.classList.toggle('hidden');
      });
  
      // Tancar el desplegable si es fa clic fora
      document.addEventListener('click', function (event) {
        if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
          dropdownMenu.classList.add('hidden');
        }
      });
  
      // Gestionar la selecció d'un contracte
      const dropdownItems = dropdownMenu.querySelectorAll(itemSelector);
      dropdownItems.forEach(function (item) {
        item.addEventListener('click', function () {
          const selectedContractName = item.innerText;
          menuButton.textContent = `Contrato: ${selectedContractName}`;
          dropdownMenu.classList.add('hidden'); // Amagar el desplegable després de la selecció
        });
      });
    });
  }
  



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
              `${fieldName}: La fecha de inicio no puede ser posterior a la fecha de fin.`
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

// Variable global para saber qué input se está editando
let currentInput = null;
let rowIndex = 0;

document.getElementById("addRow").addEventListener("click", addRow);

function addRow(event) {
    event.preventDefault();

    const table = document.getElementById("workOrderTable");
    const newRow = table.insertRow();
    rowIndex++;

    newRow.innerHTML = `
    <td class="px-5 py-4">
        <input type="text" name="zones[]" id="zonesDisplay_${rowIndex}"
            class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
            onclick="openModal('zonesDisplay_${rowIndex}', data.zones)">
    </td>
    <td class="px-5 py-4">
        <input type="text" name="tasks[]" id="tasksDisplay_${rowIndex}"
            class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
            onclick="openModal('tasksDisplay_${rowIndex}', data.tasks)">
    </td>
    <td class="px-5 py-4">
        <input type="text" name="workers[]" id="workersDisplay_${rowIndex}"
            class="w-full px-2 py-1 border rounded-lg bg-gray-100 cursor-pointer" readonly
            onclick="openModal('workersDisplay_${rowIndex}', data.workers)">
    </td>
    <td class="px-5 py-4">
        <input type="text" name="notes[]" class="w-full px-2 py-1 border rounded-lg">
    </td>
    <td class="px-5 py-4 text-center">
        <button type="button" class="bg-red-500 text-white px-2 py-1 rounded hover:scale-110"
            onclick="removeRow(this)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        </button>
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
    const modal = document.getElementById("selectionModal"); // Obtén el modal
    const modalOptions = document.getElementById("modalOptions"); // Contenedor de opciones

    // Limpia opciones anteriores
    modalOptions.innerHTML = "";

    // Agrega las opciones al modal
    options.forEach((option) => {
        const listItem = document.createElement("li");
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
        const selectedValues = currentInput.value
            .split(",")
            .map((value) => value.trim());
        modalOptions
            .querySelectorAll('input[type="checkbox"]')
            .forEach((checkbox) => {
                if (selectedValues.includes(checkbox.value.trim())) {
                    checkbox.checked = true;
                }
            });
    }

    // Muestra el modal
    modal.classList.remove("hidden");
}

// Función para cerrar el modal
function closeModal() {
    const modal = document.getElementById("selectionModal");
    modal.classList.add("hidden"); // Oculta el modal
}

// Función para aplicar la selección
function applySelection() {
    const selectedOptions = []; // Lista para guardar opciones seleccionadas
    const checkboxes = document.querySelectorAll("#modalOptions input:checked");

    // Obtén las opciones seleccionadas
    checkboxes.forEach((checkbox) => {
        selectedOptions.push(checkbox.value.trim());
    });

    // Coloca las opciones seleccionadas en el input actual
    if (currentInput) {
        currentInput.value = selectedOptions.join(", "); // Muestra seleccionadas separadas por coma
    }

    // Cierra el modal
    closeModal();
}

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
