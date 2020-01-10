$(document).ready(function() {
    initBarChart();
});
function initBarChart(){
	var options = {
        chart: {
            renderTo: 'container-bar',
            type: 'line',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Count of transaction per month',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'Total'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            formatter: function() {
                    return '<b>'+ this.series.name +'</b> '+
                    this.x +': '+ this.y;
            }
        },
        

        series: [],
        credits: {
        	enabled : false
        }
    }

    $.getJSON(base_url+"admin/admin/data_line_chart", function(json) {
    options.xAxis.categories = json[0]['data'];
        options.series[0] = json[1];
        chart = new Highcharts.Chart(options);
    });
}
