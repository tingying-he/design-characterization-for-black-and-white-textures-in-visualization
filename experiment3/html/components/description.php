<div class="row">
    <div class="col">
        <h2>Instructions </h2>
        <p> In this section, you will see a chart that represents vegetables. Your task is to choose which of two  bars represents <strong><?php echo $questions_order[$question_index]; ?></strong> numbers of vegetables.
            <p>We measure both <b>speed</b> and <b>accuracy</b>. </p>

        <p>Here are the steps:</p>
        <p>1. When the trial starts you will see the two vegetables you need to compare and a question.</p>
        <p>2. Take a moment to look at the two items and the question, and put your fingers on the <b>left arrow key <img src="html/img/left_arrow_key_grey.png" style="height: 30px"></b> and <b>right arrow key </b><img src="html/img/right_arrow_key_grey.png" style="height: 30px"> of your keyboard to prepare .</p>
        <div class="row">
            <div class="col target d-flex flex-column align-items-center">
                <p style="margin-bottom: 10px">
                    <?php
                    if ($condition == 'bar') {
                        echo 'Carrot';
                    } elseif ($condition == 'pie') {
                        echo 'Olive';
                    }
                    ?>
                </p>
                <p ><img src="html/img/left_arrow_key_grey.png" style="height: 45px"></p>
            </div>
            <div class="col question d-flex flex-column align-items-center">
                Which has <?php echo $questions_order[$question_index]; ?>?
            </div>
            <div class="col target d-flex flex-column align-items-center">
                <p style="margin-bottom: 10px">
                    <?php
                    if ($condition == 'bar') {
                        echo 'Olive';
                    } elseif ($condition == 'pie') {
                        echo 'Carrot';
                    }
                    ?>
                </p>
                <p><img src="html/img/right_arrow_key_grey.png" style="height: 45px"></p>
            </div>
        </div>
        <p>3. Press the <b>space bar</b> <img src="html/img/space_key_grey.png" style="height: 30px"> on your keyboard to see the chart.</p>
        <p>4. You will then see a chart similar to the one shown in the image below. The chart has seven <?php
            if ($condition == "bar") {
                echo "bars";
            } else if ($condition == "pie") {
                echo "pie slices";
            }
            ?> representing quantities of vegetables, but only two <?php
            if ($condition == "bar") {
                echo "bars";
            } else if ($condition == "pie") {
                echo "pie slices";
            }
            ?> mentioning the vegetables at the top are relevant. The red marks on the chart below are just for illustration purposes.</p>

        <div class="col d-flex flex-column align-items-center">
            <img style="width:500px;" src="html/img/<?php echo $condition;?>_white_marked.svg">
        </div>

        <p>5. When you see the chart, click the Left Arrow Key or the Right Arrow Key to indicate the answer of the question according to the chart. <br>
            In this case, you should click the <b>"<?php
                if ($condition == 'bar') {
                    if ($questions_order[$question_index] == "FEWER") {
                        echo 'left arrow key <img src="html/img/left_arrow_key_grey.png" style="height: 30px">';
                    } else if ($questions_order[$question_index] == "MORE") {
                        echo 'right arrow key <img src="html/img/right_arrow_key_grey.png" style="height: 30px">';
                    }
                } elseif ($condition == 'pie') {
                    if ($questions_order[$question_index] == "FEWER") {
                        echo 'right arrow key <img src="html/img/right_arrow_key_grey.png" style="height: 30px">';
                    } else if ($questions_order[$question_index] == "MORE") {
                        echo 'left arrow key <img src="html/img/left_arrow_key_grey.png" style="height: 30px">';
                    }
                }

                ?>"</b> on your keyboard. Please give your answer as <b>quick</b> and <b>accurate</b> as possible.
        </p>
        <p>6. <b>The chart will only appear briefly</b>. You should give your answer before the chart disappears. </p>

    </div>
</div>