<?php
// Which trial is this under this condition? If $trial_number = 0, this is the first trial under this condition (e.g., bar geo fewer condition)
$trial_number = $page_number - $first_page_number;
?>
<div id="row">
    <div class="task-description" id="graph_box" style="height: 500px">

        <img style="width:500px" src="html/img/<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>.svg">


    </div>

    <hr>

    <div class="ratings cml_field">
        <p>To what extent do you agree or disagree with the following statement: This visualization is ___.</p>
        <div class="cml_row">

            <table>
                <thead>
                <tr>
                    <th></th>
                    <th class="likert">Strongly disagree</th>

                    <th class="likert">Disagree</th>

                    <th class="likert">Slightly disagree</th>

                    <th class="likert">Neutral</th>

                    <th class="likert">Slightly agree</th>

                    <th class="likert">Agree</th>

                    <th class="likert">Strongly agree</th>
                </tr>
                </thead>
                <tbody>

                <tr class="likert-row">
                    <td class="likert center-align" id="beauvis0_<?php echo $id;?>"></td>

                    <td class="likert"><input name="beauvis0" type="radio" value="1" class="beauvis0">
                    </td>

                    <td class="likert"><input name="beauvis0" type="radio" value="2" class="beauvis0">
                    </td>

                    <td class="likert"><input name="beauvis0" type="radio" value="3" class="beauvis0">
                    </td>

                    <td class="likert"><input name="beauvis0" type="radio" value="4" class="beauvis0">
                    </td>

                    <td class="likert"><input name="beauvis0" type="radio" value="5" class="beauvis0">
                    </td>

                    <td class="likert"><input name="beauvis0" type="radio" value="6" class="beauvis0">
                    </td>

                    <td class="likert"><input name="beauvis0" type="radio" value="7" class="beauvis0">
                    </td>
                </tr>
                <tr class="likert-row">
                    <td class="likert center-align" id="beauvis1_<?php echo $id;?>"></td>

                    <td class="likert"><input name="beauvis1" type="radio" value="1" class="beauvis1">
                    </td>

                    <td class="likert"><input name="beauvis1" type="radio" value="2" class="beauvis1">
                    </td>

                    <td class="likert"><input name="beauvis1" type="radio" value="3" class="beauvis1">
                    </td>

                    <td class="likert"><input name="beauvis1" type="radio" value="4" class="beauvis1">
                    </td>

                    <td class="likert"><input name="beauvis1" type="radio" value="5" class="beauvis1">
                    </td>

                    <td class="likert"><input name="beauvis1" type="radio" value="6" class="beauvis1">
                    </td>

                    <td class="likert"><input name="beauvis1" type="radio" value="7" class="beauvis1">
                    </td>
                </tr>
                <tr class="likert-row">
                    <td class="likert center-align" id="beauvis2_<?php echo $id;?>"></td>

                    <td class="likert"><input name="beauvis2" type="radio" value="1" class="beauvis2">
                    </td>

                    <td class="likert"><input name="beauvis2" type="radio" value="2" class="beauvis2">
                    </td>

                    <td class="likert"><input name="beauvis2" type="radio" value="3" class="beauvis2">
                    </td>

                    <td class="likert"><input name="beauvis2" type="radio" value="4" class="beauvis2">
                    </td>

                    <td class="likert"><input name="beauvis2" type="radio" value="5" class="beauvis2">
                    </td>

                    <td class="likert"><input name="beauvis2" type="radio" value="6" class="beauvis2">
                    </td>

                    <td class="likert"><input name="beauvis2" type="radio" value="7" class="beauvis2">
                    </td>
                </tr>
                <tr class="likert-row">
                    <td class="likert center-align" id="beauvis3_<?php echo $id;?>"></td>

                    <td class="likert"><input name="beauvis3" type="radio" value="1" class="beauvis3">
                    </td>

                    <td class="likert"><input name="beauvis3" type="radio" value="2" class="beauvis3">
                    </td>

                    <td class="likert"><input name="beauvis3" type="radio" value="3" class="beauvis3">
                    </td>

                    <td class="likert"><input name="beauvis3" type="radio" value="4" class="beauvis3">
                    </td>

                    <td class="likert"><input name="beauvis3" type="radio" value="5" class="beauvis3">
                    </td>

                    <td class="likert"><input name="beauvis3" type="radio" value="6" class="beauvis3">
                    </td>

                    <td class="likert"><input name="beauvis3" type="radio" value="7" class="beauvis3">
                    </td>
                </tr>
                <tr class="likert-row">
                    <td class="likert center-align" id="beauvis4_<?php echo $id;?>"></td>

                    <td class="likert"><input name="beauvis4" type="radio" value="1" class="beauvis4">
                    </td>

                    <td class="likert"><input name="beauvis4" type="radio" value="2" class="beauvis4">
                    </td>

                    <td class="likert"><input name="beauvis4" type="radio" value="3" class="beauvis4">
                    </td>

                    <td class="likert"><input name="beauvis4" type="radio" value="4" class="beauvis4">
                    </td>

                    <td class="likert"><input name="beauvis4" type="radio" value="5" class="beauvis4">
                    </td>

                    <td class="likert"><input name="beauvis4" type="radio" value="6" class="beauvis4">
                    </td>

                    <td class="likert"><input name="beauvis4" type="radio" value="7" class="beauvis4">
                    </td>
                </tr>
                <tr class="likert-row">
                    <td class="likert center-align">readable</td>

                    <td class="likert"><input name="readable" type="radio" value="1" class="readable">
                    </td>

                    <td class="likert"><input name="readable" type="radio" value="2" class="readable">
                    </td>

                    <td class="likert"><input name="readable" type="radio" value="3" class="readable">
                    </td>

                    <td class="likert"><input name="readable" type="radio" value="4" class="readable">
                    </td>

                    <td class="likert"><input name="readable" type="radio" value="5" class="readable">
                    </td>

                    <td class="likert"><input name="readable" type="radio" value="6" class="readable">
                    </td>

                    <td class="likert"><input name="readable" type="radio" value="7" class="readable">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>

    <script type="text/javascript">
        var readable_answer = -1; //we cannot use let here, because readability.php will repeat for 3 times
        var beauvis0_answer = -1;
        var beauvis1_answer = -1;
        var beauvis2_answer = -1;
        var beauvis3_answer = -1;
        var beauvis4_answer = -1;



        $('body').on('show', function(e, type){
            // console.log("show");
            if (type === '<?php echo $id;?>'){
                console.log("showing page " + type);
                //initialize answers
                measurements['readable_bar_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis0_bar_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis1_bar_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis2_bar_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis3_bar_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis4_bar_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";

                measurements['readable_pie_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis0_pie_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis1_pie_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis2_pie_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis3_pie_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";
                measurements['beauvis4_pie_<?php echo $textures_order_for_question1[$trial_number];?>'] = "";

                //shuffle BeauVis scale and write the randomized items to the scale

                let id = <?php echo json_encode($id); ?>;
                let page_number = <?php echo json_encode($page_number); ?>;
                setProgressBar(page_number, id, page_total_number)


                for (let i = beauvis.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [beauvis[i], beauvis[j]] = [beauvis[j], beauvis[i]];
                }
                for(let i = 0; i < beauvis.length; i++){
                    document.getElementById('beauvis'+i+'_<?php echo $id;?>').innerHTML = beauvis[i]
                }

                // make button active as soon as all questions are answered

                $('.readable').on('input', function() {

                    readable_answer = $(this).val();

                    if (isAnswered('readable') &&
                        isAnswered('beauvis0') &&
                        isAnswered('beauvis1') &&
                        isAnswered('beauvis2') &&
                        isAnswered('beauvis3') &&
                        isAnswered('beauvis4') ){
                        $("#btn_<?php echo $id;?>").prop('disabled', false);
                    }
                });

                $('.beauvis0').on('input', function() {

                    beauvis0_answer = $(this).val();

                    if (isAnswered('readable') &&
                        isAnswered('beauvis0') &&
                        isAnswered('beauvis1') &&
                        isAnswered('beauvis2') &&
                        isAnswered('beauvis3') &&
                        isAnswered('beauvis4') ){
                        $("#btn_<?php echo $id;?>").prop('disabled', false);
                    }
                });

                $('.beauvis1').on('input', function() {

                    beauvis1_answer = $(this).val();

                    if (isAnswered('readable') &&
                        isAnswered('beauvis0') &&
                        isAnswered('beauvis1') &&
                        isAnswered('beauvis2') &&
                        isAnswered('beauvis3') &&
                        isAnswered('beauvis4') ){
                        $("#btn_<?php echo $id;?>").prop('disabled', false);
                    }
                });

                $('.beauvis2').on('input', function() {

                    beauvis2_answer = $(this).val();

                    if (isAnswered('readable') &&
                        isAnswered('beauvis0') &&
                        isAnswered('beauvis1') &&
                        isAnswered('beauvis2') &&
                        isAnswered('beauvis3') &&
                        isAnswered('beauvis4') ){
                        $("#btn_<?php echo $id;?>").prop('disabled', false);
                    }
                });

                $('.beauvis3').on('input', function() {

                    beauvis3_answer = $(this).val();

                    if (isAnswered('readable') &&
                        isAnswered('beauvis0') &&
                        isAnswered('beauvis1') &&
                        isAnswered('beauvis2') &&
                        isAnswered('beauvis3') &&
                        isAnswered('beauvis4') ){
                        $("#btn_<?php echo $id;?>").prop('disabled', false);
                    }
                });

                $('.beauvis4').on('input', function() {

                    beauvis4_answer = $(this).val();

                    if (isAnswered('readable') &&
                        isAnswered('beauvis0') &&
                        isAnswered('beauvis1') &&
                        isAnswered('beauvis2') &&
                        isAnswered('beauvis3') &&
                        isAnswered('beauvis4') ){
                        $("#btn_<?php echo $id;?>").prop('disabled', false);
                    }
                });

            }
        });


        $('body').on('next', function(e, type){
            if (type === '<?php echo $id;?>'){

                measurements['readable_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>'] = readable_answer;
                measurements['beauvis0_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>'] = beauvis0_answer;
                measurements['beauvis1_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>'] = beauvis1_answer;
                measurements['beauvis2_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>'] = beauvis2_answer;
                measurements['beauvis3_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>'] = beauvis3_answer;
                measurements['beauvis4_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>'] = beauvis4_answer;
                console.log("logging readable_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>: " + readable_answer);
                console.log("logging beauvis0_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>: " + beauvis0_answer);
                console.log("logging beauvis1_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>: " + beauvis1_answer);
                console.log("logging beauvis2_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>: " + beauvis2_answer);
                console.log("logging beauvis3_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>: " + beauvis3_answer);
                console.log("logging beauvis4_<?php echo $condition;?>_<?php echo $textures_order_for_question1[$trial_number];?>: " + beauvis4_answer);
            }
        });


    </script>

</div>