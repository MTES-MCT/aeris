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