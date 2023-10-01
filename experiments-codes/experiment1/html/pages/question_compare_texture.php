<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Compare Texture</title>

    <script type="text/javascript" src="../lib/jquery.min.js"></script>
    <script type="text/javascript" src="../lib/d3.v7.min.js"></script>

    <link rel="stylesheet" href="../lib/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="texture_style.css">

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
        <div class="col">
            <h2>Compare <span class="two_texture_types"></span></h2>
            <div class="alert alert-info already_answered_before" role="alert" style="display:none">
                If you have answered this question before and your answer has not changed, please just click:
                <button id="compare_same_answer_btn" class="btn btn-outline-dark btn-sm">Same As Before</button>
            </div>
            <div>
                <p>Here are your designs with both the <span class="two_texture_types"></span>.</p>
            </div>
        </div>
    </div>
    <div class="row" style="height: 600px">
        <div class="col">
            <div id="charts" style="width: 100%;height: 600px">
                <div id="chart0Div" style="position:relative"></div>
                <div id="chart1Div" style="position:relative;left:600px"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="compare_texture_textarea"
                       class="form-label"
                >
                    What’s your general impression, experience, or take-away about using geometric and iconic textures for data representation?
                </label>
                <textarea class="form-control"
                          id="compare_texture_textarea"
                          rows="4"
                          cols="80"
                          placeholder="Please write your answer here."
                ></textarea>
            </div>
            <button id="compare_texture_next_btn" class="btn btn-primary float-end" disabled>Next</button>
        </div>
    </div>
</div>

<script>

    //when clicking "Same As Before" button, fill the textarea with 'same'
    document.getElementById('compare_same_answer_btn').onclick = function (){
        //fill the textarea of questions on this page with "same"
        document.getElementById('compare_texture_textarea').value = 'same'

        //record the answer
        compare_texture_answer = 'same'

        //record the answer status
        compare_texture_answered = true

        //enable the next button
        document.getElementById('compare_texture_next_btn').disabled = false
    }
</script>

<script src="texture_functions.js"></script>
<script src="texture_constants.js"></script>
<script>


    let measurements = JSON.parse(localStorage.getItem('measurements'))



    //show the <div> to tell participant they can just answer "same" if they have already done a trial before
    if(measurements['trial_num'] > 0){
        document.querySelectorAll('.already_answered_before').forEach(function(el) {
            el.style.display = 'block';
        })
    }

    let condition_texture = measurements['condition_texture']
    let condition_chart = measurements['condition_chart']


    let geo_chart = -1
    let icon_chart = -1
    switch (condition_texture) {
        case 0: //geo-icon
            for(let i = 0; i < document.getElementsByClassName('two_texture_types').length; i++){
                document.getElementsByClassName('two_texture_types')[i].innerHTML='geometric texture and iconic texture'
            }
            geo_chart = 'chart0'
            icon_chart = 'chart1'
            break;
        case 1: //icon-geo
            for(let i = 0; i < document.getElementsByClassName('two_texture_types').length; i++){
                document.getElementsByClassName('two_texture_types')[i].innerHTML='iconic texture and geometric texture'
            }
            geo_chart = 'chart1'
            icon_chart = 'chart0'
            break;
        default:
            console.log(`has problem with condition_texture`);
    }


</script>
<script src="texture_ui_elements.js"></script>
<script>
    drawChartDiv('chart0Div', svgWidth, svgHeight, 'chart0')
    drawChartDiv('chart1Div', svgWidth, svgHeight, 'chart1')

    switch (condition_chart) {
        case 0: //bar
            geo_parametersList = JSON.parse(localStorage.getItem("barGeoparametersList") || "[]")
            geo_parameters = geo_parametersList[geo_parametersList.length - 1]

            icon_parametersList = JSON.parse(localStorage.getItem("barIconparametersList") || "[]")
            icon_parameters = icon_parametersList[icon_parametersList.length - 1]

            para_geoTextures(d3.select('#chart0'),fruits, geo_parameters, 'para')
            para_iconTextures(d3.select('#chart0'), fruits, icon_parameters, 'para')

            drawGeoBarWithTextureFromParameters(defaultDataset, geo_chart, barWidth, barHeight, geo_parameters, 'para')
            drawIconBarWithTextureFromParameters(defaultDataset, icon_chart, barWidth, barHeight, icon_parameters, 'para')

            break;
        case 1: //pie
            geo_parametersList = JSON.parse(localStorage.getItem("pieGeoparametersList") || "[]")
            geo_parameters = geo_parametersList[geo_parametersList.length - 1]

            icon_parametersList = JSON.parse(localStorage.getItem("pieIconparametersList") || "[]")
            icon_parameters = icon_parametersList[icon_parametersList.length - 1]

            para_geoTextures(d3.select('#chart0'),fruits, geo_parameters, 'para')
            para_iconTextures(d3.select('#chart0'), fruits, icon_parameters, 'para')

            drawGeoPieWithTextureFromParameters(defaultDataset, geo_chart, pieRadius, geo_parameters, 'para')
            drawIconPieWithTextureFromParameters(defaultDataset, icon_chart, pieRadius, icon_parameters, 'para')

            break;
        case 2: //map

            geo_parametersList = JSON.parse(localStorage.getItem("mapGeoparametersList") || "[]")
            geo_parameters = geo_parametersList[geo_parametersList.length - 1]

            icon_parametersList = JSON.parse(localStorage.getItem("mapIconparametersList") || "[]")
            icon_parameters = icon_parametersList[icon_parametersList.length - 1]

            para_geoTextures(d3.select('#chart0'),fruits, geo_parameters, 'para')
            para_iconTextures(d3.select('#chart0'), fruits, icon_parameters, 'para')

            drawGeoMapWithTextureFromParameters(defaultMapDataset, geo_chart, 'geo_d', geo_parameters, 'para')
            drawIconMapWithTextureFromParameters(defaultMapDataset, icon_chart, 'icon_d', icon_parameters, 'para')

            break;
        default:
            console.log(`has problem with condition_chart`);
    }



</script>

<script>
    let nextBtn = document.getElementById('compare_texture_next_btn')

    let compare_texture_answered = false
    let compare_texture_answer = 'no_input'

    document.getElementById('compare_texture_textarea').oninput = function (){
        if(this.value){
            compare_texture_answered = true
        }else{
            compare_texture_answered = false
        }

        compare_texture_answer = this.value

        if (compare_texture_answered){
            nextBtn.disabled = false
        }else{
            nextBtn.disabled = true
        }

    }

    document.getElementById('compare_texture_next_btn').onclick = function(){
        //write data to measurements
        measurements['compare_texture'] = '"'+ compare_texture_answer + '"'

        //update measurements to localStorage
        localStorage.setItem('measurements', JSON.stringify(measurements))

        //jump to next page
        switch (condition_texture){
            case 0: //geo_icon
                window.location.href = 'question_different_chart_geo_texture.php';
                break;
            case 1: //icon_geo
                window.location.href = 'question_different_chart_icon_texture.php';
                break;
        }
    }
</script>

</body>
</html>
