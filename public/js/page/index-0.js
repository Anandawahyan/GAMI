"use strict";

var statistics_chart = document.getElementById("myChart1").getContext('2d');
var top_selling_categories_colors_chart = document.getElementById("myChart2").getContext('2d');
var customerRetentionRateChart = document.getElementById("myChart3").getContext('2d');
var men_women_demographic = document.getElementById("myChart4").getContext('2d');
var age_group_chart = document.getElementById("myChart5").getContext('2d');
let delayed;


$.ajax({
  url: '/executive/chart',
  type: 'get',
  dataType: 'json',
  success: function(response) {
    const { salesByChartContent, 
      topSellingCategoriesColorsChartContent, 
      categories, 
      customerRetentionRateData, 
      menWomenDemographicData,
      ageGroupMale,
      ageGroupFemale,
     } = response.data;
     console.log(ageGroupMale)
    var myChart = new Chart(statistics_chart, {
      type: 'line',
      data: {
        labels: salesByChartContent.map((s, index) => index+1),
        datasets: [{
          label: 'Pendapatan per Minggu',
          data: salesByChartContent.map(s => s.total_amount),
          borderWidth: 5,
          borderColor: '#6777ef',
          backgroundColor: 'transparent',
          pointBackgroundColor: '#fff',
          pointBorderColor: '#6777ef',
          pointRadius: 4
        }]
      },
      options: {
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: false,
              drawBorder: false,
            },
            ticks: {
              stepSize: 150000,
              callback: function (value, index, values) {
                return `Rp${value}`
            },
            }
          }],
          xAxes: [{
            gridLines: {
              color: '#fbfbfb',
              lineWidth: 2
            }
          }]
        },
      }
    });

    var chart1 = new Chart(top_selling_categories_colors_chart, {
      type: 'bar',
      data: {
         labels: categories.map(c => c.name), 
         datasets: topSellingCategoriesColorsChartContent.map(color => {
          console.log(color.array_per_category);
          return {
            label: color.color,
            data: color.array_per_category,
            backgroundColor: color.color === 'Multi' ? 'salmon' : color.color.toLowerCase()
          }
         })
      },
      options: {
         responsive: true,
         scales: {
            xAxes: [{
               stacked: true // this should be set to make the bars stacked
            }],
            yAxes: [{
               stacked: true // this also..
            }]
         }
      }
   });

   var chart2 = new Chart(customerRetentionRateChart, {
    type: "bar",
  data: {
    labels: ['This Month', 'Previous Month'],
    datasets: [{
      backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(75, 192, 192, 0.2)',],
      data: customerRetentionRateData
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: false,
    },
    scales: {
      yAxes: [
        {
            gridLines: {
                // display: false,
                drawBorder: false,
                color: "#f2f2f2",
            },
            ticks: {
                beginAtZero: true,
                callback: function (value, index, values) {
                    return `${value}%`
                },
            },
        },
    ],
    }
  }
 });

var menWomenDemographicChart = new Chart(men_women_demographic, {
  type: 'pie',
  data: {
    datasets: [{
      data: menWomenDemographicData.map(m => m['JUMLAH']),
      backgroundColor: [
        '#FF78C4',
        'rgba(54, 162, 235, 1)',
      ],
      label: 'Dataset 1'
    }],
    labels: menWomenDemographicData.map(m => m["JENIS KELAMIN"]),
  },
  options: {
    responsive: true,
    legend: {
      position: 'bottom',
    },
  }
});

var ageGroupChart = new Chart(age_group_chart, {
  type: 'bar',
  data: {
     labels: ageGroupMale.map(group => group.age_group), 
     datasets: [
      {
        label: "Laki-laki",
        data: ageGroupMale.map(group => group.customer_count),
        backgroundColor: "rgba(54, 162, 235, 1)"
      },
      {
        label: "Perempuan",
        data: ageGroupFemale.map(group => group.customer_count),
        backgroundColor: "#FF78C4"
      },
     ]
  },
  options: {
     responsive: true,
     scales: {
        xAxes: [{
           stacked: true // this should be set to make the bars stacked
        }],
        yAxes: [{
           stacked: true // this also..
        }]
     }
  }
});
  },
  error: function(e) {
    console.log(e.responseText);
  }
});



$('#visitorMap').vectorMap(
{
  map: 'world_en',
  backgroundColor: '#ffffff',
  borderColor: '#f2f2f2',
  borderOpacity: .8,
  borderWidth: 1,
  hoverColor: '#000',
  hoverOpacity: .8,
  color: '#ddd',
  normalizeFunction: 'linear',
  selectedRegions: false,
  showTooltip: true,
  pins: {
    id: '<div class="jqvmap-circle"></div>',
    my: '<div class="jqvmap-circle"></div>',
    th: '<div class="jqvmap-circle"></div>',
    sy: '<div class="jqvmap-circle"></div>',
    eg: '<div class="jqvmap-circle"></div>',
    ae: '<div class="jqvmap-circle"></div>',
    nz: '<div class="jqvmap-circle"></div>',
    tl: '<div class="jqvmap-circle"></div>',
    ng: '<div class="jqvmap-circle"></div>',
    si: '<div class="jqvmap-circle"></div>',
    pa: '<div class="jqvmap-circle"></div>',
    au: '<div class="jqvmap-circle"></div>',
    ca: '<div class="jqvmap-circle"></div>',
    tr: '<div class="jqvmap-circle"></div>',
  },
});

// weather
getWeather();
setInterval(getWeather, 600000);

function getWeather() {
  $.simpleWeather({
  location: 'Bogor, Indonesia',
  unit: 'c',
  success: function(weather) {
    var html = '';
    html += '<div class="weather">';
    html += '<div class="weather-icon text-primary"><span class="wi wi-yahoo-' + weather.code + '"></span></div>';
    html += '<div class="weather-desc">';
    html += '<h4>' + weather.temp + '&deg;' + weather.units.temp + '</h4>';
    html += '<div class="weather-text">' + weather.currently + '</div>';
    html += '<ul><li>' + weather.city + ', ' + weather.region + '</li>';
    html += '<li> <i class="wi wi-strong-wind"></i> ' + weather.wind.speed+' '+weather.units.speed + '</li></ul>';
    html += '</div>';
    html += '</div>';

    $("#myWeather").html(html);
  },
  error: function(error) {
    $("#myWeather").html('<div class="alert alert-danger">'+error+'</div>');
  }
  });
}
