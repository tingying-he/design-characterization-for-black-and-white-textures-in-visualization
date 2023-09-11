<?php
function get_current_stimulus_index($question_index, $texture_index, $trial_number) {
    global $stimuli_order_geo, $stimuli_order_icon, $stimuli_order_color,
           $textures_order_for_question0, $textures_order_for_question1;

    //dynamic variable name: You can achieve this by constructing the variable name as a string, and then using the variable variable syntax $$
    $textures_order_for_question_var = 'textures_order_for_question' . $question_index;
    switch ($$textures_order_for_question_var[$texture_index]) {
        case 'geo':
            $current_stimulus_index = $stimuli_order_geo[$trial_number];
            break;
        case 'icon':
            $current_stimulus_index = $stimuli_order_icon[$trial_number];
            break;
        case 'color':
            $current_stimulus_index = $stimuli_order_color[$trial_number];
            break;
    }

    return $current_stimulus_index;
}