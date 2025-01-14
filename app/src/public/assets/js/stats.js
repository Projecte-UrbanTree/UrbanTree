const taskList = [
    { work_orders_block_id: 1, task_id: 1, tree_type_id: 1, status: 0, id: 1, day: 'Dilluns', hours: 7 },
    { work_orders_block_id: 1, task_id: 2, tree_type_id: 2, status: 1, id: 2, day: 'Dimarts', hours: 6 },
    { work_orders_block_id: 2, task_id: 2, tree_type_id: 1, status: 2, id: 3, day: 'Dimecres', hours: 8 },
    { work_orders_block_id: 3, task_id: 3, tree_type_id: null, status: 2, id: 3, day: 'Dijous', hours: 9 },
    { work_orders_block_id: 3, task_id: 3, tree_type_id: null, status: 2, id: 4, day: 'Divendres', hours: 6 },
];

const notDone = taskList.filter(({ status }) => status === 0 || status === 1);
const done = taskList.filter(({ status }) => status === 2);

var options = {
    series: [
        {
            name: "Tasques no fetes",
            data: [
                notDone.filter(task => task.day === 'Dilluns').length,
                notDone.filter(task => task.day === 'Dimarts').length,
                notDone.filter(task => task.day === 'Dimecres').length,
                notDone.filter(task => task.day === 'Dijous').length,
                notDone.filter(task => task.day === 'Divendres').length,
            ],
        },
        {
            name: "Tasques fetes",
            data: [
                done.filter(task => task.day === 'Dilluns').length,
                done.filter(task => task.day === 'Dimarts').length,
                done.filter(task => task.day === 'Dimecres').length,
                done.filter(task => task.day === 'Dijous').length,
                done.filter(task => task.day === 'Divendres').length,
            ],
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
            data: [
                taskList.filter(task => task.day === 'Dilluns').reduce((acc, task) => acc + task.hours, 0),
                taskList.filter(task => task.day === 'Dimarts').reduce((acc, task) => acc + task.hours, 0),
                taskList.filter(task => task.day === 'Dimecres').reduce((acc, task) => acc + task.hours, 0),
                taskList.filter(task => task.day === 'Dijous').reduce((acc, task) => acc + task.hours, 0),
                taskList.filter(task => task.day === 'Divendres').reduce((acc, task) => acc + task.hours, 0),
            ],
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
            data: [
                taskList.filter(work_reports => work_reports.spent_fuel === 'Dilluns').reduce((acc, task) => acc + task.hours, 0),
                taskList.filter(work_reports => work_reports.spent_fuel === 'Dimarts').reduce((acc, task) => acc + task.hours, 0),
                taskList.filter(work_reports => work_reports.spent_fuel === 'Dimecres').reduce((acc, task) => acc + task.hours, 0),
                taskList.filter(work_reports => work_reports.spent_fuel === 'Dijous').reduce((acc, task) => acc + task.hours, 0),
                taskList.filter(work_reports => work_reports.spent_fuel === 'Divendres').reduce((acc, task) => acc + task.hours, 0),
            ],
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
