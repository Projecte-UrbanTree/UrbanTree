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
