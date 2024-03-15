// weekly sales
var myChart;
var selectedYear = new Date().getFullYear();
var selectedMonth = new Date().getMonth() + 1;
document.getElementById('selectYear').value = selectedYear;
document.getElementById('selectMonth').value = selectedMonth;

document.getElementById('selectYear').addEventListener('change', function () {
    selectedYear = parseInt(this.value);
    updateChart();
});

document.getElementById('selectMonth').addEventListener('change', function () {
    selectedMonth = parseInt(this.value);
    updateChart();
});

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

updateChart();

// end weekly

// monthly sales
var selectedYearMonthly = new Date().getFullYear();
document.getElementById('selectYearMonthlySales').value = selectedYearMonthly;

var myBarChart;

updateBarChart();

document.getElementById('selectYearMonthlySales').addEventListener('change', function () {
    selectedYearMonthly = parseInt(this.value);
    updateBarChart();
});

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

    // Create an array with sales data for each month
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

    myYearlyChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['2024', '2025', '2026'],
            datasets: [{
                label: 'Yearly sales',
                data: yearlySales,
                backgroundColor: ['#0f3d71', 'gray', 'rgba(255, 206, 86, 0.7)', '#E91E63', '#9C27B0'],
                borderWidth: 1
            }]
        }
    });
}

updateYearlyChart();
// end yearly sales


// pie-chart
document.addEventListener('DOMContentLoaded', function () {
    fetch('/top-products')
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
// end pie chart