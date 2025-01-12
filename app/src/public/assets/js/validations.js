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
                explanation:
                    "El campo solo puede contener números o notación científica.",
            },
            {
                name: "numbersWithTwoDecimals",
                regex: /^\d+(\.\d{1,2})?([eE][+-]?\d+)?$/,
                explanation:
                    "El campo solo puede contener números con hasta dos decimales o notación científica.",
            },
            {
                name: "noSQLInjection",
                negative: true,
                regex: /(\b(SELECT|INSERT|UPDATE|DELETE|DROP|ALTER|CREATE|TRUNCATE|EXEC|UNION|OR|AND)\b|--|;|\/\*|\*\/|@@|@|char|nchar|varchar|nvarchar|alter|begin|cast|create|cursor|declare|delete|drop|end|exec|fetch|insert|kill|open|select|sys|sysobjects|syscolumns|table|update)/i,
                explanation: "El campo contiene patrones no permitidos.",
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

        if (!pattern) return true;

        const isValid = pattern.negative
            ? !pattern.regex.test(value)
            : pattern.regex.test(value);

        return isValid
            ? true
            : this.createErrorElement(`${fieldName}: ${explanation}`);
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

    // Get the field name from the label element
    getFieldName(fieldId) {
        const label = document.querySelector(`label[for="${fieldId}"]`);
        return label ? label.textContent.trim() : fieldId;
    }

    validateForm(event) {
        this.errorMessagesDiv.innerHTML = "";
        this.errorMessagesDiv.classList.add("hidden");

        let isValid = true;
        this.fields.forEach((field) => {
            const elements = document.querySelectorAll(`[id^="${field.id}"]`);
            elements.forEach((element) => {
                const fieldName = this.getFieldName(element.id);
                const value = element ? element.value.trim() : null;
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

new FormValidator("workOrderForm", [
    {
        id: "date",
        checks: [{ type: "empty" }],
    },
    {
        id: "workersInput",
        checks: [{ type: "empty" }],
    },
    {
        id: "zonesInput_",
        checks: [{ type: "empty" }],
    },
    {
        id: "taskType_",
        checks: [{ type: "empty" }],
    },
    {
        id: "notes_",
        checks: [
            { type: "empty" },
            { type: "regex", regexName: "noSQLInjection" },
        ],
    },
]);

new FormValidator("taskTypeForm", [
    {
        id: "name",
        checks: [
            { type: "empty" },
            { type: "regex", regexName: "lettersAndSpaces" },
        ],
    },
]);
