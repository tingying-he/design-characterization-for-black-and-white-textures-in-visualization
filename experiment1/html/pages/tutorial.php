<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tutorial</title>

    <script type="text/javascript" src="../lib/jquery.min.js"></script>
    <script type="text/javascript" src="../lib/d3.v7.min.js"></script>
    <script type="text/javascript" src="../lib/bootstrap-tour-standalone.min.js"></script>
    <script src="../tools/loading.js"></script>

    <link rel="stylesheet" href="../lib/bootstrap.css">
    <link rel="stylesheet" href="../lib/bootstrap-tour-standalone.min.css">

    <link rel="stylesheet" type="text/css" href="texture_style.css">

    <script type = "text/javascript" >
        //when you click the back button of the browser, this script prevent you from going bac
        function preventBack(){window.history.forward();}
        setTimeout("preventBack()", 0);
        window.onunload=function(){null};
    </script>
    <style>
        .btn-outline-secondary{
            border-color: #6c757d;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row bg-light">
        <div class="col">
            <h2>Get Familiar with the Texture Design Tool</h2>
            <div id='tutorial_finished' style="display: none" class="textContent">
                <p>Now you can play with the tool and try each function out. </p>
                <p>Once you are familiar with the tool, click the <span style="color:#1E90FF;font-weight: bold">Start Real Experiment</span> button at the bottom right of the page to start the real experiment.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div id="toolbar"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-auto legend_drag_div">
            <div id="legend"></div>
            <div id="dragdrop" class="bg-light"></div>
        </div>
        <div class="col-auto">
            <div id="chartDiv" class="chartDiv"></div>
            <div id="outlineDiv" style="padding-left: 200px"></div>
        </div>
        <div class="col-auto">
            <div id="controllerDiv">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button id="tutorial_next_btn" class="btn btn-primary float-end">Start Real Experiment</button>
        </div>
    </div>
</div>


<script src="texture_functions.js"></script>
<script src="texture_constants.js"></script>


<script>
    let measurements = JSON.parse(localStorage.getItem('measurements'))
    let condition_chart = measurements['condition_chart']
    let condition_texture = measurements['condition_texture']
    console.log('condition_chart:' + condition_chart)
    console.log('condition_texture:' + condition_texture)

    let chartName
    let data
    switch (condition_chart) {
        case 0:
            switch (condition_texture){
                case 0:
                    //draw bar geo texture tool
                    chartName = 'barGeo'

                    drawToolbar('toolbar')
                    drawDragDropInfo('dragdrop')
                    document.getElementById('toolbar').appendChild(drawSelectDefaultGeoTexture())
                    drawChartDiv('chartDiv', svgWidth, svgHeight, 'chart')
                    geoTextures(d3.select('#chartA'),fruits)
                    drawGeoControllers()

                    break;
                case 1:
                    //draw bar icon texture tool
                    chartName = 'barIcon'

                    drawToolbar('toolbar')
                    drawDragDropInfo('dragdrop')
                    drawIconLegend('legend',fruits)
                    drawChartDiv('chartDiv', svgWidth, svgHeight, 'chart')
                    iconTextures(d3.select('#chartA'),fruits)
                    drawIconicControllers()

                    break;
            }
            break;
        case 1:
            switch (condition_texture){
                case 0:
                    //draw pie geo texture tool
                    chartName = "pieGeo"

                    drawToolbar('toolbar')
                    drawDragDropInfo('dragdrop')
                    document.getElementById('toolbar').appendChild(drawSelectDefaultGeoTexture())
                    drawChartDiv('chartDiv', svgWidth, svgHeight, 'chart')
                    geoTextures(d3.select('#chartA'),fruits)
                    drawGeoControllers()

                    break;
                case 1:
                    //draw pie icon texture tool
                    chartName = 'pieIcon'

                    drawToolbar('toolbar')
                    drawDragDropInfo('dragdrop')
                    drawIconLegend('legend',fruits)
                    drawChartDiv('chartDiv', svgWidth, svgHeight, 'chart')
                    iconTextures(d3.select('#chartA'),fruits)
                    drawIconicControllers()

                    break;
            }
            break;
        case 2:
            switch (condition_texture){
                case 0:
                    //draw map geo texture tool
                    chartName = "mapGeo"

                    drawToolbar('toolbar')
                    drawDragDropInfo('dragdrop')
                    document.getElementById('toolbar').appendChild(drawSelectDefaultGeoTexture())
                    drawChartDiv('chartDiv', svgWidth, svgHeight, 'chart')
                    geoTextures(d3.select('#chartA'),fruits)
                    drawGeoControllers()


                    break;
                case 1:
                    //draw map icon texture tool
                    chartName = "mapIcon"

                    drawToolbar('toolbar')
                    drawDragDropInfo('dragdrop')
                    drawIconLegend('legend',fruits)
                    drawChartDiv('chartDiv', svgWidth, svgHeight, 'chart')
                    iconTextures(d3.select('#chartA'),fruits)
                    drawIconicControllers()

                    break;
            }
            break;
        default:
            console.log(`has problem with condition_chart`);
    }


</script>
<script src="texture_ui_elements.js"></script>
<script>
    switch (condition_chart) {
        case 0:
            switch (condition_texture){
                case 0:
                    data = getDatasetForChart()

                    drawGeoBarWithTexture(data, barWidth, barHeight, 'chart')
                    drawBarIndicators(data, barWidth, barHeight, 'chart', 30)

                    drawGeoLegend(fruits)

                    //initialize
                    geo_setInitialParameters(chartName)

                    setSelectCat(chartName)
                    //switch texture by drag and drop
                    geo_switchTextures(chartName)

                    break;
                case 1:
                    //data
                    data = getDatasetForChart()

                    drawIconBarWithTexture(data, barWidth,barHeight, 'chart')
                    drawBarIndicators(data, barWidth, barHeight, 'chart', 30)

                    //initialize
                    icon_setInitialParameters(chartName)

                    setSelectCat(chartName)

                    icon_switchTextures(chartName)
                    break;
            }
            break;
        case 1:
            switch (condition_texture){
                case 0:
                    data = getDatasetForChart()

                    drawGeoPieWithTexture(data, pieRadius, 'chart')
                    drawPieIndicators(data, pieRadius, 'chart', 30)
                    drawGeoLegend(fruits)
                    //initialize
                    geo_setInitialParameters(chartName)

                    setSelectCat(chartName)
                    //switch texture by drag and drop
                    geo_switchTextures(chartName)
                    break;
                case 1:
                    data = getDatasetForChart()

                    drawIconPieWithTexture(data, pieRadius, 'chart')
                    drawPieIndicators(data, pieRadius, 'chart', 30)

                    //initialize
                    icon_setInitialParameters(chartName)

                    setSelectCat(chartName)
                    //switch texture by drag and drop
                    icon_switchTextures(chartName)
                    break;
            }
            break;
        case 2:
            switch (condition_texture){
                case 0:
                    data = getDatasetForMap()

                    drawGeoMapWithTexture(data, mapWidth, mapHeight, 'chart')
                    drawGeoLegend(fruits)
                    break;
                case 1:
                    data = getDatasetForMap()
                    drawIconMapWithTexture(data, mapWidth, mapHeight, 'chart')
                    break;
            }
            break;
        default:
            console.log(`has problem with condition_chart`);
    }


    if(localStorage.getItem('only_halo_tutorial') == -1){ //this participant already go through all tutorial (with/without halo version), so start training session directly.
        document.getElementById('tutorial_finished').style.display = 'block'
        document.getElementById('tutorial_next_btn').disabled = false
    }

    let tour = new Tour({
        onEnd: function (){
            document.getElementById('tutorial_finished').style.display = 'block'
            document.getElementById('tutorial_next_btn').disabled = false
        }
    });


    if(localStorage.getItem('only_halo_tutorial') == 1){ //if the participant already designed a bar chart, and this time they will design a pie or map, then we should notify them the halo controller
        //bootstrap-tour uses localStorage to store the progress. Remove the relevant variables to let the tour start again.
        if(localStorage.getItem('tour_current_step')){
            localStorage.removeItem('tour_current_step')
        }
        if(localStorage.getItem('tour_end')){
            localStorage.removeItem('tour_end')
        }

        tour.addStep({
            element: "#controlHalo",
            title: "Change the white halo width",
            content: "We see you have already did our study before, but this time there will be a halo controller. You can change the white halo width by using this controller. Try it out right now."
        })
        localStorage.setItem('only_halo_tutorial', '-1') //this halo tutorial will never show again.
    }

    if(localStorage.getItem('only_halo_tutorial') == 0){
        //if the texture order is geo-icon, we will see a tutorial for geo chart, and need the import default texture function.
        if(condition_texture == 0){
            tour.addStep({
                element: "#selectDefaultTexture", // string (jQuery selector) - html element next to which the step popover should be shown
                title: "Import default texture", // string - title of the popover
                content: "You can select and import a default texture in the drop-down box. This function is available only for geometric textures, the default textures are inspired by historic examples. Try it out right now." // string - content of the popover
            })
        }

        if(condition_chart == 2){ //for map, we say "texture in the map"
            tour.addStep({
                element: "#chart",
                title: "Select texture to edit(1)",
                content: "You can select each texture in the map to make edits by clicking on the texture on the chart. Try it out right now."
            })
        }else{ //for bar chart and pie chart, we say "texture in the chart"
            tour.addStep({
                element: "#chart",
                title: "Select texture to edit(1)",
                content: "You can select each texture in the chart to make edits by clicking on the texture on the chart. Try it out right now."
            })
        }
        tour.addSteps([{
            element: "#legend",
            title: "Select texture to edit(2)",
            content: "You can also select a texture to edit by clicking on the legend. Try it out right now."
        },  {
            element: "#controllerDiv",
            title: "Edit texture",
            content: "You can edit the parameters of the selected texture by using these controllers. Try it out right now."
        }, {
            element: "#chart",
            title: "Drag and drop to switch texture",
            content: "You can drag-and-drop from one texture to another on the chart or on the legend to switch the parameters of respective two textures. Try it out right now."
        },{
            element: "#controllerDiv",
            title: "Edit all texture texture at the same time",
            content: "If you check the checkbox after each parameter controller, you can change this parameter for all textures at the same time. Try it out right now."
        }, {
            element: "#controlOutline",
            title: "Change the outline stroke width",
            content: "You can change the outline stroke width by using this controller. Try it out right now."
        },
        ]);

        //if the chart type is not bar chart, we need the Halo controller
        if(condition_chart != 0){
            tour.addStep({
                element: "#controlHalo",
                title: "Change the white halo width",
                content: "You can change the white halo width by using this controller. Try it out right now."
            })
        }

        tour.addSteps([
            {
                element: "#dataBtn",
                title: "Change data set",
                content: "You can change to a different, randomly selected data set to test your design. Try it out right now."
            },{
                element: "#defaultDataBtn",
                title: "Default data set",
                content: "You can test your design with the default data set. Try it out right now."
            }, {
                element: "#undoBtn",
                title: "Undo",
                content: "You can undo your operation on texture attributes. Try it out right now."
            }, {
                element: "#redoBtn",
                title: "Redo",
                content: "You can redo your operation on texture attributes. Try it out right now."
            }, {
                element: "#resetBtn",
                title: "Reset",
                content: "You can also reset all texture attributes to the default that we started with, if needed. Try it out right now."
            }
        ])
    }



    // Initialize the tour
    tour.init();

    // Start the tour
    tour.start();

    document.getElementById('tutorial_next_btn').onclick = function(){
        //send demographics data to server
        let data_demographics = {
            'participant_id':measurements['participant_id'],
            'trial_num':measurements['trial_num'],
            'condition_chart':measurements['condition_chart'],
            'condition_texture':measurements['condition_texture'],
            'gender':measurements['gender'],
            'age':measurements['age'],
            'experience':measurements['experience']
        }

        $.ajax({
            url: '../ajax/results_demographics_csv.php', //path to the script who handles this
            type: 'POST',
            data: JSON.stringify(data_demographics),
            contentType: 'application/json',
            async: false, // Make the request synchronous
            success: function (data) {
                console.log('success')
            }
        })

        //timestamp of tutorial end
        measurements["timestamp_tutorial"] = Date.now()

        let date = new Date();
        let y = date.getFullYear();
        let m = date.getMonth() + 1;
        let d = date.getDate();
        let h = date.getHours();
        let min = date.getMinutes();
        let s = date.getSeconds();

        // add leading zeros if necessary
        if (m < 10) m = '0' + m;
        if (d < 10) d = '0' + d;
        if (h < 10) h = '0' + h;
        if (min < 10) min = '0' + min;
        if (s < 10) s = '0' + s;

        let yymmdd = y + '' + m + '' + d;
        let hhmmss = h + ':' + min + ':' + s;

        let formattedDate = yymmdd + ' ' + hhmmss;

        measurements["formatted_data_tutorial"] = formattedDate

        localStorage.setItem('measurements', JSON.stringify(measurements))

        //clear the previous design data and jump to first design page
        switch (condition_chart) {
            case 0:
                switch (condition_texture){
                    case 0:
                        // localStorage.removeItem('barGeoparametersList')
                        window.location.href = 'bar_geo.php';
                        break;
                    case 1:
                        // localStorage.removeItem('barIconparametersList')
                        window.location.href = 'bar_icon.php';
                        break;
                }
                break;
            case 1:
                switch (condition_texture){
                    case 0:
                        // localStorage.removeItem('pieGeoparametersList')
                        window.location.href = 'pie_geo.php';
                        break;
                    case 1:
                        // localStorage.removeItem('pieIconparametersList')
                        window.location.href = 'pie_icon.php';
                        break;
                }
                break;
            case 2:
                switch (condition_texture){
                    case 0:
                        // localStorage.removeItem('mapGeoparametersList')
                        window.location.href = 'map_geo.php';
                        break;
                    case 1:
                        // localStorage.removeItem('mapIconparametersList')
                        window.location.href = 'map_icon.php';
                        break;
                }
                break;
            default:
                console.log(`has problem with condition_chart`);
        }
    }


</script>

</body>
</html>





<!--bootstrap tour-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/js/bootstrap-tour-standalone.min.js"></script>-->
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/css/bootstrap-tour-standalone.min.css" rel="stylesheet"/>-->



