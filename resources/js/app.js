require('./bootstrap');

// Material Dashboard
require('../../node_modules/material-dashboard/assets/js/core/bootstrap-material-design.min.js');
require('../../node_modules/material-dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js');
require('../../node_modules/material-dashboard/assets/js/material-dashboard.js');

// Color user in charts
chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
};

function generateNotificaiton(title,body){
    $(document).Toasts('create', {
        title: title,
        body: body,
        position: 'bottomRight',
        class: 'm-4'
    })
}