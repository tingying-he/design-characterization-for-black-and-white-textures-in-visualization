<div class="row">
    <div class="col">
        <h2>Get Familiar with the Chart</h2>
        <p>In the following section, you will see a chart similar to the one shown in the image below. </p>
        <p>Kindly spend a few moments viewing this chart and acquaint yourself with the connection between the chart's shading patterns and the corresponding vegetables.</p>
        <div class="col d-flex flex-column align-items-center">
            <?php
            if ($question_index == 0) {
                echo '<img style="margin-top: -50px;" src="html/img/'.$condition.'_'.$textures_order_for_question0[$texture_index].'.svg">';
            } elseif ($question_index == 1) {
                echo '<img style="margin-top: -50px;" src="html/img/'.$condition.'_'.$textures_order_for_question1[$texture_index].'.svg">';
            } else {
                echo 'Invalid question index.';
            }
            ?>
        </div>
        <p>Once you are comfortable, please click the "Next" button to proceed to the training session.</p>
    </div>
</div>