// func to active the button if detect changes in the form
document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll("#accountForm input");
    inputs.forEach((input) => {
        input.addEventListener("input", checkChanges);
    });
});

function checkChanges() {
    const button = document.getElementById("button-save");

    const nameField = document.getElementById("first-name");
    const surnameField = document.getElementById("surname");

    const nameChanged =
        nameField.value !== nameField.getAttribute("data-original-value");
    const surnameChanged =
        surnameField.value !== surnameField.getAttribute("data-original-value");

    const currentPassword = document
        .getElementById("current-password")
        .value.trim();

    const newPassword = document.getElementById("new-password").value.trim();

    const confirmPassword = document
        .getElementById("confirm-password")
        .value.trim();

    const passwordChanged =
        currentPassword !== "" || newPassword !== "" || confirmPassword !== "";

    const isPasswordValid = !passwordChanged || (passwordChanged && currentPassword.length > 0);

    const changesDetected = (nameChanged || surnameChanged || passwordChanged) && isPasswordValid;


    button.disabled = !changesDetected;

    if (changesDetected) {
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
