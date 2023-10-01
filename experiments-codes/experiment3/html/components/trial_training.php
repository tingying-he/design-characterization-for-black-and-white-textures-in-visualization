<div class="row">
    <div class="col target d-flex flex-column align-items-center">
        <p id="target_left_legend_<?php echo $id;?>" ><img id="target_left_legendImg_<?php echo $id;?>"></p>
        <p style="margin-bottom: 10px"><span id="target_left_<?php echo $id;?>"></span></p>
        <p id="target_left_key_<?php echo $id;?>" ><img src="html/img/left_arrow_key_grey.png" style="height: 45px"></p>
    </div>
    <div class="col question d-flex flex-column align-items-center">
        Which has <?php echo $questions_order[$question_index]; ?>?
    </div>
    <div class="col target d-flex flex-column align-items-center">
        <p id="target_right_legend_<?php echo $id;?>" ><img id="target_right_legendImg_<?php echo $id;?>"></p>
        <p style="margin-bottom: 10px"><span id="target_right_<?php echo $id;?>"></span></p>
        <p id="target_right_key_<?php echo $id;?>" ><img src="html/img/right_arrow_key_grey.png" style="height: 45px"></p>
    </div>
</div>
<div class="row" id="chart_<?php echo $id;?>" style="display: none">
    <div class="col d-flex flex-column align-items-center">
        <img id="chart_img_<?php echo $id; ?>" style="margin-top: -50px;" src="html/stimuli/generated_svg/<?php echo $condition;?>_<?php
        if ($question_index == 0) {
            echo $textures_order_for_question0[$texture_index];
        } elseif ($question_index == 1) {
            echo $textures_order_for_question1[$texture_index];
        } else {
            echo 'Invalid question index.';
        }
        ?><?php echo $current_stimulus_index;?>.svg">
    </div>
</div>
<div class="row">
    <div class="explanation" id="explanation_<?php echo $id;?>" style="margin-left: 300px;width: 680px">
        <!--    step 1: only show the question and target on the screen-->
        <div id="explanation_question_<?php echo $id;?>" >
            <p>Take a moment to look at the two items and the question</p>
            <p>Put your fingers on the <b>left <img src="html/img/left_arrow_key_grey.png" style="height: 30px"> and right <img src="html/img/right_arrow_key_grey.png" style="height: 30px"> arrow keys</b> of your keyboard to prepare</p>
            <p>Then press <b>space bar</b> on your keyboard to see the chart. </p>
            <p>The charts will only appear <b>briefly</b>. So make sure you're ready...</p>
        </div>
        <!--    step 2: after participant presses SPACE, show the chart-->
        <div id="explanation_chart_<?php echo $id;?>" class="col-md-offset-1 col-md-10 practice" style="display: none">
            <p>Click on the name of the vegetable to indicate which item in the chart can answer the question. </p>
        </div>

        <div id="explanation_result_<?php echo $id;?>">
            <!--    correct-->
            <div id="explanation_result_correct_<?php echo $id;?>" style="display: none;">
                <p style="color:#B43C1F;"><b>Correct!</b></p>
            </div>
            <!--    incorrect-->
            <div id="explanation_result_incorrect_<?php echo $id;?>" style="display: none;">
                <p style="color:#B43C1F;"><b>Incorrect.</b></p>
            </div>
            <!--timeout-->
            <div id="explanation_result_timeout_<?php echo $id;?>" style="display: none">
                <p>Time is out! </p>
            </div>
        </div>


        <!--    continue-->
        <div id="explanation_continue_<?php echo $id;?>" style="display: none">
            <p>Press <b>space bar</b> on your keyboard to continue. </p>
        </div>
    </div>
</div>