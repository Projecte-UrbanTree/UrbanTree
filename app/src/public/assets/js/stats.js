console.log(tasks);
// resultado de console.log(tasks);
// {work_orders_block_id: 1, task_id: 1, tree_type_id: 1, status: 0, id: 1}
// {work_orders_block_id: 1, task_id: 2, tree_type_id: 2, status: 1, id: 2}
// {work_orders_block_id: 2, task_id: 2, tree_type_id: null, status: 0, id: 3}
// {work_orders_block_id: 3, task_id: 3, tree_type_id: null, status: 2, id: 4}

// Necesito de la constante tasks, separar de forma dinamica el número de tasks por status, no hechos: 0 y 1, hechos: 2
// const notDone = tasks.filter(({ status }) => status === 0 || status === 1);
// const done = tasks.filter(({ status }) => status === 2);

var options = {
    series: [
        {
            name: "Net Profit",
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
        },
        {
            name: "Revenue",
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
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
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
        ],
    },
    yaxis: {
        title: {
            // text: "$ (thousands)",
        },
    },
    fill: {
        opacity: 1,
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$ " + val + " thousands";
            },
        },
    },
};

var chart = new ApexCharts(document.querySelector("#app1"), options);
chart.render();
