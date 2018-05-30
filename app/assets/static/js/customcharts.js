function addMesureChart(ligneId, measureType) {
    var color = Chart.helpers.color;
    var barChartData = {
      labels: reportData.graphs[ligneId][measureType].days,
      datasets: [{
        label: reportData.metadata[measureType].label,
        backgroundColor: color('#207245').alpha(0.5).rgbString(),
        borderColor: '#558F6E',
        borderWidth: 1,
        data: reportData.graphs[ligneId][measureType].data
      }]
    };

    var ctx = document.getElementById('canvas_continu_' + ligneId+'_'+measureType).getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: barChartData,
      options: {
        responsive: true,
        legend: {
          position: 'top',
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    suggestedMax: reportData.metadata[measureType].vle * 1.1,
                }
                ,
                scaleLabel:{
                  display:true,
                    labelString: reportData.metadata[measureType].yAxisLabel
                }
            }]
        }
        ,annotation: {
          annotations: [
            {
              type: "line",
              mode: "horizontal",
              scaleID: "y-axis-0",
              value: reportData.metadata[measureType].vle,
              borderColor: "red",
              label: {
                content: reportData.metadata[measureType].thresholdLabel,
                enabled: true,
                position: "top"
              }
            }
          ]
        }
      }
    });
  }

function addDioxinesChart(ligneId) {
    var color = Chart.helpers.color;
    var barChartData = {
      labels: dioxineDashboardData.months,
      datasets: [{
        label: 'Ligne n°' + ligneId,
        backgroundColor: color('#207245').alpha(0.5).rgbString(),
        borderColor: '#558F6E',
        borderWidth: 1,
        data: dioxineDashboardData.lines[ligneId]
      }]
    };

    var ctx = document.getElementById('canvas_dioxine_' + ligneId).getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: barChartData,
      options: {
        responsive: true,
        legend: {
          position: 'top',
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    suggestedMax: 0.11,
                },
                scaleLabel:{
                  display:true,
                    labelString: "Concentration (nb/m^3)"

                }
            }]
        },
        annotation: {
          annotations: [
            {
              type: "line",
              mode: "horizontal",
              scaleID: "y-axis-0",
              value: 0.1,
              borderColor: "red",
              label: {
                content: 'Seuil : 0.1 ng/m^3.',
                enabled: true,
                position: "top"
              }
            }
          ]
        }
      }
    });
}



function addQuantiteesIncinereesChart(dashboardData) {
    var color = Chart.helpers.color;
    var barChartData = {
      labels: dashboardData.months,
      datasets: [{
        label: 'Quantitees incinérées',
        backgroundColor: color('#207245').alpha(0.5).rgbString(),
        borderColor: '#558F6E',
        borderWidth: 1,
        data: dashboardData.data
      }]
    };

    var ctx = document.getElementById('canvas_quantitees_incinerees').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: barChartData,
      options: {
        responsive: true,
        legend: {
          position: 'top',
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                },
                scaleLabel:{
                  display:true,
                    labelString: "Quantités incinérés (T)"

                }
            }]
        }
      }
    });
}




function addHeuresFonctionnementChart(dashboardData) {
    var chartData = {
      labels: dashboardData.months,
      datasets: [{
        type: 'line',
        label: 'Heures de fonctionnement théorique',
        borderColor: window.chartColors.blue,
        borderWidth: 2,
        fill: false,
        data: dashboardData.heuresTheoriques
      }, {
        type: 'bar',
        label: 'Dataset 2',
        backgroundColor: window.chartColors.red,
        data: [
          4,
          4,
          4,
          4,
          4,
          4,
          4
        ],
        borderColor: 'white',
        borderWidth: 2
      }, {
        type: 'bar',
        label: 'Dataset 3',
        backgroundColor: window.chartColors.green,
        data: [
          4,
          4,
          4,
          4,
          4,
          4,
          4
        ]
      }]
    };

    var ctx = document.getElementById('canvas_heures_fonctionnement').getContext('2d');
      window.myMixedChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
          responsive: true,
          title: {
            display: true,
            text: 'Heures de fonctionnement'
          },
          tooltips: {
            mode: 'index',
            intersect: true
          },
          scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                },
                scaleLabel:{
                  display:true,
                    labelString: "Heures de fonctionnement"

                }
            }]
          }
        }
      });s
}