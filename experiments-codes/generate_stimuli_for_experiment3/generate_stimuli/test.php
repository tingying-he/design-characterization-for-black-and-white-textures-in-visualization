<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="../html/lib/jquery.min.js"></script>
    <script type="text/javascript" src="../html/lib/d3.v7.min.js"></script>
    <script src="../html/pages/texture_functions.js"></script>
    <script src="../html/pages/texture_constants.js"></script>
    <script src="../html/pages/texture_ui_elements.js"></script>
</head>
<body>
<div>
    <h2>Generate Stimulus For Texture Vis Experiment 3</h2>
    <p>Author: Tingying He; Date: Jan. 2023</p>
    <div>
        <label for="trial_num_input">How many trials do you want for each condition?</label>
        <input type="number" id="trial_num_input" name="trial_num_input"
               min="1" max="100" value="30">
    </div>
    <div>
        <p>Click "Download" button to download images(.svg .png) and dataset(.json)</p>
        <button id="saveSVG">Download</button>
        <!--        <button id="sendSVG">SendSVG</button>-->
    </div>
    <div>
        <p>This scripts is used for generating stimulus for Texture Vis Experiment 3.</p>
        <p>Conditions: 3 texture types (geometric, iconic, color) * 2 chart types (bar chart, pie chart) = 6 conditions. </p>
        <!--        <p>After you set your repetition time for each condition (n), this scripts will generate a datasets.json. It includes n dataset. Each set of data has 7 fruits and their corresponding values, and whether they are selected for size comparison. Here is an example set of data, when repetition time = 12:</p>-->

    </div>


</div>
<div id="chartDiv" class="chartDiv"></div>


</body>
<script>
    /** Generate datasets */

        // const fruits = ["carrot", "celery","corn", "eggplant","mushroom", "olive", "tomato"]

    let trial_num_per_condition = 30 //this is number of images we need to create. Accordingly, we have to generate so many datasets. We get this number from input.
    document.getElementById('trial_num_input').oninput = function (){
        trial_num_per_condition = document.getElementById('trial_num_input'). value
        console.log('trial number per condition: '+ trial_num_per_condition)
    }

    const min_separation = 5 // the values of the two fruits to be compared should be separated by at least this interval.
    const max_same_elements_num = 5 //the number of same value of two values list. For example, [1,2,3,4,5,6,7] and [1,2,3,4,5,6,8] have 2 same value.

    let shuffledFruitsList = [] //a list of fruits list. The order of the fruits is random.
    let valuesList = [] //a list of values list.

    //create a list for values. The length of the valuesList should be the same as the images we want.
    //How many datasets we need, how many times we iterate
    while(valuesList.length < trial_num_per_condition) {
        let values = [] //to save values of one dataset (7 values, for 7 fruits)
        for (let j = 0; j < fruits.length; j++) {
            let value = Math.floor(Math.random() * 91) + 5 //chart values were uniformly distributed between 5 and 95
            values.push(value)
        }

        //check how many same elements the new values list has compared to each of the lists already exist in the valueslist
        if (valuesList.length == 0) {
            //if the valuesList is empty, we do not need to compare
            valuesList.push(values)
        } else {
            //compare the new values list with each list in the valuesList, and get the number of how many same elements
            let addFlag = true
            let j = 0
            while (j < valuesList.length) {
                //get the number of how many same elements do the valuesList[j] and values have
                let same_elements_num = count_same_elements_in_two_arrays(valuesList[j], values)

                //if the same elements is more than the max same elements number, we will NOT add this new values list to valuesList.
                if (same_elements_num > max_same_elements_num) {
                    addFlag = false
                    break;
                }
                j = j + 1;
            }

            //if we have compare the new values with all previous existing elements in the valuesList, and the same elements number are all larger enough
            if(addFlag){
                //we add this new values to valuesList
                valuesList.push(values)
            }
        }
    }

    //create a list for fruits. The length of the valuesList should be the same as the images we want.
    //we need to randomly shuffle the order of the original fruits list
    for(let i = 0; i < trial_num_per_condition; i ++){
        let shuffledFruits = shuffleArray(fruits)
        shuffledFruitsList.push(shuffledFruits)
    }



    //create the fruit-value datasets. The length of the valuesList should be the same as the images we want.
    let datasets = []
    for(let i = 0; i < trial_num_per_condition; i++){
        let data = [] //data for one image

        for(let j = 0; j < fruits.length; j++){
            let fruitObject = {}
            fruitObject.fruit = shuffledFruitsList[i][j]
            fruitObject.value = valuesList[i][j]
            data.push(fruitObject)
        }

        //pick to fruits for comparing value.
        let picked_fruit_index_a = Math.floor(Math.random() * 7) //randomly pick the first fruit
        let picked_fruit_index_b = -1

        // check whether the two picked value are seperated by min_separation. If the difference are not enough, we continue to pick a new one.
        let difference_between_two_picked_fruits = -1
        while (difference_between_two_picked_fruits < min_separation){
            // we randomly pick one fruit
            let random_index = Math.floor(Math.random() * 7)

            // if this fruit is not the same as the first picked fruit
            if (random_index != picked_fruit_index_a){
                //we set it as the second picked fruit
                picked_fruit_index_b = random_index
                //compare the difference of values of these two fruits. If the difference is less than the min_separation, we continue to pick a new second fruit. Otherwise, we jump out of the loop.
                difference_between_two_picked_fruits = Math.abs(data[picked_fruit_index_a].value - data[picked_fruit_index_b].value)
            }
        }

        //for the two picked fruits, set their property 'picked' as true. For the rest, set as false.
        for(let i = 0; i < fruits.length; i++){
            if(i == picked_fruit_index_a || i == picked_fruit_index_b){
                data[i].picked = true
            }else{
                data[i].picked = false
            }
        }

        //add the data to datasets List
        datasets.push(data)
    }

    function count_same_elements_in_two_arrays(array1, array2){
        //reference: https://stackoverflow.com/questions/49840742/find-count-of-matched-elements-in-two-arrays
        let arr1 = array1,
            arr2 = array2,
            compare = (a1, a2) => arr1.reduce((a, c) => a + arr2.includes(c), 0);
        return compare(arr1, arr2)
    }

    //combine keys list and values list to final datasets
    //reference: https://stackoverflow.com/questions/39127989/create-an-object-from-an-array-of-keys-and-an-array-of-values
    function combineKeysValues(keys, values){
        let result = {};
        keys.forEach((key, i) => result[key] = values[i]);
        return result
    }

    function shuffleArray(array) {
        //The Fisher-Yates algorithm: shuffle an array and have a truly random distribution of items
        //reference: https://dev.to/codebubb/how-to-shuffle-an-array-in-javascript-2ikj
        let shuffledArray = [...array]
        for (let i = shuffledArray.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            const temp = shuffledArray[i];
            shuffledArray[i] = shuffledArray[j];
            shuffledArray[j] = temp;
        }
        return shuffledArray
    }

    function downloadObjectAsJson(exportObj, exportName){
        let dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(exportObj));
        let downloadAnchorNode = document.createElement('a');
        downloadAnchorNode.setAttribute("href",     dataStr);
        downloadAnchorNode.setAttribute("download", exportName + ".json");
        document.body.appendChild(downloadAnchorNode); // required for firefox
        downloadAnchorNode.click();
        downloadAnchorNode.remove();
    }

    function showPickedTwo(data){
        let a = []
        for(let i = 0; i < data.length; i++){
            if(data[i].picked){
                a.push(data[i].fruit)
            }
        }
        return a
    }



    /**
     * Use datasets to generate images. With each dataset, we generate 6 images (2 chart_type * 3 texture_type)
     * To be specific: 1 geometric bar, 1 iconic bar, 1 white bar, 1 geometric pie, 1 iconic pie, 1 white pie (if we use black chart, then the outline stroke will not be visible)
     */

    let geo_parameters = {
        "patternType_carrot_": 1,
        "linePattern_carrot_Density": "20",
        "linePattern_carrot_StrokeWidth": "1",
        "linePattern_carrot_StrokeWidthMax": "20",
        "linePattern_carrot_X": "0",
        "linePattern_carrot_Y": "0",
        "linePattern_carrot_Rotate": "0",
        "linePattern_carrot_Background": 0,
        "dotPattern_carrot_Rotate": "0",
        "dotPattern_carrot_Density": "8",
        "dotPattern_carrot_Size": "1",
        "dotPattern_carrot_SizeMax": "4",
        "dotPattern_carrot_X": "0",
        "dotPattern_carrot_Y": "0",
        "dotPattern_carrot_Background": 0,
        "dotPattern_carrot_Primitive": 0,
        "dotPattern_carrot_PrimitiveStrokeWidthMax": "2",
        "dotPattern_carrot_PrimitiveStrokeWidth": "1",
        "gridPattern_carrot_Density": "4",
        "gridPattern_carrot_StrokeWidthMax": "10",
        "gridPattern_carrot_StrokeWidth": "1",
        "gridPattern_carrot_X": "0",
        "gridPattern_carrot_Y": "0",
        "gridPattern_carrot_Angle": "45",
        "gridPattern_carrot_Rotate": "0",
        "gridPattern_carrot_Background": 0,
        "patternType_celery_": 1,
        "linePattern_celery_Density": "20",
        "linePattern_celery_StrokeWidth": "1",
        "linePattern_celery_StrokeWidthMax": "20",
        "linePattern_celery_X": "0",
        "linePattern_celery_Y": "0",
        "linePattern_celery_Rotate": "0",
        "linePattern_celery_Background": 0,
        "dotPattern_celery_Rotate": "45",
        "dotPattern_celery_Density": "12",
        "dotPattern_celery_Size": "2",
        "dotPattern_celery_SizeMax": "6",
        "dotPattern_celery_X": "0",
        "dotPattern_celery_Y": "0",
        "dotPattern_celery_Background": 0,
        "dotPattern_celery_Primitive": 1,
        "dotPattern_celery_PrimitiveStrokeWidthMax": "4",
        "dotPattern_celery_PrimitiveStrokeWidth": "1",
        "gridPattern_celery_Density": "4",
        "gridPattern_celery_StrokeWidthMax": "10",
        "gridPattern_celery_StrokeWidth": "1",
        "gridPattern_celery_X": "0",
        "gridPattern_celery_Y": "0",
        "gridPattern_celery_Angle": "45",
        "gridPattern_celery_Rotate": "0",
        "gridPattern_celery_Background": 0,
        "patternType_corn_": 1,
        "linePattern_corn_Density": "20",
        "linePattern_corn_StrokeWidth": "1",
        "linePattern_corn_StrokeWidthMax": "20",
        "linePattern_corn_X": "0",
        "linePattern_corn_Y": "0",
        "linePattern_corn_Rotate": "0",
        "linePattern_corn_Background": 0,
        "dotPattern_corn_Rotate": "45",
        "dotPattern_corn_Density": "12",
        "dotPattern_corn_Size": "2",
        "dotPattern_corn_SizeMax": "6",
        "dotPattern_corn_X": "0",
        "dotPattern_corn_Y": "0",
        "dotPattern_corn_Background": 0,
        "dotPattern_corn_Primitive": 1,
        "dotPattern_corn_PrimitiveStrokeWidthMax": "4",
        "dotPattern_corn_PrimitiveStrokeWidth": "2",
        "gridPattern_corn_Density": "4",
        "gridPattern_corn_StrokeWidthMax": "10",
        "gridPattern_corn_StrokeWidth": "1",
        "gridPattern_corn_X": "0",
        "gridPattern_corn_Y": "0",
        "gridPattern_corn_Angle": "45",
        "gridPattern_corn_Rotate": "0",
        "gridPattern_corn_Background": 0,
        "patternType_eggplant_": 0,
        "linePattern_eggplant_Density": "7",
        "linePattern_eggplant_StrokeWidth": "1",
        "linePattern_eggplant_StrokeWidthMax": "7",
        "linePattern_eggplant_X": "0",
        "linePattern_eggplant_Y": "0",
        "linePattern_eggplant_Rotate": "0",
        "linePattern_eggplant_Background": 0,
        "dotPattern_eggplant_Rotate": "0",
        "dotPattern_eggplant_Density": "40",
        "dotPattern_eggplant_Size": "5",
        "dotPattern_eggplant_SizeMax": "10",
        "dotPattern_eggplant_X": "0",
        "dotPattern_eggplant_Y": "0",
        "dotPattern_eggplant_Background": 0,
        "dotPattern_eggplant_Primitive": 0,
        "dotPattern_eggplant_PrimitiveStrokeWidthMax": "5",
        "dotPattern_eggplant_PrimitiveStrokeWidth": "1",
        "gridPattern_eggplant_Density": "4",
        "gridPattern_eggplant_StrokeWidthMax": "10",
        "gridPattern_eggplant_StrokeWidth": "1",
        "gridPattern_eggplant_X": "0",
        "gridPattern_eggplant_Y": "0",
        "gridPattern_eggplant_Angle": "45",
        "gridPattern_eggplant_Rotate": "0",
        "gridPattern_eggplant_Background": 0,
        "patternType_mushroom_": 2,
        "linePattern_mushroom_Density": "20",
        "linePattern_mushroom_StrokeWidth": "1",
        "linePattern_mushroom_StrokeWidthMax": "20",
        "linePattern_mushroom_X": "0",
        "linePattern_mushroom_Y": "0",
        "linePattern_mushroom_Rotate": "0",
        "linePattern_mushroom_Background": 0,
        "dotPattern_mushroom_Rotate": "0",
        "dotPattern_mushroom_Density": "40",
        "dotPattern_mushroom_Size": "5",
        "dotPattern_mushroom_SizeMax": "10",
        "dotPattern_mushroom_X": "0",
        "dotPattern_mushroom_Y": "0",
        "dotPattern_mushroom_Background": 0,
        "dotPattern_mushroom_Primitive": 0,
        "dotPattern_mushroom_PrimitiveStrokeWidthMax": "5",
        "dotPattern_mushroom_PrimitiveStrokeWidth": "1",
        "gridPattern_mushroom_Density": "10",
        "gridPattern_mushroom_StrokeWidthMax": "10",
        "gridPattern_mushroom_StrokeWidth": "1",
        "gridPattern_mushroom_X": "0",
        "gridPattern_mushroom_Y": "0",
        "gridPattern_mushroom_Angle": "45",
        "gridPattern_mushroom_Rotate": "45",
        "gridPattern_mushroom_Background": 0,
        "patternType_olive_": 0,
        "linePattern_olive_Density": "11",
        "linePattern_olive_StrokeWidth": "2",
        "linePattern_olive_StrokeWidthMax": "11",
        "linePattern_olive_X": "0",
        "linePattern_olive_Y": "0",
        "linePattern_olive_Rotate": "0",
        "linePattern_olive_Background": 0,
        "dotPattern_olive_Rotate": "0",
        "dotPattern_olive_Density": "40",
        "dotPattern_olive_Size": "5",
        "dotPattern_olive_SizeMax": "10",
        "dotPattern_olive_X": "0",
        "dotPattern_olive_Y": "0",
        "dotPattern_olive_Background": 0,
        "dotPattern_olive_Primitive": 0,
        "dotPattern_olive_PrimitiveStrokeWidthMax": "5",
        "dotPattern_olive_PrimitiveStrokeWidth": "1",
        "gridPattern_olive_Density": "4",
        "gridPattern_olive_StrokeWidthMax": "10",
        "gridPattern_olive_StrokeWidth": "1",
        "gridPattern_olive_X": "0",
        "gridPattern_olive_Y": "0",
        "gridPattern_olive_Angle": "45",
        "gridPattern_olive_Rotate": "0",
        "gridPattern_olive_Background": 0,
        "patternType_tomato_": 2,
        "linePattern_tomato_Density": "20",
        "linePattern_tomato_StrokeWidth": "1",
        "linePattern_tomato_StrokeWidthMax": "20",
        "linePattern_tomato_X": "0",
        "linePattern_tomato_Y": "0",
        "linePattern_tomato_Rotate": "0",
        "linePattern_tomato_Background": 0,
        "dotPattern_tomato_Rotate": "0",
        "dotPattern_tomato_Density": "40",
        "dotPattern_tomato_Size": "5",
        "dotPattern_tomato_SizeMax": "10",
        "dotPattern_tomato_X": "0",
        "dotPattern_tomato_Y": "0",
        "dotPattern_tomato_Background": 0,
        "dotPattern_tomato_Primitive": 0,
        "dotPattern_tomato_PrimitiveStrokeWidthMax": "5",
        "dotPattern_tomato_PrimitiveStrokeWidth": "1",
        "gridPattern_tomato_Density": "10",
        "gridPattern_tomato_StrokeWidthMax": "10",
        "gridPattern_tomato_StrokeWidth": "2",
        "gridPattern_tomato_X": "0",
        "gridPattern_tomato_Y": "0",
        "gridPattern_tomato_Angle": "45",
        "gridPattern_tomato_Rotate": "0",
        "gridPattern_tomato_Background": 0,
        "outline": "2",
        "halo":"5",
    }
    let icon_parameters = {
        "iconPattern0IconStyle": 0,
        "iconPattern0Density": "1.001",
        "iconPattern0Size": "40",
        "iconPattern0X": "0",
        "iconPattern0Y": "0",
        "iconPattern0RotateIcon": "45",
        "iconPattern0Rotate": "315",
        "iconPattern0Background": 0,
        "iconPattern1IconStyle": 0,
        "iconPattern1Density": "1.001",
        "iconPattern1Size": "40",
        "iconPattern1X": "0",
        "iconPattern1Y": "0",
        "iconPattern1RotateIcon": "45",
        "iconPattern1Rotate": "315",
        "iconPattern1Background": 0,
        "iconPattern2IconStyle": 0,
        "iconPattern2Density": "1.001",
        "iconPattern2Size": "40",
        "iconPattern2X": "0",
        "iconPattern2Y": "0",
        "iconPattern2RotateIcon": "45",
        "iconPattern2Rotate": "315",
        "iconPattern2Background": 0,
        "iconPattern3IconStyle": 0,
        "iconPattern3Density": "1.001",
        "iconPattern3Size": "40",
        "iconPattern3X": "0",
        "iconPattern3Y": "0",
        "iconPattern3RotateIcon": "45",
        "iconPattern3Rotate": "315",
        "iconPattern3Background": 0,
        "iconPattern4IconStyle": 0,
        "iconPattern4Density": "1.001",
        "iconPattern4Size": "40",
        "iconPattern4X": "0",
        "iconPattern4Y": "0",
        "iconPattern4RotateIcon": "45",
        "iconPattern4Rotate": "315",
        "iconPattern4Background": 0,
        "iconPattern5IconStyle": 0,
        "iconPattern5Density": "1.001",
        "iconPattern5Size": "40",
        "iconPattern5X": "0",
        "iconPattern5Y": "0",
        "iconPattern5RotateIcon": "45",
        "iconPattern5Rotate": "315",
        "iconPattern5Background": 0,
        "iconPattern6IconStyle": 0,
        "iconPattern6Density": "1.001",
        "iconPattern6Size": "40",
        "iconPattern6X": "0",
        "iconPattern6Y": "0",
        "iconPattern6RotateIcon": "45",
        "iconPattern6Rotate": "315",
        "iconPattern6Background": 0,
        "outline": "2",
        "halo": "5"
    }

    drawChartDiv('chartDiv', svgWidth, svgHeight, 'chart')



    document.getElementById('saveSVG').onclick = function(){

        let svgData
        let filename
        //create, download, and display images of all conditions for all dataset in datasets
        for(let i = 0; i < trial_num_per_condition; i++){
            // //get the two picked fruits of datasets[i], to add to filename. The first is the fruit with smaller value.
            // let picked_fruits = []
            // let picked_values = []
            // for(let j = 0; j < datasets[i].length; j++){
            //     if(datasets[i][j].picked){
            //         picked_fruits.push(datasets[i][j].fruit)
            //         picked_values.push(datasets[i][j].value)
            //     }
            // }
            // //compare the values of the two picked fruits
            // let picked_fruits_ordered = []
            // if(picked_values[0] < picked_values[1]){
            //     picked_fruits_ordered.push(picked_fruits[0])
            //     picked_fruits_ordered.push(picked_fruits[1])
            // }else{
            //     picked_fruits_ordered.push(picked_fruits[1])
            //     picked_fruits_ordered.push(picked_fruits[0])
            // }

            //bar chart
            //bar_geo
            // filename = 'bar_geo' + i +'_'+picked_fruits_ordered[0]+'_'+picked_fruits_ordered[1]
            filename = 'bar_geo' + i
            para_geoTextures_for_stimuli(d3.select('#chartA'),shuffledFruitsList[i], geo_parameters, 'para')
            drawGeoBarWithTextureFromParameters(datasets[i], 'chart', barWidth, barHeight, geo_parameters, 'para')
            svgData = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600" height="600">' + $("#chartA")[0].innerHTML + $("#chart")[0].innerHTML  + $("#chartWhiteStroke")[0].innerHTML + $("#chartBlackStroke")[0].innerHTML + '</svg>'
            show_generated_SVG_on_screen(svgData, filename)
            // downloadSVG(svgData, filename)
            // downloadPNG(svgData, filename, 600,600)
            sendPNG(svgData,filename,600,600)
            sendSVG(svgData,filename)
            emptyChartSVG('chart')

            //bar_icon
            // filename = 'bar_icon' + i +'_'+picked_fruits_ordered[0]+'_'+picked_fruits_ordered[1]
            filename = 'bar_icon' + i
            para_iconTextures(d3.select('#chartA'),fruits, icon_parameters, 'para')
            drawIconBarWithTextureFromParameters(datasets[i], 'chart', barWidth, barHeight, icon_parameters, 'para')
            svgData = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600" height="600">' + $("#chartA")[0].innerHTML + $("#chart")[0].innerHTML  + $("#chartWhiteStroke")[0].innerHTML + $("#chartBlackStroke")[0].innerHTML + '</svg>'
            show_generated_SVG_on_screen(svgData, filename)
            // downloadSVG(svgData, filename)
            // downloadPNG(svgData, filename, 600,600)
            sendPNG(svgData, filename, 600, 600)
            sendSVG(svgData,filename)
            emptyChartSVG('chart')


            //bar_color
            // filename = 'bar_color' + i +'_'+picked_fruits_ordered[0]+'_'+picked_fruits_ordered[1]
            filename = 'bar_color' + i
            drawColorBarFromParameters(datasets[i], 'chart', barWidth, barHeight, 'lightgrey')
            svgData = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600" height="600">' + $("#chartA")[0].innerHTML + $("#chart")[0].innerHTML  + $("#chartWhiteStroke")[0].innerHTML + $("#chartBlackStroke")[0].innerHTML + '</svg>'
            show_generated_SVG_on_screen(svgData, filename)
            // downloadSVG(svgData, filename)
            // downloadPNG(svgData, filename, 600,600)
            sendPNG(svgData, filename, 600, 600)
            sendSVG(svgData,filename)
            emptyChartSVG('chart')


            //pie chart
            //pie_geo
            // filename = 'pie_geo' + i +'_'+picked_fruits_ordered[0]+'_'+picked_fruits_ordered[1]
            filename = 'pie_geo' + i
            para_geoTextures_for_stimuli(d3.select('#chartA'),shuffledFruitsList[i], geo_parameters, 'para')
            drawGeoPieWithTextureFromParameters(datasets[i],'chart', pieRadius, geo_parameters, 'para')
            svgData = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600" height="600">' + $("#chartA")[0].innerHTML + $("#chart")[0].innerHTML  + $("#chartWhiteStroke")[0].innerHTML + $("#chartBlackStroke")[0].innerHTML + '</svg>'
            show_generated_SVG_on_screen(svgData, filename)
            // downloadSVG(svgData, filename)
            // downloadPNG(svgData, filename, 600,600)
            sendPNG(svgData, filename, 600, 600)
            sendSVG(svgData,filename)
            emptyChartSVG('chart')

            //pie_icon
            // filename = 'pie_icon' + i +'_'+picked_fruits_ordered[0]+'_'+picked_fruits_ordered[1]
            filename = 'pie_icon' + i
            para_iconTextures(d3.select('#chartA'),fruits, icon_parameters, 'para')
            drawIconPieWithTextureFromParameters(datasets[i], 'chart', pieRadius, icon_parameters, 'para')
            svgData = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600" height="600">' + $("#chartA")[0].innerHTML + $("#chart")[0].innerHTML  + $("#chartWhiteStroke")[0].innerHTML + $("#chartBlackStroke")[0].innerHTML + '</svg>'
            show_generated_SVG_on_screen(svgData, filename)
            // downloadSVG(svgData, filename)
            // downloadPNG(svgData, filename, 600,600)
            sendPNG(svgData, filename, 600, 600)
            sendSVG(svgData,filename)
            emptyChartSVG('chart')

            //pie_color
            // filename = 'pie_color' + i +'_'+picked_fruits_ordered[0]+'_'+picked_fruits_ordered[1]
            filename = 'pie_color' + i
            drawColorPieFromParameters(datasets[i], 'chart', pieRadius, 'lightgrey')
            svgData = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600" height="600">' + $("#chartA")[0].innerHTML + $("#chart")[0].innerHTML  + $("#chartWhiteStroke")[0].innerHTML + $("#chartBlackStroke")[0].innerHTML + '</svg>'
            show_generated_SVG_on_screen(svgData, filename)
            // downloadSVG(svgData, filename)
            // downloadPNG(svgData, filename, 600,600)
            sendPNG(svgData, filename, 600, 600)
            sendSVG(svgData,filename)
            emptyChartSVG('chart')
        }

        //send datasets to server
        sendJSON(datasets,'datasets')
        //download datasets used to create the images as a .json file
        // downloadObjectAsJson(datasets, 'datasets')
    }


    function para_geoTextures_for_stimuli(e, fruits, parameters, textureID){//textureID: when we need several sets of geo texture, we use this textureID to distinguish them
        let defs = e.append('defs')
        let linePattern = defs.selectAll(".linePattern")
            .data(fruits)
            .enter()
            .append("pattern")
            .attr("id", (_, i) => textureID+'_linePattern'+i) //para refers this pattern is created from parameters
            .attr("patternUnits", "userSpaceOnUse")
            .attr("width", function (d,i){
                return parameters['linePattern_'+fruits[i]+'_Density']
            })
            .attr("height", function (d,i){
                return parameters['linePattern_'+fruits[i]+'_Density']
            })
            .attr('patternTransform', function (d,i){
                let x = parameters['linePattern_'+fruits[i]+'_X']
                let y = parameters['linePattern_'+fruits[i]+'_Y']
                let degree = parameters['linePattern_'+fruits[i]+'_Rotate']

                return 'translate('+x+','+y+') rotate('+degree+')'
            })

        linePattern.append('rect')
            .attr("x", 0)
            .attr("y", 0)
            .attr("width", 40)
            .attr("height", 40)
            .attr("stroke-width", 0)
            .attr("fill", function (d,i){
                if(parameters['linePattern_'+fruits[i]+'_Background'] == 0){
                    return 'white'
                }
                if(parameters['linePattern_'+fruits[i]+'_Background'] == 1){
                    return 'black'
                }
            })

        linePattern.append('path')
            .attr('d','m -100 0 l 200 0')
            .attr("stroke-width", function (d,i){
                return parameters['linePattern_'+fruits[i]+'_StrokeWidth']
            })
            .attr('stroke',function (d,i){
                if(parameters['linePattern_'+fruits[i]+'_Background'] == 0){
                    return 'black'
                }
                if(parameters['linePattern_'+fruits[i]+'_Background'] == 1){
                    return 'white'
                }
            })
            .attr('transform',  (_, i) => 'translate(0,'+0.5*parameters['linePattern_'+fruits[i]+'_Density']+')')

        let dotPattern = defs.selectAll(".dotPattern")
            .data(fruits)
            .enter()
            .append("pattern")
            .attr("id", (_, i) => textureID+'_dotPattern'+i)
            .attr("patternUnits", "userSpaceOnUse")
            .attr("width", function (d,i){
                return parameters['dotPattern_'+fruits[i]+'_Density']
            })
            .attr("height", function (d,i){
                return parameters['dotPattern_'+fruits[i]+'_Density']
            })
            .attr('patternTransform', function (d,i){
                let x = parameters['dotPattern_'+fruits[i]+'_X']
                let y = parameters['dotPattern_'+fruits[i]+'_Y']
                let degree = parameters['dotPattern_'+fruits[i]+'_Rotate']

                return 'translate('+x+','+y+') rotate('+degree+')'
            })

        dotPattern.append('rect')
            .attr("x", 0)
            .attr("y", 0)
            .attr("width", 40)
            .attr("height", 40)
            .attr("stroke-width", 0)
            .attr("fill", function (d,i){
                if(parameters['dotPattern_'+fruits[i]+'_Background'] == 0){
                    return 'white'
                }
                if(parameters['dotPattern_'+fruits[i]+'_Background'] == 1){
                    return 'black'
                }
            })

        dotPattern.append('circle')
            .attr('cx', function (d,i){
                return 0.5*parameters['dotPattern_'+fruits[i]+'_Density']
            })
            .attr('cy', function (d,i){
                return 0.5*parameters['dotPattern_'+fruits[i]+'_Density']
            })
            .attr('r', function (d,i){
                return parameters['dotPattern_'+fruits[i]+'_Size']
            })
            .attr('stroke-width', function (d,i){
                return parameters['dotPattern_'+fruits[i]+'_PrimitiveStrokeWidth']
            })
            .attr('fill-opacity', function (d,i){
                if(parameters['dotPattern_'+fruits[i]+'_Primitive'] == 0){
                    return 1
                }
                if(parameters['dotPattern_'+fruits[i]+'_Primitive'] == 1){
                    return 0
                }
            })
            .attr('stroke-opacity', function (d,i){
                if(parameters['dotPattern_'+fruits[i]+'_Primitive'] == 0){
                    return 0
                }
                if(parameters['dotPattern_'+fruits[i]+'_Primitive'] == 1){
                    return 1
                }
            })
            .attr('fill', function (d,i){
                if(parameters['dotPattern_'+fruits[i]+'_Background'] == 0){
                    return 'black'
                }
                if(parameters['dotPattern_'+fruits[i]+'_Background'] == 1){
                    return 'white'
                }
            })
            .attr('stroke', function (d,i){
                if(parameters['dotPattern_'+fruits[i]+'_Background'] == 0){
                    return 'black'
                }
                if(parameters['dotPattern_'+fruits[i]+'_Background'] == 1){
                    return 'white'
                }
            })


        let gridPatternA = defs.selectAll(".gridPatternA")
            .data(fruits)
            .enter()
            .append("pattern")
            .attr("id", (_, i) => textureID+'_gridPatternA'+i)
            .attr("patternUnits", "userSpaceOnUse")
            .attr("width", (_, i) => parameters['gridPattern_'+fruits[i]+'_Density'])
            .attr("height", (_, i) => parameters['gridPattern_'+fruits[i]+'_Density'])
            .attr('patternTransform', function (d,i){
                let x = parameters['gridPattern_'+fruits[i]+'_X']
                let y = parameters['gridPattern_'+fruits[i]+'_Y']
                let degree = 180 - parseFloat(parameters['gridPattern_'+fruits[i]+'_Angle']) + parseFloat(parameters['gridPattern_'+fruits[i]+'_Rotate'])

                return 'translate('+x+','+y+') rotate('+degree+')'
            })

        gridPatternA.append('rect')
            .attr("x", 0)
            .attr("y", 0)
            .attr("width", 40)
            .attr("height", 40)
            .attr("stroke-width", 0)
            .attr("fill", function (d,i){
                if(parameters['gridPattern_'+fruits[i]+'_Background'] == 0){
                    return 'white'
                }
                if(parameters['gridPattern_'+fruits[i]+'_Background'] == 1){
                    return 'black'
                }
            })

        gridPatternA.append('path')
            .attr('d','m -100 0 l 200 0')
            .attr("stroke-width", (_, i) => parameters['gridPattern_'+fruits[i]+'_StrokeWidth'])
            .attr('stroke',function (d,i){
                if(parameters['gridPattern_'+fruits[i]+'_Background'] == 0){
                    return 'black'
                }
                if(parameters['gridPattern_'+fruits[i]+'_Background'] == 1){
                    return 'white'
                }
            })

        let gridPattern = defs.selectAll(".gridPattern")
            .data(fruits)
            .enter()
            .append("pattern")
            .attr("id", (_, i) => textureID+'_gridPattern'+i)
            .attr("patternUnits", "userSpaceOnUse")
            .attr("width", (_, i) => parameters['gridPattern_'+fruits[i]+'_Density'])
            .attr("height", (_, i) => parameters['gridPattern_'+fruits[i]+'_Density'])
            .attr('patternTransform', function (d,i){
                let x = parameters['gridPattern_'+fruits[i]+'_X']
                let y = parameters['gridPattern_'+fruits[i]+'_Y']
                let degree = parseFloat(parameters['gridPattern_'+fruits[i]+'_Angle']) + parseFloat(parameters['gridPattern_'+fruits[i]+'_Rotate'])

                return 'translate('+x+','+y+') rotate('+degree+')'
            })


        gridPattern.append('path')
            .attr('d','m -100 0 l 200 0')
            .attr("stroke-width", (_, i) => parameters['gridPattern_'+fruits[i]+'_StrokeWidth'])
            .attr('stroke',function (d,i){
                if(parameters['gridPattern_'+fruits[i]+'_Background'] == 0){
                    return 'black'
                }
                if(parameters['gridPattern_'+fruits[i]+'_Background'] == 1){
                    return 'white'
                }
            })

        return defs
    }




    function show_generated_SVG_on_screen(chartName,svgData){
        let div = document.createElement('div')
        document.body.appendChild(div)
        div.style.float = 'left'

        let p = document.createElement('p')
        div.appendChild(p)
        p.innerHTML = chartName

        let container = document.createElement('div')
        div.appendChild(container)
        container.innerHTML = svgData

    }

    // document.getElementById('sendSVG').onclick = function (){
    //     sendSVG('svgData111','filename111')
    //     // send_message('mymessage')
    // }


    function sendPNG(svgData, filename, pngWidth, pngHeight){
        let canvas = document.createElement('canvas');
        canvas.width = pngWidth
        canvas.height = pngHeight
        document.body.appendChild(canvas)

        let ctx = canvas.getContext('2d');

        let DOMURL = window.URL || window.webkitURL || window;

        let img = new Image();
        let svgBlob = new Blob([svgData], {type: 'image/svg+xml;charset=utf-8'});
        let url = DOMURL.createObjectURL(svgBlob);

        img.onload = function () {
            ctx.drawImage(img, 0, 0);
            DOMURL.revokeObjectURL(url);

            let dataURL = canvas
                .toDataURL('image/png')

            let obj = {}
            obj.pngData = dataURL
            obj.filename = filename

            $.ajax({
                url: 'ajax_png.php',
                type: 'POST',
                data: JSON.stringify(obj),
                contentType: 'application/json',
                dataType: 'json',
                success: function () {
                    console.log('success')
                }
            })
        };

        img.src = url;


        document.body.removeChild(canvas);

    }

    function triggerDownload (imgURI, filename) {
        let evt = new MouseEvent('click', {
            view: window,
            bubbles: false,
            cancelable: true
        });

        let a = document.createElement('a');
        a.setAttribute('download', filename +'.png');
        a.setAttribute('href', imgURI);
        a.setAttribute('target', '_blank');

        a.dispatchEvent(evt);
    }

    //send svg to server
    function sendSVG(svgData, filename){
        let obj = {}
        obj.svgData = svgData
        obj.filename = filename

        $.ajax({
            url: 'ajax_svg.php',
            type: 'POST',
            data: JSON.stringify(obj),
            contentType: 'application/json',
            dataType: "json",
            success: function () {
                console.log('success')
            }
        })
    }

    function sendJSON(jsonData, filename){
        let obj = {}
        obj.jsonData = jsonData
        obj.filename = filename

        $.ajax({
            url: 'ajax_json.php',
            type: 'POST',
            data: JSON.stringify(obj),
            contentType: 'application/json',
            dataType: "json",
            success: function () {
                console.log('success')
            }
        })
    }

    function downloadSVG(svgData, filename){
        let svgBlob = new Blob([svgData], {type:'image/svg+xml;charset=utf-8'});
        let svgUrl = URL.createObjectURL(svgBlob);

        let downloadLink = document.createElement('a');
        downloadLink.href = svgUrl;
        downloadLink.download = filename+'.svg';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
        // console.log('downloaded SVG:'+ filename + '.svg')
    }

    function downloadPNG(svgData, filename, pngWidth, pngHeight){
        let canvas = document.createElement('canvas');
        canvas.width = pngWidth
        canvas.height = pngHeight
        document.body.appendChild(canvas)

        let ctx = canvas.getContext('2d');

        let DOMURL = window.URL || window.webkitURL || window;

        let img = new Image();
        let svgBlob = new Blob([svgData], {type: 'image/svg+xml;charset=utf-8'});
        let url = DOMURL.createObjectURL(svgBlob);

        img.onload = function () {
            ctx.drawImage(img, 0, 0);
            DOMURL.revokeObjectURL(url);

            let imgURI = canvas
                .toDataURL('image/png')
                .replace('image/png', 'image/octet-stream');

            triggerDownload(imgURI, filename);
        };

        img.src = url;
        document.body.removeChild(canvas);

        // console.log('downloaded PNG:'+ filename + '.png')
    }

    //delete the chart svg from screen
    function emptyChartSVG(chart){
        $('#'+chart+'A').empty()
        $('#'+chart).empty()
        $('#'+chart+'WhiteStroke').empty()
        $('#'+chart+'BlackStroke').empty()
    }




</script>
</html>