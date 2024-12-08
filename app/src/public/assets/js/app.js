function validateFormTreeType(event) {
    // Contenidor per a tots els errors
    const errorMessagesDiv = document.getElementById('errorMessages');

    // Netejar errors anteriors
    errorMessagesDiv.innerHTML = ''; // Eliminar contingut d'errors
    errorMessagesDiv.classList.add('hidden'); // Amagar inicialment

    let hasError = false; // Controlar si hi ha errors
    let errorMessage = ''; // Acumular missatges d'error

    // Expressió regular per validar noms (només lletres i espais)
    const namePattern = /^[a-zA-Z\s]+$/;

    // Validació de cada camp
    const family = document.getElementById('family').value.trim();
    const genus = document.getElementById('genus').value.trim();
    const species = document.getElementById('species').value.trim();

    if (!family) {
        errorMessage += '<p>- La família és obligatòria.</p>';
        hasError = true;
    } else if (!namePattern.test(family)) {
        errorMessage += '<p>- La família només pot contenir lletres i espais.</p>';
        hasError = true;
    }

    if (!genus) {
        errorMessage += '<p>- El gènere és obligatori.</p>';
        hasError = true;
    } else if (!namePattern.test(genus)) {
        errorMessage += '<p>- El gènere només pot contenir lletres i espais.</p>';
        hasError = true;
    }

    if (!species) {
        errorMessage += '<p>- L\'espècie és obligatòria.</p>';
        hasError = true;
    } else if (!namePattern.test(species)) {
        errorMessage += '<p>- L\'espècie només pot contenir lletres i espais.</p>';
        hasError = true;
    }

    // Si hi ha errors, mostrar el contenidor i prevenir l'enviament del formulari
    if (hasError) {
        errorMessagesDiv.innerHTML = errorMessage; // Inserir errors al quadre
        errorMessagesDiv.classList.remove('hidden'); // Mostrar el contenidor
        event.preventDefault(); // Evitar l'enviament del formulari
    }
}

// Assignar l'esdeveniment submit al formulari
document.getElementById('treeForm').addEventListener('submit', validateFormTreeType);
