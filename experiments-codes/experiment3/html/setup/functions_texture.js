/**
 * Here are custom functions for the texture project.
 */


/**
 * This function can generate one trial of the texture perceptual experiment. Include: show the contents step by step, check the user input and judge the correctness of the user input answer
 * @param id php variable $id of each page, like welcome_1
 * @param current_stimulus_index We shuffle the order of the original datasets. This variable refers to the index of the current stimulus in the original array.
 */
function new_trial(id, current_stimulus_index, question, texture, condition, chart_present_time){
    let trial_measure = {}

    trial_measure.current_stimulus_index = current_stimulus_index;

    let target_left = trial_targets[current_stimulus_index][condition + '_targetLeft']
    let target_right = trial_targets[current_stimulus_index][condition + '_targetRight']

    let target_left_btn = document.getElementById('target_left_'+id)
    let target_right_btn = document.getElementById('target_right_'+id)
    target_left_btn.innerHTML = target_left
    target_right_btn.innerHTML = target_right

    trial_measure.target_left = target_left;
    trial_measure.target_right = target_right;

    //set targets' legendImg
    if (texture != 'color') {
        // texture is not equal to "color"
        document.getElementById('target_left_legendImg_'+id).src = 'html/img/legends/'+condition+'_'+ texture + '_'+ target_left +'.svg'
        document.getElementById('target_right_legendImg_'+id).src = 'html/img/legends/'+condition+'_'+ texture + '_'+ target_right +'.svg'
    } else {
        // texture is equal to "color"
        document.getElementById('target_left_legendImg_'+id).src = 'html/img/legends/grey.svg'
        document.getElementById('target_right_legendImg_'+id).src = 'html/img/legends/grey.svg'
    }


    let correct_answer = trial_targets[current_stimulus_index][question.toLowerCase()]

    trial_measure.correct_answer = correct_answer;

    let correct_key
    if (target_left === correct_answer) {
        correct_key = "ArrowLeft";
    } else if (target_right === correct_answer) {
        correct_key = "ArrowRight";
    }

    trial_measure.correct_key = correct_key;

    console.log('correct_key:' + correct_key)

    //when this page is shown, the user should only see the question.

    let chart = document.getElementById('chart_'+id)
    let nextBtn = document.getElementById('btn_'+id)

    document.getElementById('explanation_chart_'+id).style.display = 'none'
    document.getElementById('explanation_result_'+id).style.display = 'none';
    document.getElementById('explanation_result_correct_'+id).style.display = 'none';
    document.getElementById('explanation_result_incorrect_'+id).style.display = 'none';
    document.getElementById('explanation_result_timeout_'+id).style.display = 'none';
    document.getElementById('explanation_continue_'+id).style.display = 'none';


    //show two targets
    document.getElementById('target_left_legendImg_'+id).style.display = "block";
    document.getElementById('target_right_legendImg_'+id).style.display = "block";
    document.getElementById('target_left_'+id).style.display = "block";
    document.getElementById('target_right_'+id).style.display = "block";
    document.getElementById('target_left_key_'+id).style.display = "block";
    document.getElementById('target_right_key_'+id).style.display = "block";

    //show the explanation for question
    document.getElementById('explanation_question_'+id).style.display = 'block'

    //after they press "space", they can see the chart
    document.addEventListener("keydown", function input_answer(event) {
        if (event.code === "Space") {
            chart.style.display = "block";

            document.getElementById('explanation_question_'+id).style.display = 'none'

            let startTime = Date.now();
            let answer_accuracy;

            // define the event listener function
            function innerEventListener(event) {
                // code to execute when the keydown event is triggered
                if (event.code === "ArrowLeft" || event.code === "ArrowRight") {
                    clearTimeout(timer);
                    let elapsedTime = (Date.now() - startTime);
                    trial_measure.elapsed_time = elapsedTime;
                    // console.log(`Elapsed time: ${elapsedTime} seconds`);

                    let key_pressed = event.code
                    trial_measure.key_pressed = event.code;


                    if (key_pressed === correct_key) {
                        answer_accuracy = 1 //correct
                        trial_measure.answer_accuracy = answer_accuracy;
                        console.log("correct");
                        afterGotResult('correct');



                    } else {
                        answer_accuracy = 0 //incorrect
                        trial_measure.answer_accuracy = answer_accuracy;
                        console.log("incorrect");
                        afterGotResult('incorrect');

                    }
                    document.removeEventListener("keydown", innerEventListener);
                    document.removeEventListener("keydown", input_answer);


                } else {
                    console.log("Please press ArrowLeft or ArrowRight");
                }
            }

            // add the event listener to the document
            document.addEventListener("keydown", innerEventListener);

            let timer = setTimeout(function() {
                trial_measure.elapsed_time = chart_present_time;
                
                answer_accuracy = -1;
                trial_measure.answer_accuracy = answer_accuracy;
                trial_measure.key_pressed = 'none';
                // console.log(`Elapsed time: ${elapsedTime} seconds`);
                console.log("No key pressed within 1.5s");
                document.removeEventListener("keydown", innerEventListener);
                // Do whatever you want to do when 1.5s passed without a key press
                afterGotResult('timeout')

            }, chart_present_time);

            function afterGotResult(result){
                //hide chart
                document.getElementById('chart_'+id).style.display = "none";

                //hide the two targets
                document.getElementById('target_left_legendImg_'+id).style.display = "none";
                document.getElementById('target_right_legendImg_'+id).style.display = "none";
                document.getElementById('target_left_'+id).style.display = "none";
                document.getElementById('target_right_'+id).style.display = "none";
                document.getElementById('target_left_key_'+id).style.display = "none";
                document.getElementById('target_right_key_'+id).style.display = "none";

                //show result: correct, incorrect, timeout
                document.getElementById('explanation_result_'+id).style.display = 'block';
                document.getElementById('explanation_result_'+result+'_'+id).style.display = 'block';

                //show instruction "press space bar to continue"
                document.getElementById('explanation_continue_'+id).style.display = 'block';
                //press SPACE to go to next trial
                document.addEventListener("keydown", function next_trial(event) {
                    if (event.code === "Space") {
                        nextBtn.click();
                        document.removeEventListener("keydown", next_trial);
                    }
                })
            }
            document.removeEventListener("keydown", input_answer);
        }
    });

    return trial_measure
}

function new_training_trial(id, img_path, question, texture, condition, chart_present_time){
    let trial_measure_training = []

    //reset the stimulus' index: we need to show another stimulus
    let current_stimulus_index = Math.floor(Math.random() * (trial_targets_training.length - 1))
    console.log(current_stimulus_index)

    let img = document.getElementById('chart_img_'+id)
    img.src = img_path + current_stimulus_index+".svg"

    let target_left = trial_targets_training[current_stimulus_index][condition + '_targetLeft']
    let target_right = trial_targets_training[current_stimulus_index][condition + '_targetRight']

    let target_left_btn = document.getElementById('target_left_'+id)
    let target_right_btn = document.getElementById('target_right_'+id)
    target_left_btn.innerHTML = target_left
    target_right_btn.innerHTML = target_right

    //set targets' legendImg
    if (texture != 'color') {
        // texture is not equal to "color"
        document.getElementById('target_left_legendImg_'+id).src = 'html/img/legends/'+condition+'_'+ texture + '_'+ target_left +'.svg'
        document.getElementById('target_right_legendImg_'+id).src = 'html/img/legends/'+condition+'_'+ texture + '_'+ target_right +'.svg'
    } else {
        // texture is equal to "color"
        document.getElementById('target_left_legendImg_'+id).src = 'html/img/legends/grey.svg'
        document.getElementById('target_right_legendImg_'+id).src = 'html/img/legends/grey.svg'
    }

    let correct_answer = trial_targets_training[current_stimulus_index][question.toLowerCase()]

    let correct_key
    if (target_left === correct_answer) {
        correct_key = "ArrowLeft";
    } else if (target_right === correct_answer) {
        correct_key = "ArrowRight";
    }

    console.log('correct_key:' + correct_key)

    //when this page is shown, the user should only see the question.

    let chart = document.getElementById('chart_'+id)
    let nextBtn = document.getElementById('btn_'+id)

    document.getElementById('explanation_chart_'+id).style.display = 'none'
    document.getElementById('explanation_result_'+id).style.display = 'none';
    document.getElementById('explanation_result_correct_'+id).style.display = 'none';
    document.getElementById('explanation_result_incorrect_'+id).style.display = 'none';
    document.getElementById('explanation_result_timeout_'+id).style.display = 'none';
    document.getElementById('explanation_continue_'+id).style.display = 'none';


    //show two targets
    document.getElementById('target_left_legendImg_'+id).style.display = "block";
    document.getElementById('target_right_legendImg_'+id).style.display = "block";
    document.getElementById('target_left_'+id).style.display = "block";
    document.getElementById('target_right_'+id).style.display = "block";
    document.getElementById('target_left_key_'+id).style.display = "block";
    document.getElementById('target_right_key_'+id).style.display = "block";

    //show the explanation for question
    document.getElementById('explanation_question_'+id).style.display = 'block'

    document.addEventListener("keydown", function input_answer(event) {
        if (event.code === "Space") {
            chart.style.display = "block";

            document.getElementById('explanation_question_'+id).style.display = 'none'

            let startTime = Date.now();
            let answer_accuracy;

            // define the event listener function
            function innerEventListener(event) {
                // code to execute when the keydown event is triggered
                if (event.code === "ArrowLeft" || event.code === "ArrowRight") {
                    clearTimeout(timer);
                    let elapsedTime = (Date.now() - startTime);

                    console.log(`Elapsed time: ${elapsedTime} seconds`);

                    let key_pressed = event.code


                    if (key_pressed === correct_key) {
                        answer_accuracy = 1 //correct
                        console.log("correct");

                        afterGotResult('correct');

                        trial_measure_training.push({
                            answer_accuracy: 1,
                            elapsed_time:elapsedTime,
                            key_pressed: key_pressed,
                            current_stimulus_index: current_stimulus_index,
                            target_left: target_left,
                            target_right: target_right,
                            correct_answer: correct_answer
                        });



                    } else {
                        answer_accuracy = 0 //incorrect
                        console.log("incorrect");
                        // afterGotResult('incorrect');

                        trial_measure_training.push({
                            answer_accuracy: 0,
                            elapsed_time:elapsedTime,
                            key_pressed: key_pressed,
                            current_stimulus_index: current_stimulus_index,
                            target_left: target_left,
                            target_right: target_right,
                            correct_answer: correct_answer
                        });

                        afterGotResult('incorrect')

                    }
                    document.removeEventListener("keydown", innerEventListener);
                    document.removeEventListener("keydown", input_answer);


                } else {
                    console.log("Please press ArrowLeft or ArrowRight");
                }
            }

            // add the event listener to the document
            document.addEventListener("keydown", innerEventListener);

            let timer = setTimeout(function() {
                let elapsedTime = chart_present_time;
                answer_accuracy = -1;
                trial_measure_training.push({
                    answer_accuracy: -1,
                    elapsed_time:elapsedTime,
                    key_pressed: 'none',
                    current_stimulus_index: current_stimulus_index,
                    target_left: target_left,
                    target_right: target_right,
                    correct_answer: correct_answer
                });
                console.log(`Elapsed time: ${elapsedTime} seconds`);
                document.removeEventListener("keydown", innerEventListener);
                // Do whatever you want to do when 1.5s passed without a key press
                afterGotResult('timeout')

            }, chart_present_time);

            function afterGotResult(result){
                //hide chart
                document.getElementById('chart_'+id).style.display = "none";

                //hide the two targets
                document.getElementById('target_left_legendImg_'+id).style.display = "none";
                document.getElementById('target_right_legendImg_'+id).style.display = "none";
                document.getElementById('target_left_'+id).style.display = "none";
                document.getElementById('target_right_'+id).style.display = "none";
                document.getElementById('target_left_key_'+id).style.display = "none";
                document.getElementById('target_right_key_'+id).style.display = "none";

                //show result: correct, incorrect, timeout
                document.getElementById('explanation_result_'+id).style.display = 'block';
                document.getElementById('explanation_result_'+result+'_'+id).style.display = 'block';

                //show instruction "press space bar to continue"
                document.getElementById('explanation_continue_'+id).style.display = 'block';

                if(result === 'correct'){
                    //press SPACE to go to next trial
                    document.addEventListener("keydown", function next_trial(event) {
                        if (event.code === "Space") {
                            nextBtn.click();
                            document.removeEventListener("keydown", next_trial);
                        }
                    })
                }else{
                    //press SPACE to redo this training trial
                    document.addEventListener("keydown", function redo_training_trial(event) {
                        if (event.code === "Space") {
                            document.getElementById("explanation_result_"+id).style.display = "none";
                            document.getElementById("explanation_continue_"+id).style.display = "none";
                            new_training_trial(id, img_path, question, texture, condition, chart_present_time)
                            document.removeEventListener("keydown", redo_training_trial);
                        }
                    })
                }

            }
            document.removeEventListener("keydown", input_answer);
        }


    });

    return trial_measure_training
}

/**
 * check if a group of Likert items is answered
 * @param radioName name attribute of the radio group
 * @returns {boolean}
 */
function isAnswered(radioName){
    let radioButtons = document.querySelectorAll(`input[type="radio"][name="${radioName}"]`);
    let isOneSelected = false;

    for (let i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            isOneSelected = true;
            break;
        }
    }

    return isOneSelected
}

function createLoggingObj(participant_id, //participant_id
                          answer_accuracy, //answer_accuracy
                          elapsed_time, //elapsed_time
                          trial_type, //trial_type
                          condition, //condition
                          current_stimulus_index, //current_stimulus_index
                          target_left, //target_left
                          target_right, //target_right
                          correct_answer, //correct_answer
                          key_pressed, //key_pressed
                          questions_order, //questions_order
                          question_index, //question_index
                          question_condition, //question_condition
                          textures_order_for_question, //textures_order_for_question
                          texture_index, //texture_index
                          texture_condition, //texture_condition
                          trial_number //trial_number
                          ){
    let obj = {} //an object used for saving parameters we want to pass to the individual log file
    obj.participant_id = participant_id;

    //trial_measure: parameters we measured from participants
    obj.answer_accuracy = answer_accuracy;
    obj.elapsed_time = elapsed_time;

    //trial information
    obj.trial_type = trial_type;
    obj.condition = condition; //Bar or Pie

    //stimuli
    obj.current_stimulus_index = current_stimulus_index;

    //target
    obj.target_left = target_left;
    obj.target_right = target_right;
    obj.correct_answer = correct_answer;
    obj.key_pressed = key_pressed;

    //question
    obj.questions_order = questions_order;
    obj.question_index = question_index;
    obj.question_condition = question_condition; //More or Fewer
    //texture
    obj.textures_order_for_question = textures_order_for_question; //note there are question0 and question1
    obj.texture_index = texture_index;
    obj.texture_condition = texture_condition; //Geometric, Iconic, or Color
    //trial
    obj.trial_number = trial_number; // Which trial in this condition (question+texture, e.g., More-Geo)

    return obj
}

function setProgressBar(page_number, id, page_total_number){
    let progress = page_number / page_total_number * 100
    let progressBar = document.getElementById("progress_bar_"+id);
    progressBar.style.width = `${progress}%`;
}