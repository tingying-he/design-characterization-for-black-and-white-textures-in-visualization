
    <div class="row">
        <div class="col">
            <div class="content">
                <h2>Background</h2>
                <div>
                    <p>
                        <b>1. What is your highest academic degree?</b>
                    </p>
                    <div>
                        <div>
                            <input type="radio"
                                   id="education_bachelor"
                                   name="participant_education"
                                   class="education_choice"
                                   value="bachelor"
                                   onclick = "getEducationValue(this)">
                            <label for="education_bachelor">Bachelor (or equivalent)</label>
                        </div>

                        <div>
                            <input type="radio"
                                   id="education_master"
                                   name="participant_education"
                                   class="education_choice"
                                   value="master"
                                   onclick = "getEducationValue(this)">
                            <label for="education_master">Master (or equivalent)</label>
                        </div>

                        <div>
                            <input type="radio"
                                   id="education_phd"
                                   name="participant_education"
                                   class="education_choice"
                                   value="phd"
                                   onclick = "getEducationValue(this)">
                            <label for="education_phd">PhD (or equivalent)</label>
                        </div>

                        <div>
                            <input type="radio"
                                   id="education_other"
                                   name="participant_education"
                                   class="education_choice"
                                   value="other"
                                   onclick = "getEducationValue(this)">
                            <label for="education_other">Other:</label>
                        </div>


                    </div>

                    <div id="participant_education_textarea" style="display: none">
                        <textarea name="participant_education"
                                  id="participant_education"
                                  class="education form-control"
                                  oninput="getEducationTextarea(this)"
                                  placeholder="Please enter your highest education level here."
                                  style="width:300px; text-align: center;" required autofocus=""></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    /* Variables to record education*/
    let education_answer = -1
    let education_answered = false//check whether education question is answered

    // Check if the gender question be answered
    $('.education_choice').on('input', function() {
        // education_answered = true;
        education_answer = $(this).val();
    });

</script>

<script type="text/javascript">

    /* Functions to check age and gender*/

    function getEducationValue(theRadio){
        let value  = theRadio.value;
        console.log('education value:'+value)

        if(value == "other"){
            document.getElementById("participant_education_textarea").style.display = "block";
            education_answer = $("#participant_education_textarea").val();
        }else{
            document.getElementById("participant_education_textarea").style.display = "none";
            education_answered = true;
            education_answer = value;
        }
        if (education_answered) $("#btn_<?php echo $id;?>").prop('disabled', false);
        console.log("education_answered: "+ education_answered);
        console.log("education_answer: "+ education_answer);
    }

    function getEducationTextarea(theText){
        if(theText.value){
            education_answered = true;
        }else{
            education_answered = false;
        }

        education_answer = theText.value;
        if (education_answered) $("#btn_<?php echo $id;?>").prop('disabled', false);

    }

    $('body').on('show', function(e, type){
        // console.log("show");
        if (type === '<?php echo $id;?>'){
            console.log("showing page " + type);

            let id = <?php echo json_encode($id); ?>;
            let page_number = <?php echo json_encode($page_number); ?>;
            setProgressBar(page_number, id, page_total_number)
        }
    });

    $('body').on('next', function(e, type){
        // console.log("next");
        if (type === '<?php echo $id;?>'){
            measurements['education'] = education_answer;
            console.log("logging education_answer: "+ measurements['education']);
        }
    });
</script>