const dateInput = document.getElementById("date-input");
const prevDay = document.getElementById("prev-day");
const nextDay = document.getElementById("next-day");

function changeDate(days) {
    const currentDate = new Date(dateInput.value);
    currentDate.setDate(currentDate.getDate() + days);
    dateInput.value = currentDate.toISOString().split("T")[0];

    updateUrl(dateInput.value);
}

function updateUrl(newDate) {
    if (isValidDate(newDate)) {
        const encodedDate = encodeURIComponent(newDate);
        const newUrl = `${window.location.pathname}?date=${encodedDate}`;
        window.location.href = newUrl;
    } else {
        console.error("Invalid date input");
    }
}

prevDay.addEventListener("click", () => changeDate(-1));
nextDay.addEventListener("click", () => changeDate(1));

dateInput.addEventListener("change", () => {
    updateUrl(dateInput.value);
});

function isValidDate(dateString) {
    const date = new Date(dateString);
    return !isNaN(date.getTime());
}

document.querySelectorAll(".task-checkbox").forEach((checkbox) => {
    checkbox.addEventListener("change", async (event) => {
        const taskId = event.target.dataset.taskId;
        const statusValue = event.target.checked ? 1 : 0;

        const formData = new FormData();
        formData.append(`tasks[${taskId}]`, statusValue);

        try {
            await fetch("/worker/work-orders/update-status", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData,
            });

        } catch (error) {
            console.error("Network error:", error);
        }
    });
});

function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden');
}

function toggleSelection(resourceName, resourceId, typeName) {
    const selectedSpan = document.getElementById(`selected-${typeName}`);
    const checkIcon = document.getElementById(`check-${resourceId}`);
    const selectElement = document.getElementById(`resource_${typeName}`);
    const optionElement = selectElement.querySelector(`option[value="${resourceId}"]`);

    if (checkIcon.classList.contains('hidden')) {
        checkIcon.classList.remove('hidden');
        optionElement.selected = true;
    } else {
        checkIcon.classList.add('hidden');
        optionElement.selected = false;
    }

    const selectedTexts = Array.from(selectElement.selectedOptions).map(o => o.text);
    selectedSpan.textContent = selectedTexts.length ? selectedTexts.join(', ') : 'Seleccione recursos...';
}