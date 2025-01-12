const dateInput = document.getElementById("date-input");
const prevDay = document.getElementById("prev-day");
const nextDay = document.getElementById("next-day");

function changeDate(days) {
    const currentDate = new Date(dateInput.value);
    currentDate.setDate(currentDate.getDate() + days);
    dateInput.value = currentDate.toISOString().split("T")[0];

    const newUrl = `${window.location.pathname}?date=${dateInput.value}`;
    window.location.href = newUrl;
}

prevDay.addEventListener("click", () => changeDate(-1));
nextDay.addEventListener("click", () => changeDate(1));
