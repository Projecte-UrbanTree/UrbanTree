<!doctype html>
<html lang="ca">
<head>
    <meta charset="utf-8">
    <title>Gràfics amb Dades de la Base de Dades</title>
</head>
<body>
    <div class="max-w-6xl mx-auto my-16">
        <div id="charts-container" class="grid grid-cols-3 gap-4 bg-gray-100 relative">
            <div class="col" id="app1"></div>
            <div class="col" id="app2"></div>
            <div class="col" id="app3"></div>
        </div>
    </div>

    <script>
        window.Promise ||
            document.write(
                '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>' +
                '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>' +
                '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
            );
    </script>

    <script src="https://cdn.jsdelivr.net/npm/react@16.12/umd/react.production.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/react-dom@16.12/umd/react-dom.production.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prop-types@15.7.2/prop-types.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/react-apexcharts@1.3.6/dist/react-apexcharts.iife.min.js"></script>

    <script type="text/babel">

        class ApexChart1 extends React.Component {
            constructor(props) {
                super(props);
                this.state = {
                    series: [],
                    options: {
                        chart: {
                            type: "bar",
                            height: 350,
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "55%",
                                endingShape: "rounded",
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
                            categories: ["Lun", "Mar", "Mie", "Jue", "Vie"],  // Valor per defecte
                        },
                        yaxis: {
                            title: {
                                text: "Tasques",
                            },
                        },
                        fill: {
                            opacity: 1,
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "" + val + " Tasques";
                                },
                            },
                        },
                    },
                };
            }

            componentDidMount() {
                fetch('/admin/stats/grafica?endpoint=dades1')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Leer la respuesta como JSON
                    })
                    .then(data => {
                        if (data && data.length > 0) {
                            this.setState({
                                series: [
                                    {
                                        name: "Completat",
                                        data: data.map(item => item.valor),
                                    },
                                ],
                                options: {
                                    ...this.state.options,
                                    xaxis: {
                                        categories: data.map(item => item.name),
                                    },
                                },
                            });
                        } else {
                            console.error("No data received for 'dades1'");
                        }
                    })
                    .catch(error => console.error('Error fetching data for dades1:', error));
            }

            render() {
                return (
                    <div id="chart1">
                        <ReactApexChart
                            options={this.state.options}
                            series={this.state.series}
                            type="bar"
                            height={350}
                        />
                    </div>
                );
            }
        }

        class ApexChart2 extends React.Component {
            constructor(props) {
                super(props);
                this.state = {
                    series: [],
                    options: {
                        chart: {
                            type: "bar",
                            height: 350,
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "55%",
                                endingShape: "rounded",
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
                            categories: ["Lun", "Mar", "Mie", "Jue", "Vie"],
                        },
                        yaxis: {
                            title: {
                                text: "Hores Treballades",
                            },
                        },
                        fill: {
                            opacity: 1,
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "" + val + " Hores";
                                },
                            },
                        },
                    },
                };
            }

            componentDidMount() {
                fetch('/admin/stats/grafica?endpoint=dades2')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Leer la respuesta como JSON
                    })
                    .then(data => {
                        if (data && data.length > 0) {
                            this.setState({
                                series: [
                                    {
                                        name: "Hores",
                                        data: data.map(item => item.valor),
                                    },
                                ],
                                options: {
                                    ...this.state.options,
                                    xaxis: {
                                        categories: data.map(item => item.name),
                                    },
                                },
                            });
                        } else {
                            console.error("No data received for 'dades2'");
                        }
                    })
                    .catch(error => console.error('Error fetching data for dades2:', error));
            }

            render() {
                return (
                    <div id="chart2">
                        <ReactApexChart
                            options={this.state.options}
                            series={this.state.series}
                            type="bar"
                            height={350}
                        />
                    </div>
                );
            }
        }

        class ApexChart3 extends React.Component {
            constructor(props) {
                super(props);
                this.state = {
                    series: [],
                    options: {
                        chart: {
                            type: "bar",
                            height: 350,
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "55%",
                                endingShape: "rounded",
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
                            categories: ["Lun", "Mar", "Mie", "Jue", "Vie"],  // Valor per defecte
                        },
                         yaxis: {
                            title: {
                                text: "Consum",
                            },
                        },
                        fill: {
                            opacity: 1,
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "" + val + " Litros";
                                },
                            },
                        },
                    },
                };
            }

            componentDidMount() {
                fetch('/admin/stats/grafica?endpoint=dades3')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Leer la respuesta como JSON
                    })
                    .then(data => {
                        if (data && data.length > 0) {
                            this.setState({
                                series: [
                                    {
                                        name: "Consum",
                                        data: data.map(item => item.valor),
                                    },
                                ],
                                options: {
                                    ...this.state.options,
                                    xaxis: {
                                        categories: data.map(item => item.name),
                                    },
                                },
                            });
                        } else {
                            console.error("No data received for 'dades3'");
                        }
                    })
                    .catch(error => console.error('Error fetching data for dades3:', error));
            }

            render() {
                return (
                    <div id="chart3">
                        <ReactApexChart
                            options={this.state.options}
                            series={this.state.series}
                            type="bar"
                            height={350}
                        />
                    </div>
                );
            }
        }

        const domContainer1 = document.querySelector("#app1");
        if (domContainer1) {
            ReactDOM.render(React.createElement(ApexChart1), domContainer1);
        }

        const domContainer2 = document.querySelector("#app2");
        if (domContainer2) {
            ReactDOM.render(React.createElement(ApexChart2), domContainer2);
        }

        const domContainer3 = document.querySelector("#app3");
        if (domContainer3) {
            ReactDOM.render(React.createElement(ApexChart3), domContainer3);
        }

    </script>
</body>
</html>
