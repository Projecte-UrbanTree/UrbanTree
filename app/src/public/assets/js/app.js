// func to active the button if detect changes in the form
function checkChanges() {
    const inputs = document.querySelectorAll("input");
    const button = document.getElementById("button-save");

    const changesDetected = Array.from(inputs).some(
        (input) => input.value !== input.getAttribute("data-original-value")
    );

    button.disabled = !changesDetected;
    button.classList.toggle("bg-gray-400", !changesDetected);
    button.classList.toggle("cursor-not-allowed", !changesDetected);
    button.classList.toggle("text-gray-500", !changesDetected);
    button.classList.toggle("bg-green-500", changesDetected);
    button.classList.toggle("hover:bg-green-600", changesDetected);
    button.classList.toggle("text-white", changesDetected);
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
