
        <h2>Now it’s your turn to design an effective set of textures for data visualization</h2>
        <div style="width:680px">

            <p>Imagine you are asked to create a chart with texture for a high-resolution e-ink display which can only show black and white content. <span id="fruit_survey_description"></span>
            </p>
            <p>
                Please adjust the texture parameters to create an aesthetically pleasing and readable visualization.
            </p>
            <p>
                Please optimize for datasets in general. Click the change data set button (<img src="./img/icons/change_data.png" class="img-button-in-description">) to test your design on different random data sets, and click the default data set button (<img src="./img/icons/default_data.png" class="img-button-in-description">) to test your design on a default data set.
            </p>
            <p>
                When you finish designing, click on the <span style="color:#1E90FF;font-weight: bold">Next</span> button in the bottom right corner of the page.</p>
            </p>
        </div>


<!--<div class="row">-->
<!--    <div class="col-">-->
<!--        <h2>Now it’s your turn to design an effective set of textures for data visualization</h2>-->
<!--        <p>-->
<!--            Imagine you are asked to create a chart with texture for a high-resolution e-ink display which can only show black and white content. This chart shows the favorite vegetable of the residents of each French department.-->
<!--        </p>-->
<!--        <p>-->
<!--            Please edit the texture parameters to create an effective set of textures.-->
<!--            Please optimize for datasets in general, and click the “change data” button to test your design on different random data.-->
<!--            The data we use are random.-->
<!--        </p>-->
<!--        <p>-->
<!--            There is no time limit for this task<span id="last-task"></span>-->
<!--        </p>-->
<!--    </div>-->
<!--</div>-->

<script>
    let task_description_measurements = JSON.parse(localStorage.getItem('measurements'))
    let task_description_condition_texture = task_description_measurements['condition_texture']
    let task_description_condition_chart = task_description_measurements['condition_chart']

    if(task_description_condition_chart == 2){ //map
        document.getElementById('fruit_survey_description').innerHTML = 'This map shows the favorite vegetable of the residents of each French department.'
    }else{ //bar or pie
        document.getElementById("This chart shows the result of a survey about people's favourite vegetables.")
    }

    // switch (task_description_condition_texture){
    //     case 0: //geo_icon
    //         document.getElementById('last_task').innerHTML=". This is the last design task."
    //         break;
    //     case 1: //icon_geo
    //         document.getElementById('last_task').innerHTML=", but keep in mind that we will ask you to complete one other design after this one."
    //         break;
    // }
</script>

