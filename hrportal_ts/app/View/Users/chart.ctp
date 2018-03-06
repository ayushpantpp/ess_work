<script type="text/javascript" src="jquery.min.js" ></script>
                
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- page content -->

<div id="container1" class="col-md-4"></div>
                    <div id="container0" class="col-md-4"></div>
                    <div id="container2" class="col-md-4"></div>

<script type="text/javascript">
    $(function () {
        $.noConflict();
        //$('[data-toggle="tooltip"]').tooltip();
        $.get('/newportal/tasks/chartdata', function (data) {
            var jsonArr = JSON.parse(data);
            //setPieChart(4,'Resource',jsonArr);

        });
        setMeterChart(0, 'Completed', [1]);
        setMeterChart(1, 'Pending', [2]);
        setMeterChart(2, 'Not Started', [39]);

        function setMeterChart(id, titleText, chartData) {
           
            $('#container' + id).highcharts({
                chart: {
                    type: 'gauge',
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },
                title: {
                    text: titleText + ' Tasks'
                },
                exporting:
                        {enabled: false},
                credits: {
                    enabled: false
                }, pane: {
                    startAngle: -120,
                    endAngle: 120,
                    background: [{
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                stops: [
                                    [0, '#FFF'],
                                    [1, '#333']
                                ]
                            },
                            borderWidth: 0,
                            outerRadius: '109%'
                        }, {
                            backgroundColor: {
                                linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                stops: [
                                    [0, '#333'],
                                    [1, '#FFF']
                                ]
                            },
                            borderWidth: 1,
                            outerRadius: '107%'
                        }, {
                            // default background
                        }, {
                            backgroundColor: '#DDD',
                            borderWidth: 0,
                            outerRadius: '105%',
                            innerRadius: '103%'
                        }]
                },
                // the value axis
                yAxis: {
                    min: 0,
                    max: 20,
                    minorTickInterval: 'auto',
                    minorTickWidth: 1,
                    minorTickLength: 10,
                    minorTickPosition: 'inside',
                    minorTickColor: '#666',
                    tickPixelInterval: 30,
                    tickWidth: 2,
                    tickPosition: 'inside',
                    tickLength: 10,
                    tickColor: '#666',
                    labels: {
                        step: 2,
                        rotation: 'auto'
                    },
                    title: {
                        text: 'Task'
                    },
                    plotBands: [{
                            from: 0,
                            to: 5,
                            color: '#55BF3B' // green
                        }, {
                            from: 5,
                            to: 10,
                            color: '#DDDF0D' // yellow
                        }, {
                            from: 10,
                            to: 20,
                            color: '#DF5353' // red
                        }]
                },
                series: [{
                        name: titleText + ' :',
                        data: chartData,
                        tooltip: {
                            valueSuffix: 'Tasks'
                        }
                    }]

            },
            // Add some life
            function (chart) {
                /*if (!chart.renderer.forExport) {
                 setInterval(function () {
                 var point = chart.series[0].points[0],
                 newVal,
                 inc = Math.round((Math.random() - 0.5) * 2);
                     
                 newVal = point.y + inc;
                 if (newVal < 0 || newVal > 20) {
                 newVal = point.y - inc;
                 }
                     
                 point.update(newVal);
                     
                 }, 300);
                 }*/
            });
        }
        function setPieChart(id, title, chartData) {
            $.noConflict();
            $('#container3').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: title + ' Allocation'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                        name: 'Brands',
                        colorByPoint: true,
                        data: chartData
                    }]
            });
        }
    });

    


</script>