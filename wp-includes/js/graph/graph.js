$(document).ready(function() {

    /**
     * This code creates the Word cloud
     */
    if(!$('#myCanvas').tagcanvas({
        textColour: '#ff0000',
        outlineColour: '#ff00ff',
        reverse: true,
        depth: 0.8,
        maxSpeed: 0.05
    },'tags')) {
        // something went wrong, hide the canvas container
        $('#myCanvasContainer').hide();
    }


    /**
     * This code creates the Bar chart
     */
    var $series = $('#containerBarChart').data('graph');
    $('#containerBarChart').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'World\'s largest cities per 2014'
        },
        subtitle: {
            text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Population (millions)'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Population in 2008: <b>{point.y:.1f} millions</b>'
        },
        series: [{
            name: 'Population',
            data: $series,
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                x: 4,
                y: 10,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif',
                    textShadow: '0 0 3px black'
                }
            }
        }]
    });
});