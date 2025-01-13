// func to active the button if detect changes in the form
function checkChanges() {
    const inputs = document.querySelectorAll("input");
    const button = document.getElementById("button-save");

    const changesDetected = Array.from(inputs).some(input => {
        const originalValue = input.getAttribute("data-original-value");
        if (originalValue !== null) {
            return input.value !== originalValue;
        } else {
            // verificar el campo por si no hay data
            return input.value.trim() !== '';
        }
    });

    button.disabled = !changesDetected;
    
    
    if (changesDetected) {
        button.classList.remove("bg-gray-400", "cursor-not-allowed", "text-gray-500");
        button.classList.add("bg-green-500", "hover:bg-green-600", "text-white");
    } else {
        button.classList.add("bg-gray-400", "cursor-not-allowed", "text-gray-500");
        button.classList.remove("bg-green-500", "hover:bg-green-600", "text-white");
    }
}

// Function to POST on set-contract and then update the session values
async function setCurrentContract(contractId) {
    try {
        const response = await fetch("/admin/set-contract", {
            method: "POST",
            headers: {
                "Content-Type": "application/json", // Set the content type to JSON
            },
            body: JSON.stringify({ contractId }), // Stringify the body
        });

        const data = await response.json();

        if (data.success) {
            window.location.reload();
        } else {
            console.error("Error:", data);
        }
    } catch (error) {
        console.error("Fetch error:", error);
    }
}
