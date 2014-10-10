<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://www.goat1000.com/jquery.tagcanvas.min.js" type="text/javascript"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/drilldown.js"></script>


<script type="text/javascript" src="http://d3js.org/d3.v2.js"></script>
<script type="text/javascript" src="http://treesheets.org/release/cts-0.5.js"></script>
<script type="text/cts" src="http://people.csail.mit.edu/eob/cts/widgets/bubblechart.cts"></script>
<script>
    var hostname = location.hostname;
    var parts = hostname.split('.');
    var domainName = parts[parts.length - 2];
    var domain = parts[parts.length - 1];
    if(domainName === 'kidmob' && domain === 'org') {
        document.domain = "kidmob.org";
    }

    if(window.parent.frameResizer) {

        var $scripts = $(window.parent.document).find('link');
        var cssScripts = [];
        $scripts.each(function() {
            if($(this).attr('type') === 'text/css') {
                cssScripts.push($(this).attr('href'));
            }
        });

        $.each(cssScripts, function(index, value) {
            //document.write('<link rel="stylesheet" type="text/css" src="http:' + value + '">');

            url = 'http:' + value;
            if (document.createStyleSheet)
            {
                document.createStyleSheet(url);
            }
            else
            {
                $('<link rel="stylesheet" type="text/css" href="' + url + '" />').appendTo('head');
            }
        });
    }
</script>