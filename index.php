<!DOCTYPE html>
<html>
    <head>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" type="text/css" href="./style/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>  
        <script src="moment.js"></script>
    </head>
    <body>
        <div class="content">
            <div>
                <div class="nav-bar">
                    <nav>
                        <a class="nav-bar content" href="#">DEMO IOT - LAB 6</a>
                    </nav>
                </div>
            </div>
            <div class="content-behind-navbar">
                <div class="content-nav-left">
                    <div class="cover-nav-left">
                        <div class="unit-nav-left">
                            <i class="fa fa-home"></i>
                            <a class="row-nav-left" href="#overview">HOME</a>
                        </div>
                        <div class="unit-nav-left">
                            <i class="fas fa-chart-area"></i>
                            <a class="row-nav-left" href="#">REAL-TIME LINE CHART</a>
                        </div>
                        <div class="unit-nav-left sub">
                            <a class="row-nav-left" href="#">LIGHT</a>
                        </div>
                        <div class="unit-nav-left sub">
                            <a class="row-nav-left" href="#">HUMIDITY</a>
                        </div>
                        <div class="unit-nav-left sub">
                            <a class="row-nav-left" href="#">TEMPERATURE</a>
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <h1 style="padding-left: 50px;">OVERVIEW</h1>
                    <table id="overview" class="overview">
                        <tr>
                            <td>
                                <div id="circleLight" class="baseCircle center">
                                    <div id="txtLight" class="value">1</div>
                                </div>
                            </td>
                            <td>
                                <div id="circleHumidity" class="baseCircle center">
                                    <div id="txtHumidity" class="value">1</div>
                                </div>
                            </td>
                            <td>
                                <div id="circleTemperature" class="baseCircle center">
                                    <div id="txtTemperature" class="value">1</div>
                                </div>
                            </td>
                        </tr>
                        <tr style="font-weight: bold";>
                            <td style="padding-left: 81px;">Light</td>
                            <td style="padding-left: 70px;">Humidity</td>
                            <td style="padding-left: 52px;">Temperature</td>
                        </tr>
                    </table>
                    <div class="chart">
                        <div id="chart_light" style="height: 370px; width:50%;"></div>
                    </div>
                    <div class="chart">
                        <div id="chart_humidity" style="height: 370px; width:50%;"></div>
                    </div>
                    <div class="chart">
                        <div id="chart_temperature" style="height: 370px; width:50%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                setInterval(() => {
                    loadData();
                }, 2000);
            });

            function loadData(){
                $.get("http://localhost:8080/lab6/getLastestData.php", 
                    function(data){
                        var rows = jQuery.parseJSON(data);
                        $.each(rows, function(index, row){
                            var light = row.l;
                            var humidity = row.h;
                            var temperature = row.t;

                            updateView('circleLight', 'txtLight', 150, 180, light);
                            updateView('circleHumidity', 'txtHumidity', 50, 70, humidity);
                            updateView('circleTemperature', 'txtTemperature', 20, 40, temperature);
                        }); 
                }).fail(function(){
                    alert("Oop! An error was found when getting data from server");
                });

                $.get("http://localhost:8080/lab6/get_giatri.php",
                    function(data){
                        var rows = jQuery.parseJSON(data);
                        var dpLight=[], dpHumidity=[], dpTemperature=[];
                        $.each(rows, function(index, row){
                            dpLight.push({x:row.date*1000, y:parseInt(row.l)});
                            dpHumidity.push({x:row.date*1000, y:parseInt(row.h)});
                            dpTemperature.push({x:row.date*1000, y:parseInt(row.t)});
                        });
                        console.log(dpLight);
                        window.onload = updateChart("chart_light", "FROM SENSOR LIGHT", "Lux", dpLight);
                        window.onload = updateChart("chart_humidity", "FROM SENSOR HUMIDITY","%", dpHumidity);
                        window.onload = updateChart("chart_temperature", "FROM SENSOR TEMPERATURE","C", dpHumidity);
                }).fail(function(){
                    alert("Oop! An error was found when getting data from server");
                });
                
            };

            function updateView(circle, txt, mediumValue, highValue, value) {
                $('#'+txt).text(value);
                if (value < mediumValue){
                    $('#'+circle).css('background-color', 'blue');
                }
                else if(value >= mediumValue && value <= highValue){
                    $('#'+circle).css('background-color', 'green');
                }
                else{
                    $('#'+circle).css('background-color', 'red');
                }
    
            };
            //chart 
            function updateChart(id, text, textY, dp) {

                var chart = new CanvasJS.Chart(id, {
                    animationEnabled: true,
                    title: {
                        text: text
                    },
                    axisX: {
                        title: "Time"
                    },
                    axisY: {
                        title: textY

                    },
                    data: [{
                        type: "line",
                        name: "CPU Utilization",
                        connectNullData: true,
                        //nullDataLineDashType: "solid",
                        xValueType: "dateTime",
                        xValueFormatString: "DD MMM hh:mm TT",
                        yValueFormatString: "#,##0.##\"%\"",
                        dataPoints: dp
                    }]
                });
                chart.render();
            };
        </script>
    </body>
</html> 