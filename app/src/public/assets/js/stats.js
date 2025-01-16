var options = {
    series: [
        {
            name: "Tasques no fetes",
            data: tasksNotDoneCount,
        },
        {
            name: "Tasques fetes",
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
            "Dilluns",
            "Dimarts",
            "Dimecres",
            "Dijous",
            "Divendres",
        ],
    },
    yaxis: {
        title: {
            text: "Número de Tasques",
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

var options = {
    series: [
        {
            name: "Hores treballades",
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
            "Dilluns",
            "Dimarts",
            "Dimecres",
            "Dijous",
            "Divendres",
        ],
    },
    yaxis: {
        title: {
            text: "Hores treballades",
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

var chart = new ApexCharts(document.querySelector("#app2"), options);
chart.render();



var options = {
    series: [
        {
            name: "Consum",
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
            "Dilluns",
            "Dimarts",
            "Dimecres",
            "Dijous",
            "Divendres",
        ],
    },
    yaxis: {
        title: {
            text: "Consum de gasoil",
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

var chart = new ApexCharts(document.querySelector("#app3"), options);
chart.render();
