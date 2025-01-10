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
