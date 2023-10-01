<!--<p>training_question0.php</p>-->

<?php
$question_index = 0;
$texture_index = 1;

// Which trial is this under this condition? If $trial_number = 0, this is the first trial under this condition (e.g., bar geo fewer condition)
$trial_number = $page_number - $first_page_number;
$current_stimulus_index = get_current_stimulus_index($question_index, $texture_index, $trial_number);

//echo 'question_condition: ' . $questions_order[$question_index]  . '<br>' .
//    'texture_condition: '.$textures_order_for_question0[$texture_index]. '<br>' .
//    $trial_number. 'trial of this condition';

//$current_stimulus_index = get_current_stimulus_index($question_index, $texture_index, $trial_number);
?>


<div>Successfully Completed Training: <?php echo $trial_number;?>/3 </div>
<?php
include 'html/components/trial_training.php'
?>




<script>
    //hide next button
    document.addEventListener("DOMContentLoaded", function(){
        let nextBtn = document.getElementById("btn_<?php echo $id;?>");
        nextBtn.style.display = 'none';
    });

    $('body').on('show', function(e, type){
        // console.log("show");
        if (type === '<?php echo $id;?>'){
            console.log("showing page " + type);

            let id = <?php echo json_encode($id); ?>;
            let page_number = <?php echo json_encode($page_number); ?>;
            setProgressBar(page_number, id, page_total_number)

            //let question = <?php //echo json_encode($questions_order[$question_index]); ?>//;
            //let img_path = "html/stimuli/generated_svg_training/<?php //echo $condition;?>//_<?php //echo $textures_order_for_question0[$texture_index];?>//"
            //let condition = <?php //echo json_encode($condition); ?>//;

            let current_stimulus_index = <?php echo json_encode($current_stimulus_index); ?>;
            let question = <?php echo json_encode($questions_order[$question_index]); ?>;
            let condition = <?php echo json_encode($condition); ?>;
            let img_path = "html/stimuli/generated_svg_training/<?php echo $condition;?>_<?php echo $textures_order_for_question0[$texture_index];?>"
            let texture = <?php echo json_encode($textures_order_for_question0[$texture_index]); ?>;
            trial_measure_training = new_training_trial(id, img_path, question, texture, condition, chart_present_time)

        }
    });


    //when the next button is clicked
    $('body').on('next', function(e, type){
        if (type === '<?php echo $id;?>'){
            //send csv results to server
            for(let i = 0; i < trial_measure_training.length; i++){
                let obj = createLoggingObj(measurements['participant_id'], //participant_id
                    trial_measure_training[i].answer_accuracy, //answer_accuracy
                    trial_measure_training[i].elapsed_time, //elapsed_time
                    'training', //trial_type
                    '<?php echo $condition ;?>', //condition
                    trial_measure_training[i].current_stimulus_index, //current_stimulus_index
                    trial_measure_training[i].target_left, //target_left
                    trial_measure_training[i].target_right, //target_right
                    trial_measure_training[i].correct_answer, //correct_answer
                    trial_measure_training[i].key_pressed, //key_pressed
                    '<?php echo addslashes(strtolower(implode(", ", $questions_order))); ?>', //questions_order
                    '<?php echo $question_index;?>', //question_index
                    '<?php echo $questions_order[$question_index] ;?>', //question_condition
                    '<?php echo addslashes(strtolower(implode(", ", $textures_order_for_question0))) ;?>', //textures_order_for_question
                    '<?php echo $texture_index;?>', //texture_index
                    '<?php echo $textures_order_for_question0[$texture_index]; ?>', //texture_condition, !!here can be question0 or question 1
                    '<?php echo $trial_number ;?>' //trial_number
                )
            
                $.ajax({
                    url: 'html/ajax/trial_texture.php', //path to the script who handles this
                    type: 'POST',
                    data: JSON.stringify(obj),
                    contentType: 'application/json',
                    async: false, // Make the request synchronous
                    success: function (data) {
                        console.log('logging training data')
                        console.log(obj)
                    }
                })
            }
        }

    });



</script>