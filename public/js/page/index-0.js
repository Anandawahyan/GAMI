"use strict";

var statistics_chart = document.getElementById("myChart1").getContext('2d');
var top_selling_categories_colors_chart = document.getElementById("myChart2").getContext('2d');
var customerRetentionRateChart = document.getElementById("myChart3").getContext('2d');
var men_women_demographic = document.getElementById("myChart4").getContext('2d');
var age_group_chart = document.getElementById("myChart5").getContext('2d');
var rfm_section_chart = document.getElementById("myChart6").getContext('2d');
var total_spending_category_chart = document.getElementById("myChart7").getContext('2d');
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
      RFMGroupingCustomers,
      totalSpendingCategoryData
     } = response.data;
    console.log(menWomenDemographicData);
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
    var RfmSectionChart = new Chart(rfm_section_chart, {
      type: 'pie',
      data: {
        datasets: [{
          data: Object.values(RFMGroupingCustomers),
          backgroundColor: [
            '#9AC5F4',
            '#F1C376',
            '#F5EFE7'
          ],
          label: 'Dataset 1'
        }],
        labels: Object.keys(RFMGroupingCustomers),
      },
      options: {
        responsive: true,
        legend: {
          position: 'bottom',
        },
      }
    });
    var totalSpendingChart = new Chart(total_spending_category_chart, {
      type: "bar",
    data: {
      labels: totalSpendingCategoryData.map(category => category.spending_category),
      datasets: [{
        backgroundColor: [ '#9AC5F4','#F1C376','#F5EFE7'],
        data: totalSpendingCategoryData.map(category => category.customer_count)
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
              },
          },
      ],
      }
    }
   });
  },
  error: function(e) {
    console.log(e.responseText);
  }
});

$.ajax({
  url: '/executive/analysis/marketing',
  type: 'get',
  dataType: 'json',
  async: true,
  success: function(response) {
    $('.marketing-analysis').text(response.choices[0].text);
  },
  error: function(xhr, status, error) {
    // Handle the error
    console.error(error);
  }
});

$.ajax({
  url: '/executive/analysis/rfm',
  type: 'get',
  dataType: 'json',
  success: function(response) {
    $('.rfm-analysis').text(response.choices[0].text);
  }
});

$.ajax({
  url: '/executive/analysis/review',
  type: 'get',
  dataType: 'json',
  success: function(response) {
    $('.review-analysis').text(response.choices[0].text);
  },
  error: function(e) {
    console.log(e.responseText);
  }
});


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
