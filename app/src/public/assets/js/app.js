function validateForm(event) {
    const errorMessagesDiv = document.getElementById('errorMessages');
    errorMessagesDiv.innerHTML = '';

    let isValid = true;

    // Comprovació del camp "name"
    var name = document.getElementById('name').value.trim();
    var nameRegex = /^[A-Za-z\s]+$/;
    if (!name) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El camp de nom no pot estar buit.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    } else if (!nameRegex.test(name)) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El nom només pot contenir lletres i espai.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    }

    // Comprovació dels camps de data
    var startDate = document.getElementById('start_date').value;
    var endDate = document.getElementById('end_date').value;
    if (!startDate) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- La data d\'inici no pot estar buida.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    }
    if (!endDate) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- La data de finalització no pot estar buida.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    }
    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- La data d\'inici no pot ser posterior a la data de finalització.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    }

    // Comprovació dels camps de preus
    var invoiceProposed = document.getElementById('invoice_proposed').value.trim();
    var invoiceAgreed = document.getElementById('invoice_agreed').value.trim();
    var invoicePaid = document.getElementById('invoice_paid').value.trim();

    if (!invoiceProposed) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El camp de preu proposat no pot estar buit.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    } else if (parseFloat(invoiceProposed) < 0) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El preu proposat no pot ser negatiu.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    }

    if (!invoiceAgreed) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El camp de preu acordat no pot estar buit.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    } else if (parseFloat(invoiceAgreed) < 0) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El preu acordat no pot ser negatiu.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    }

    if (!invoicePaid) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El camp de preu pagat no pot estar buit.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    } else if (parseFloat(invoicePaid) < 0) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El preu pagat no pot ser negatiu.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    }

    // Si hi ha errors, evita l'enviament del formulari
    if (!isValid) {
        event.preventDefault();
    } else {
        document.getElementById('contractForm').submit();
    }
}
function validateFormTreeType(event) {
    // Contenidor per a tots els errors
    const errorMessagesDiv = document.getElementById("errorMessages");

    // Netejar errors anteriors
    errorMessagesDiv.innerHTML = ""; // Eliminar contingut d'errors
    errorMessagesDiv.classList.add("hidden"); // Amagar inicialment

    let hasError = false; // Controlar si hi ha errors
    let errorMessage = ""; // Acumular missatges d'error

    // Expressió regular per validar noms (només lletres i espais)
    const namePattern = /^[a-zA-Z\s]+$/;

    // Validació de cada camp
    const family = document.getElementById("family").value.trim();
    const genus = document.getElementById("genus").value.trim();
    const species = document.getElementById("species").value.trim();

    if (!family) {
        errorMessage += "<p>- La família és obligatòria.</p>";
        hasError = true;
    } else if (!namePattern.test(family)) {
        errorMessage +=
            "<p>- La família només pot contenir lletres i espais.</p>";
        hasError = true;
    }

    if (!genus) {
        errorMessage += "<p>- El gènere és obligatori.</p>";
        hasError = true;
    } else if (!namePattern.test(genus)) {
        errorMessage +=
            "<p>- El gènere només pot contenir lletres i espais.</p>";
        hasError = true;
    }

    if (!species) {
        errorMessage += "<p>- L'espècie és obligatòria.</p>";
        hasError = true;
    } else if (!namePattern.test(species)) {
        errorMessage +=
            "<p>- L'espècie només pot contenir lletres i espais.</p>";
        hasError = true;
    }

    // Si hi ha errors, mostrar el contenidor i prevenir l'enviament del formulari
    if (hasError) {
        errorMessagesDiv.innerHTML = errorMessage; // Inserir errors al quadre
        errorMessagesDiv.classList.remove("hidden"); // Mostrar el contenidor
        event.preventDefault(); // Evitar l'enviament del formulari
    }
}

// Assignar l'esdeveniment submit al formulari
document
    .getElementById("treeForm")
    .addEventListener("submit", validateFormTreeType);
