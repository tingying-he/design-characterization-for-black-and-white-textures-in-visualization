<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Geometric Texture on Different Charts</title>

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
        <div class="col">
                <h2>Different Chart Type - Geometric texture</h2>
                <div class="alert alert-info already_answered_before" role="alert" style="display: none">
                    If you have answered this question before and your answer has not changed, please just click:
                    <button id="different_chart_geo_same_answer_btn" class="btn btn-outline-dark btn-sm">Same As Before</button>
                </div>

                <p>We applied the geometric texture you designed to <span id="another_charts"></span>. </p>
            </div>
    </div>
    <div class="row" style="height: 600px">
        <div class="col">
            <div id="charts">
                <div id="chart0Div" style="position:relative">
                </div>
                <div id="chart1Div" style="position:relative;left:600px">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>Do you think they still work in this context? Please explain.</p>
            <div class="mb-3">
                    <textarea class="form-control"
                              id="different_chart_geo_textarea"
                              rows="4" cols="80"
                              placeholder="Please write your answer here."
                    ></textarea>
            </div>
            <button id="different_chart_geo_next_btn" class="btn btn-primary float-end" disabled>Next</button>
        </div>
    </div>
</div>

<script src="texture_functions.js"></script>
<script src="texture_constants.js"></script>

<script>
    //when clicking "Same As Before" button, fill the textarea with 'same'
    document.getElementById('different_chart_geo_same_answer_btn').onclick = function (){
        //fill the textarea of questions on this page with "same"
        document.getElementById('different_chart_geo_textarea').value = 'same'

        //record the answer
        different_chart_geo_answer = 'same'

        //record the answer status
        different_chart_geo_answered = true

        //enable the next button
        document.getElementById('different_chart_geo_next_btn').disabled = false
    }
</script>
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

</script>

<script src="texture_ui_elements.js"></script>
<script>
    drawChartDiv('chart0Div', svgWidth, svgHeight, 'chart0')
    drawChartDiv('chart1Div', svgWidth, svgHeight, 'chart1')

    switch (condition_chart) {
        case 0: //bar, here we should compare geo_pie and geo_map
            document.getElementById('another_charts').innerHTML='a pie chart and a map'

            parametersList = JSON.parse(localStorage.getItem("barGeoparametersList") || "[]")
            parameters = parametersList[parametersList.length - 1]
            parameters['halo'] = 1

            para_geoTextures(d3.select('#chart0'),fruits, parameters, 'para')

            drawGeoPieWithTextureFromParameters(defaultDataset, 'chart0', pieRadius, parameters, 'para')
            drawGeoMapWithTextureFromParameters(defaultMapDataset, 'chart1', 'geo_d', parameters, 'para')

            break;
        case 1: //pie, here we should compare geo_bar and geo_map
            document.getElementById('another_charts').innerHTML='a bar chart and a map'

            parametersList = JSON.parse(localStorage.getItem("pieGeoparametersList") || "[]")
            parameters = parametersList[parametersList.length - 1]

            para_geoTextures(d3.select('#chart0'),fruits, parameters, 'para')

            drawGeoBarWithTextureFromParameters(defaultDataset, 'chart0', 400, 300, parameters, 'para')
            drawGeoMapWithTextureFromParameters(defaultMapDataset, 'chart1', 'geo_d', parameters, 'para')

            break;
        case 2: //map, here we should compare geo_bar and geo_map
            document.getElementById('another_charts').innerHTML='a bar chart and a pie chart'

            parametersList = JSON.parse(localStorage.getItem("mapGeoparametersList") || "[]")
            parameters = parametersList[parametersList.length - 1]

            para_geoTextures(d3.select('#chart0'),fruits, parameters, 'para')

            drawGeoBarWithTextureFromParameters(defaultDataset, 'chart0', barWidth, barHeight, parameters, 'para')
            drawGeoPieWithTextureFromParameters(defaultDataset, 'chart1', pieRadius, parameters, 'para')

            break;
        default:
            console.log(`has problem with condition_chart`);
    }



</script>

<script>
    let nextBtn = document.getElementById('different_chart_geo_next_btn')

    let different_chart_geo_answered = false
    let different_chart_geo_answer = 'no_input'

    document.getElementById('different_chart_geo_textarea').oninput = function (){
        if(this.value){
            different_chart_geo_answered = true
        }else{
            different_chart_geo_answered = false
        }

        different_chart_geo_answer = this.value

        if (different_chart_geo_answered){
            nextBtn.disabled = false
        }else{
            nextBtn.disabled = true
        }
    }

    document.getElementById('different_chart_geo_next_btn').onclick = function(){
        //write data to measurements
        measurements['different_chart_geo'] = '"'+different_chart_geo_answer+'"'

        //update measurements to localStorage
        localStorage.setItem('measurements', JSON.stringify(measurements))

        //jump to next page
        switch (condition_texture){
            case 0: //geo_icon
                window.location.href = 'question_different_chart_icon_texture.php';
                break;
            case 1: //icon_geo
                measurements["timestamp_end"] = Date.now()

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

                measurements["formatted_data_end"] = formattedDate



                //update measurements to localStorage
                localStorage.setItem('measurements', JSON.stringify(measurements))

                //send json results to server
                $.ajax({
                    url: '../ajax/results_json.php', //path to the script who handles this
                    type: 'POST',
                    data: JSON.stringify(measurements),
                    contentType: 'application/json',
                    dataType: "json",
                    async: false, // Make the request synchronous
                    success: function (data) {
                        console.log('success')
                    }
                })

                //send csv results to server
                $.ajax({
                    url: '../ajax/results_csv.php', //path to the script who handles this
                    type: 'POST',
                    data: JSON.stringify(measurements),
                    contentType: 'application/json',
                    async: false, // Make the request synchronous
                    success: function (data) {
                        console.log('success')
                    }
                })
                window.location.href = 'end.php';
                break;
        }
    }
</script>

</body>
</html>

