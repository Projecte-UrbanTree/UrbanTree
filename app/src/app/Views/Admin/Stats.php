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
        '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
      );
    window.Promise ||
      document.write(
        '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
      );
    window.Promise ||
      document.write(
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
          series: [
            {
              name: "Completat",
              data: [1, 3, 4, 7, 5],
            },
            {
              name: "Pendent",
              data: [0, 2, 3, 5, 6],
            },
          ],
          options: {
            chart: {
              type: "bar",
              height: 3,
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
          series: [
            {
              name: "Hores",
              data: [1, 3, 4, 7, 5],
            },
          ],
          options: {
            chart: {
              type: "bar",
              height: 3,
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
          series: [
            {
              name: "Consum",
              data: [23, 37, 40, 50, 70],
            },
          ],
          options: {
            chart: {
              type: "bar",
              height: 3,
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
    ReactDOM.render(React.createElement(ApexChart1), domContainer1);

    const domContainer2 = document.querySelector("#app2");
    ReactDOM.render(React.createElement(ApexChart2), domContainer2);

    const domContainer3 = document.querySelector("#app3");
    ReactDOM.render(React.createElement(ApexChart3), domContainer3);
  </script>
</body>
</html>
