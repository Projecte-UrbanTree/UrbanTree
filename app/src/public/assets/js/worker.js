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
        const newUrl = `${window.location.pathname}?date=${newDate}`;
        window.location.href = newUrl;
    } else {
        console.error("Invalid date input");
        // Handle invalid date input (e.g., show an error message or reset the input)
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
