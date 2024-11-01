jQuery(function($) {

    $.getJSON(ajaxurl, { 'action': 'get_chart_data' }, function(response) {

        $('.invoicexpress-container').find('.loading').slideUp();

        var options = {
            responsive: true
        };

        var data = {
            labels: response.labels,
            datasets: [
                {
                    label: "Invoices",
                    fillColor: "rgba(0, 116, 162, 0.2)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(0, 116, 162, 1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: response.data
                }
            ]
        };

        var ctx = document.getElementById("invoicexpress-chart").getContext("2d");
        var myLineChart = new Chart(ctx).Line(data, options);

    });

});