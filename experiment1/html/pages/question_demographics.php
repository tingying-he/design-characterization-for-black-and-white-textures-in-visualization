<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Background</title>

    <script type="text/javascript" src="../lib/jquery.min.js"></script>

    <link rel="stylesheet" href="../lib/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="texture_style.css">

    <script src="../tools/loading.js"></script>

    <script type = "text/javascript" >
        //when you click the back button of the browser, this script prevent you from going bac
        function preventBack(){window.history.forward();}
        setTimeout("preventBack()", 0);
        window.onunload=function(){null};
    </script>

    <style>

        .demographics_question {
            margin-bottom: 25px;
        }

    </style>
</head>
<body>
<div class="container textContent">
    <div class="row">
        <div class="col">
            <div class="content">
                <h2>Background</h2>
                <div class="demographics_question">
                    <p>
                        <b>1. Which gender do you identify with?</b>
                    </p>
                    <div>
                        <div>
                            <input type="radio"
                                   id="self_gender_identify_woman"
                                   name="self_gender_identify"
                                   class="self_gender_identify"
                                   value="woman"
                                   onclick = "getGenderValue(this)">
                            <label for="self_gender_identify_woman">Woman</label>
                        </div>

                        <div>
                            <input type="radio"
                                   id="self_gender_identify_man"
                                   name="self_gender_identify"
                                   class="self_gender_identify"
                                   value="man"
                                   onclick = "getGenderValue(this)">
                            <label for="self_gender_identify_man">Man</label>
                        </div>

                        <div>
                            <input type="radio"
                                   id="self_gender_identify_non_binary"
                                   name="self_gender_identify"
                                   class="self_gender_identify"
                                   value="non_binary"
                                   onclick = "getGenderValue(this)">
                            <label for="self_gender_identify_non_binary">Non-binary</label>
                        </div>


                        <div>
                            <input type="radio"
                                   id="self_gender_identify_not_disclose"
                                   name="self_gender_identify"
                                   class="self_gender_identify"
                                   value="perfer_not_to_disclose"
                                   onclick = "getGenderValue(this)">
                            <label for="self_gender_identify_not_disclose">Prefer not to disclose</label>
                        </div>

                        <div>
                            <input type="radio"
                                   id="self_gender_identify_self_describe"
                                   name="self_gender_identify"
                                   class="self_gender_identify"
                                   value="prefer_to_self_describe"
                                   onclick = "getGenderValue(this)">
                            <label for="self_gender_identify_self_describe">Prefer to self describe</label>
                        </div>


                    </div>

                    <div class="demographics_question" id="participant_gender_textarea" style="display: none">
                        <textarea name="participant_gender"
                          id="participant_gender"
                          class="self_gender_identify form-control"
                          oninput="getGenderTextarea(this)"
                          placeholder="Please enter your gender identity here."
                          style="width:300px; text-align: center;" required autofocus=""></textarea>
                    </div>
                </div>

                <div>
                    <p>
                        <b>2. What is your age?</b>
                    </p>
                    <div class="demographics_question" id="participant_age_textarea">
                        <input type="number"
                               id="participant_age"
                               name="participant_age"
                        >
                    </div>
                </div>

                <div>
                    <p>
                        <b>3. For how many years have you worked or studied in the field of visualization design?</b>
                    </p>
                    <div class="demographics_question" id="design_experience_textarea">
                        <input type="number"
                               id="design_experience"
                               name="design_experience"
                        >
                    </div>
                </div>

                <button id="background_next_btn" class="btn btn-primary float-end" disabled>Next</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let nextBtn = document.getElementById('background_next_btn')

    let measurements = JSON.parse(localStorage.getItem('measurements'))

    /* Variables to record gender and experience*/
    let gender_answer = -1
    let gender_answered = false//check whether gender question is answered

    let age_answer = -1
    let age_answered = false//check whether gender question is answered

    let experience_answer = -1
    let experience_answered = false//check whether experience question is answered

    // Check if the gender question be answered
    $('.self_gender_identify').on('input', function() {
        // gender_answered = true;
        gender_answer = $(this).val();


        if (experience_answered && gender_answered && age_answered){
            nextBtn.disabled = false
        }else{
            nextBtn.disabled = true
        }
    });

    // Check if the age question be answered
    $('#participant_age').on('input', function() {
        if($(this).val()){
            age_answered = true
        }else{
            age_answered = false
        }

        age_answer = $(this).val()

        //Year of experience must be greater than 0
        if(parseFloat($(this).val() )< 0){
            age_answered = false
            alert('Please enter a non-negative number here.')
        }


        if (experience_answered && gender_answered && age_answered){
            nextBtn.disabled = false
        }else{
            nextBtn.disabled = true
        }

        console.log('experience_answer:'+experience_answer)
    });


    // Check if the experience question be answered
    $('#design_experience').on('input', function() {

        if($(this).val()){
            experience_answered = true
        }else{
            experience_answered = false
        }

        experience_answer = $(this).val()

        //Year of experience must be greater than 0
        if(parseFloat($(this).val() )< 0){
            experience_answered = false
            alert('Please enter a non-negative number here.')
        }


        if (experience_answered && gender_answered && age_answered){
            nextBtn.disabled = false
        }else{
            nextBtn.disabled = true
        }

        console.log('experience_answer:'+experience_answer)
    });

</script>

<script type="text/javascript">

    /* Functions to check age and gender*/

    function getGenderValue(theRadio){
        let value  = theRadio.value;
        console.log('value:'+value)

        if(value == "prefer_to_self_describe"){
            document.getElementById("participant_gender_textarea").style.display = "block";
            gender_answer = $("#participant_gender_textarea").val();
        }else{
            document.getElementById("participant_gender_textarea").style.display = "none";
            gender_answered = true;
            gender_answer = value;
        }
        console.log("gender_answered: "+ gender_answered);
        console.log("gender_answer: "+ gender_answer);
    }

    function getGenderTextarea(theText){
        if(theText.value){
            gender_answered = true;
        }else{
            gender_answered = false;
        }

        gender_answer = theText.value;
        console.log("gender_answer: "+ gender_answer);
    }

    document.getElementById('background_next_btn').onclick = function (){
        measurements['gender'] = gender_answer
        measurements['age'] = age_answer
        measurements['experience'] = experience_answer

        localStorage.setItem('measurements', JSON.stringify(measurements))

        window.location.href = 'description.php';
    }
</script>

</body>
</html>


