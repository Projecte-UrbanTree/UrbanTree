var options = {
    series: [
        {
            name: "Tareas no hechas",
            data: tasksNotDoneCount,
        },
        {
            name: "Tareas hechas",
            data: tasksDoneCount,
        },
    ],
    chart: {
        type: "bar",
        height: 350,
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "55%",
            borderRadius: 5,
            borderRadiusApplication: "end",
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
    },
    xaxis: {
        categories: [
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
        ],
    },
    yaxis: {
        title: {
            text: "Número de Tareas",
        },
    },
    fill: {
        opacity: 1,
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val;
            },
        },
    },
};

var chart = new ApexCharts(document.querySelector("#app1"), options);
chart.render();

var options2 = {
    series: [
        {
            name: "Horas trabajadas",
            data: hoursWorked,
        },
    ],
    chart: {
        type: "bar",
        height: 350,
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "55%",
            borderRadius: 5,
            borderRadiusApplication: "end",
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
    },
    xaxis: {
        categories: [
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
        ],
    },
    yaxis: {
        title: {
            text: "Horas trabajadas",
        },
    },
    fill: {
        opacity: 1,
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val;
            },
        },
    },
};

var chart2 = new ApexCharts(document.querySelector("#app2"), options2);
chart2.render();

var options3 = {
    series: [
        {
            name: "Consumo",
            data: fuelConsumption,
        },
    ],
    chart: {
        type: "bar",
        height: 350,
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "55%",
            borderRadius: 5,
            borderRadiusApplication: "end",
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
    },
    xaxis: {
        categories: [
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
        ],
    },
    yaxis: {
        title: {
            text: "Consumo de gasoil",
        },
    },
    fill: {
        opacity: 1,
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val;
            },
        },
    },
};

var chart3 = new ApexCharts(document.querySelector("#app3"), options3);
chart3.render();
