
//Validacio de contractes

function validateForm(event) {
    const errorMessagesDiv = document.getElementById('errorMessages');
    errorMessagesDiv.innerHTML = ''; 

    let isValid = true; 

   
    var name = document.getElementById('name').value;
    var nameRegex = /^[A-Za-z\s]+$/; 
    if (!nameRegex.test(name)) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El nom només pot contenir lletres i espais.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md'); 
        errorMessagesDiv.appendChild(errorMsg);
    }

    var startDate = document.getElementById('start_date').value;
    var endDate = document.getElementById('end_date').value;
    if (new Date(startDate) > new Date(endDate)) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- La data d\'inici no pot ser posterior a la data de finalització.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md'); 
        errorMessagesDiv.appendChild(errorMsg);
    }


    var invoiceProposed = parseFloat(document.getElementById('invoice_proposed').value);
    var invoiceAgreed = parseFloat(document.getElementById('invoice_agreed').value);
    var invoicePaid = parseFloat(document.getElementById('invoice_paid').value);

    if (invoiceProposed < 0) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El preu proposat no pot ser negatiu.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md'); 
        errorMessagesDiv.appendChild(errorMsg);
    }
    if (invoiceAgreed < 0) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El preu acordat no pot ser negatiu.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md');
        errorMessagesDiv.appendChild(errorMsg);
    }
    if (invoicePaid < 0) {
        isValid = false;
        const errorMsg = document.createElement('p');
        errorMsg.textContent = '- El preu pagat no pot ser negatiu.';
        errorMsg.classList.add('text-red-600', 'font-medium', 'bg-red-100', 'p-2', 'rounded-md'); 
        errorMessagesDiv.appendChild(errorMsg);
    }

    
    if (!isValid) {
        event.preventDefault();
    } else {
        
        document.getElementById('contractForm').submit();
    }
}
