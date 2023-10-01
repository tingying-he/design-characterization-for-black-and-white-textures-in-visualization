<!--<p>description_question1.php</p>-->

<?php
$question_index = 1;
$texture_index = 0;

// Which trial is this under this condition? If $trial_number = 0, this is the first trial under this condition (e.g., bar geo fewer condition)
$trial_number = $page_number - $first_page_number;

//echo 'question_condition: ' . $questions_order[$question_index]  . '<br>' .
//    'texture_condition: '.$textures_order_for_question0[$texture_index]. '<br>' .
//    $trial_number. 'trial of this condition';

//$current_stimulus_index = get_current_stimulus_index($question_index, $texture_index, $trial_number);
?>
<?php
include 'html/components/description.php'
?>

<script>
    $('body').on('show', function(e, type){
        // console.log("show");
        if (type === '<?php echo $id;?>'){
            console.log("showing page " + type);

            let id = <?php echo json_encode($id); ?>;
            let page_number = <?php echo json_encode($page_number); ?>;
            setProgressBar(page_number, id, page_total_number)

        }
    });


</script>