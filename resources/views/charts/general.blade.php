<script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {
        var chart_data = <?php echo $chartData; ?>;
        console.log(chart_data);

        google.charts.load('current', {
            'packages': ['corechart']
        });

        google.charts.setOnLoadCallback(lineChart);

        function lineChart() {

            // Create the data table.
            var data = google.visualization.arrayToDataTable(chart_data);

            // Set chart options
            var options = {
                title: '<?php echo $dataType->getTranslatedAttribute('display_name_plural') ?>',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                },
                height:300
            };
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);

        }
    }
</script>

<!--Div that will hold the pie chart-->
<div id="chart_div"></div>
