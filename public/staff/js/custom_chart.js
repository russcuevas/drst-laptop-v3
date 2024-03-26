// comparison of sales
var currentYear = new Date().getFullYear();
var selectYearSales = document.getElementById('selectYearSales');
var selectYearComparison = document.getElementById('selectYearComparison');

for (var year = 2020; year <= currentYear; year++) {
    var optionSales = document.createElement('option');
    optionSales.value = year;
    optionSales.textContent = year;
    selectYearSales.appendChild(optionSales);

    var optionComparison = document.createElement('option');
    optionComparison.value = year;
    optionComparison.textContent = year;
    selectYearComparison.appendChild(optionComparison);
}

selectYearSales.value = currentYear;
selectYearComparison.value = currentYear;

selectYearSales.addEventListener('change', updateComparisonChart);
selectYearComparison.addEventListener('change', updateComparisonChart);
updateComparisonChart();

function updateComparisonChart() {
    selectedYearSales = parseInt(document.getElementById('selectYearSales').value);
    selectedYearComparison = parseInt(document.getElementById('selectYearComparison').value);

    fetch(`/staff-comparison-sales?yearSales=${selectedYearSales}&yearComparison=${selectedYearComparison}`)
        .then(response => response.json())
        .then(data => renderComparisonChart(data))
        .catch(error => console.error('Error fetching sales comparison data:', error));
}

function renderComparisonChart(data) {
    var ctx = document.getElementById('line-comparison-chart').getContext('2d');
    var months = Object.keys(data);
    var monthNames = [
        'June', 'July', 'August', 'September', 'October', 'November', 'December',
        'January', 'February', 'March', 'April', 'May'
    ];
    var weeks = monthNames.slice(0, 12);

    if (window.comparisonChart) {
        window.comparisonChart.destroy();
    }

    window.comparisonChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: weeks,
            datasets: [{
                label: `Sales (${selectedYearSales})`,
                data: months.map(month => data[month].sales),
                borderColor: '#0f3d71',
                borderWidth: 2,
                fill: false
            }, {
                label: `Sales (${selectedYearComparison})`,
                data: months.map(month => data[month].comparison),
                borderColor: 'red',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Sales'
                    }
                }
            }
        }
    });
}
// end of comparison sales

// weekly sales
var myChart;
var selectedYear = new Date().getFullYear();
var selectedMonth = new Date().getMonth() + 1;

document.getElementById('selectYear').addEventListener('change', function () {
    selectedYear = parseInt(this.value);
    updateChart();
});

document.getElementById('selectMonth').addEventListener('change', function () {
    selectedMonth = parseInt(this.value);
    updateChart();
});

function populateYearSelectOptions() {
    var currentYear = new Date().getFullYear();
    var selectYear = document.getElementById('selectYear');
    for (var year = 2020; year <= currentYear; year++) {
        var optionYear = new Option(year, year);
        selectYear.appendChild(optionYear);
    }
    selectYear.value = selectedYear;
}

function populateMonthSelectOptions() {
    var selectMonth = document.getElementById('selectMonth');
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    for (var i = 0; i < monthNames.length; i++) {
        var optionMonth = new Option(monthNames[i], i + 1);
        selectMonth.appendChild(optionMonth);
    }
    selectMonth.value = selectedMonth;
}

function updateChart() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/staff-weekly-sales?year=' + selectedYear + '&month=' + selectedMonth, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var weeklySalesData = JSON.parse(xhr.responseText);
            renderChart(weeklySalesData);
        }
    };

    xhr.send();
}

function renderChart(data) {
    var ctx = document.getElementById('line-chart').getContext('2d');
    if (myChart) {
        myChart.destroy();
    }

    var weeks = Object.keys(data).map(week => {
        var startDate = getStartDateOfWeek(selectedYear, week);
        var endDate = getEndDateOfWeek(selectedYear, week);
        return `${startDate} - ${endDate}`;
    });

    var sales = Object.values(data).map(value => parseFloat(value.toFixed(2)));

    myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: weeks,
            datasets: [{
                label: 'Weekly sales',
                data: sales,
                borderColor: '#0f3d71',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function getStartDateOfWeek(year, week) {
    var startDate = new Date(year, 0, 1 + (week - 1) * 7);
    var day = startDate.getDay();
    startDate.setDate(startDate.getDate() - day + (day === 0 ? -6 : 1));
    return startDate.toLocaleString('default', { month: 'short', day: '2-digit' });
}

function getEndDateOfWeek(year, week) {
    var startDate = getStartDateOfWeek(year, week);
    var endDate = new Date(startDate);
    endDate.setDate(endDate.getDate() + 6);
    return endDate.toLocaleString('default', { month: 'short', day: '2-digit' });
}

populateYearSelectOptions();
populateMonthSelectOptions();
updateChart();
// end weekly sales

// monthly sales
var selectedYearMonthly = new Date().getFullYear();
populateWeeklyYearSelectOptions();
document.getElementById('selectYearMonthlySales').value = selectedYearMonthly;

var myBarChart;

updateBarChart();

document.getElementById('selectYearMonthlySales').addEventListener('change', function () {
    selectedYearMonthly = parseInt(this.value);
    updateBarChart();
});

function populateWeeklyYearSelectOptions() {
    var currentYear = new Date().getFullYear();
    var selectYear = document.getElementById('selectYearMonthlySales');
    selectYear.innerHTML = ''; // Clear existing options
    for (var year = 2020; year <= currentYear; year++) {
        var optionYear = new Option(year, year);
        selectYear.appendChild(optionYear);
    }
}

function updateBarChart() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/staff-monthly-sales?year=' + selectedYearMonthly, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var monthlySalesData = JSON.parse(xhr.responseText);
            renderBarChart(monthlySalesData);
        }
    };

    xhr.send();
}

function renderBarChart(data) {
    var ctx = document.getElementById('bar-chart').getContext('2d');

    if (myBarChart) {
        myBarChart.destroy();
    }

    var monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    var sales = monthNames.map(function (monthName, index) {
        return data[index + 1] ? parseFloat(data[index + 1].toFixed(2)) : 0;
    });

    myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthNames,
            datasets: [{
                label: 'Monthly sales',
                data: sales,
                backgroundColor: '#0f3d71',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// end monthly sales

// yearly sales
var myYearlyChart;

function updateYearlyChart() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/staff-yearly-sales', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var yearlySalesData = JSON.parse(xhr.responseText);
            renderYearlyChart(yearlySalesData);
        }
    };

    xhr.send();
}

function renderYearlyChart(data) {
    var ctx = document.getElementById('yearly-chart').getContext('2d');

    if (myYearlyChart) {
        myYearlyChart.destroy();
    }

    var years = Object.keys(data);
    var yearlySales = Object.values(data).map(function (value) {
        return parseFloat(value.toFixed(2));
    });

    var currentYear = new Date().getFullYear();
    var labels = [];
    var startIndex = 2020;
    for (var year = startIndex; year <= currentYear; year++) {
        labels.push(year.toString());
    }

    myYearlyChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Yearly sales',
                data: yearlySales,
                backgroundColor: ['#0f3d71', 'gray', 'rgba(255, 206, 86, 0.7)', '#E91E63', '#9C27B0'],
                borderWidth: 1
            }]
        }
    });
}

function populateYearlySelectOptions() {
    var currentYear = new Date().getFullYear();
    var selectYear = document.getElementById('selectYearMonthlySales');
    selectYear.innerHTML = '';
    for (var year = 2020; year <= currentYear; year++) {
        var optionYear = new Option(year, year);
        selectYear.appendChild(optionYear);
    }
}

updateYearlyChart();
populateYearlySelectOptions();
// end year sales



// top 3 product
document.addEventListener('DOMContentLoaded', function () {
    fetch('/staff-top-products')
        .then(response => response.json())
        .then(data => {
            updatePieChart(data);
        })
        .catch(error => console.error('Error fetching top products data:', error));
});

function updatePieChart(data) {
    var ctx = document.getElementById('pie_chart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: data.map(product => product.product_name),
            datasets: [{
                data: data.map(product => product.total_sold),
                backgroundColor: [
                    '#0f3d71',
                    'gray',
                    'rgba(255, 206, 86, 0.7)',
                ],
            }],
        },
    });
}
// end top 3 product