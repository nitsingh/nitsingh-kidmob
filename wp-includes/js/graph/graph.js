$(document).ready(function() {

    /**
     * This code creates the Word cloud
     */
    var TagCanvas = $('#myCanvas').tagcanvas({
        textColour: '#000',
        outlineColour: '#ff00ff',
        reverse: true,
        textHeight: 17,
        depth: 0.8,
        maxSpeed: 0.05,
        initial: [0,0.1],
        noMouse: true
    },'tags');

    if(!TagCanvas) {
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
            text: ''
        },
//        subtitle: {
//            text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
//        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -90,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'No. of participants'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Total participants: <b>{point.y} </b>'
        },
        series: [{
            name: 'Population',
            data: [
                ["Critical thinking Critical Observation", 26],
                ["Creative problem solving", 20],
                ["Communications", 10],
                ["Adaptability", 35],
                ["New skills", 5],
                ["Confidence", 4]
            ],
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