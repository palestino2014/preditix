// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Motor 0
var ctx = document.getElementById("myPieChart0");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Operando", "Offline", "Parada não planejada","Ativo parado"],
    datasets: [{
      data: [14, 5, 3,2],
      backgroundColor: ['#1cc88a', '#858796', '#f6c23e','#e74a3b'],
      hoverBackgroundColor: [],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false,
    },
    cutoutPercentage: 60,
  },
});

// Pie Chart Motor 1
var ctx = document.getElementById("myPieChart1");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Operando", "Offline", "Parada não planejada","Ativo parado"],
    datasets: [{
      data: [4, 1, 5,14],
      backgroundColor: ['#1cc88a', '#858796', '#f6c23e','#e74a3b'],
      hoverBackgroundColor: [],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 60,
  },
});

// Pie Chart Motor 1
var ctx = document.getElementById("myPieChart2");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Operando", "Offline", "Parada não planejada","Ativo parado"],
    datasets: [{
      data: [1, 18, 3,2],
      backgroundColor: ['#1cc88a', '#858796', '#f6c23e','#e74a3b'],
      hoverBackgroundColor: [],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 60,
  },
});

// Pie Chart Motor 1
var ctx = document.getElementById("myPieChart3");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Operando", "Parada planejada", "Parada não planejada","Ativo parado"],
    datasets: [{
      data: [2, 19, 2,1],
      backgroundColor: ['#1cc88a', '#36b9cc', '#f6c23e','#e74a3b'],
      hoverBackgroundColor: [],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 60,
  },
});
