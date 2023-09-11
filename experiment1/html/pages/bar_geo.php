<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Geometric Texture Bar Chart</title>

    <script type="text/javascript" src="../lib/jquery.min.js"></script>
    <script type="text/javascript" src="../lib/d3.v7.min.js"></script>

    <link rel="stylesheet" href="../lib/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="texture_style.css">

    <script src="../tools/loading.js"></script>

    <script type = "text/javascript" >
        //when you click the back button of the browser, this script prevent you from going bac
        function preventBack(){window.history.forward();}
        setTimeout("preventBack()", 0);
        window.onunload=function(){null};
    </script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col bg-light textContent">
    <?php
    include '../modules/design_task_description.php';
    ?>
            <p>
                There is no time limit for this task<span id="last_task"></span>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div id="toolbar"></div>
        </div>

    </div>

    <div class="row gx-3">
        <div class="col-auto legend_drag_div">
            <div id = "legend"></div>
            <div id="dragdrop" class="bg-light"></div>
        </div>
        <div class="col-auto">
            <div id="chartDiv" class="chartDiv"></div>
            <div id = "outlineDiv" style="padding-left: 200px;margin-top:-50px;"></div>
        </div>
        <div class="col-auto">
            <div id="controllerDiv"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div id="loadingDiv" class="spinner-border text-primary float-end" role="status" style="display: none;margin-left: 10px;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <button id="bar_geo_next_btn" class="btn btn-primary float-end">Next
            </button>

        </div>
    </div>
</div>

<script src="texture_functions.js"></script>
<script src="texture_constants.js"></script>

<script>
    let timestamp_bar_geo_start = Date.now() //the starting time for this design

    let chartName = 'barGeo'

    drawToolbar('toolbar')
    drawDragDropInfo('dragdrop')
    document.getElementById('toolbar').appendChild(drawSelectDefaultGeoTexture())
    drawChartDiv('chartDiv', svgWidth, svgHeight, 'chart')
    geoTextures(d3.select('#chartA'),fruits)
    drawGeoControllers()

</script>
<script src="texture_ui_elements.js"></script>
<script>
    //data
    let data = getDatasetForChart()

    drawGeoBarWithTexture(data, barWidth, barHeight, 'chart')
    drawBarIndicators(data, barWidth, barHeight, 'chart', 30)

    drawGeoLegend(fruits)

    //initialize
    geo_setInitialParameters(chartName)

    setSelectCat(chartName)
    //switch texture by drag and drop
    geo_switchTextures(chartName)


</script>
<script>
    let measurements = JSON.parse(localStorage.getItem('measurements'))
    let condition_texture = measurements['condition_texture']
    switch (condition_texture){
        case 0: //geo_icon
            document.getElementById('last_task').innerHTML=", but keep in mind that we will ask you to complete one other design after this one."
            break;
        case 1: //icon_geo
            document.getElementById('last_task').innerHTML=". This is the last design task."
            break;
    }
    document.getElementById('bar_geo_next_btn').onclick = function(){
        //write data to measurements
        // measurements['parameters_bar_geo'] = JSON.stringify(parameters)
        // measurements['timestamp_design_finished_bar_geo'] = Date.now()

        let timestamp_bar_geo_end = Date.now() //the end time for this design
        let bar_geo_design_time = timestamp_bar_geo_end - timestamp_bar_geo_start // time used for this design

        //send the svg of chart design to server
        //remove the indicators
        let indicatorsSVG = document.getElementById('indicator_group').outerHTML
        let fullSVG = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600" height="600">' + $("#chartA")[0].innerHTML + $("#chart")[0].innerHTML  + $("#chartWhiteStroke")[0].innerHTML + $("#chartBlackStroke")[0].innerHTML + '</svg>'
        let svgData = fullSVG.replace(indicatorsSVG, '')

        //send the svg and the parameters
        let obj = {}
        obj.svgData = svgData
        obj.filename = 'bar_geo_'+ measurements['participant_id'] + '_v' + measurements['trial_num']
        obj.parameters = parameters

        $.ajax({
            url: '../ajax/results_svg.php',
            type: 'POST',
            data: JSON.stringify(obj),
            contentType: 'application/json',
            dataType: "json",
            async: false, // Make the request synchronous
            success: function () {
                console.log('success')
            },
            error:function (e){
                console.log('Getting svg failed')
            }
        })

        $.ajax({
            url: '../ajax/results_texture_parameters.php',
            type: 'POST',
            data: JSON.stringify(obj),
            contentType: 'application/json',
            dataType: "json",
            async: false, // Make the request synchronous
            success: function () {
                console.log('success')
            },
            error:function (e){
                console.log('Getting json failed')
            }
        })

        // jump to next page
        switch (condition_texture){
            case 0: //geo_icon: this design (bar_geo) is the first design
                measurements['first_design_time'] = bar_geo_design_time

                //update measurements to localStorage
                localStorage.setItem('measurements', JSON.stringify(measurements))

                window.location.href = 'between_two_design.php';
                break;
            case 1: //icon_geo: this design (bar_geo )is the second design
                measurements['second_design_time'] = bar_geo_design_time

                //update measurements to localStorage
                localStorage.setItem('measurements', JSON.stringify(measurements))

                window.location.href = 'question_design_strategies.php';
                break;
        }
    }
</script>
</body>
</html>
