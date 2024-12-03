document.getElementById("form").addEventListener("submit", function (e) {
    event.preventDefault();


    const name = document.getElementById("name").value.trim();
    const startDate = document.getElementById("start_date").value.trim();
    const endDate = document.getElementById("end_date").value.trim();
    const invoiceProposed = document.getElementById("invoice_proposed").value.trim();
    const invoiceAgreed = document.getElementById("invoice_agreed").value.trim();
    const invoicePaid = document.getElementById("invoice_paid").value.trim();
    

    let errorMessage = '';
    
    const namePattern = /^[a-zA-Z\s]+$/;
    if (!name) {
        errorMessage += 'Name is required.<br>';
    } else if (!namePattern.test(name)) {
        errorMessage += 'Name must only contain letters and spaces.<br>';
    }

    const startDatePattern = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/;
    if (!startDate) {
        errorMessage += 'Start Date is required.<br>';
    } else if (!startDatePattern.test(startDate)) {
        errorMessage += 'Start Date must be in the format YYYY-MM-DDTHH:MM.<br>';
    }

    const endDatePattern = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/;
    if (!endDate) {
        errorMessage += 'End Date is required.<br>';
    } else if (!endDatePattern.test(endDate)) {
        errorMessage += 'End Date must be in the format YYYY-MM-DDTHH:MM.<br>';
    }

    const invoiceProposedPattern = /^\d+(\.\d{1,2})?$/;
    if (!invoiceProposed) { 
        errorMessage += 'Invoice Proposed is required.<br>';    
    } else if (!invoiceProposedPattern.test(invoiceProposed)) {
        errorMessage += 'Invoice Proposed must be a number.<br>';
    }

    const invoiceAgreedPattern = /^\d+(\.\d{1,2})?$/;
    if (!invoiceAgreed) { 
        errorMessage += 'Invoice Agreed is required.<br>';    
    } else if (!invoiceAgreedPattern.test(invoiceAgreed)) {
        errorMessage += 'Invoice Agreed must be a number.<br>';
    }

    const invoicePaidPattern = /^\d+(\.\d{1,2})?$/;
    if (!invoicePaid) { 
        errorMessage += 'Invoice Paid is required.<br>';    
    } else if (!invoicePaidPattern.test(invoicePaid)) {
        errorMessage += 'Invoice Paid must be a number.<br>';
    }
    
    if (errorMessage) {
        alert(errorMessage);
        return false;
    }       
    }
)