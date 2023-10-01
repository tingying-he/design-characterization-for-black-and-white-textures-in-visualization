<div class="content">
    <div id = "thankyou_div_1" >
        <h2>Feedback</h2>
        <p>Do you have any comment about the study, for example concerning the clarity of the instructions or technical issues you might have experienced? (optional)</p>
        <div>
            <textarea class="form-control" id="general_comments" rows="4" cols="80" placeholder="Feel free to leave it blank, if you don't have any comment :)" style="width: 1100px;"></textarea><br>
            <input type="button" value="Submit and Get Paid" id = "thankyou_btn"  class="btn btn-success">
        </div>
    </div>

    <div id = "thankyou_div_2" style="display: none;">
        <h2>Thank you!</h2>
        <p>You have completed the experiment. Thanks a lot!</p>

        <p>Click <a href="https://app.prolific.co/submissions/complete?cc=CDR2RKQG" target="_BLANK"><strong>here</strong></a> to report your task completion to the Prolific system. </p>

        <p>Now you can close the tab. If you have any questions or general comments, do not hesitate to contact us:</p>

        <div align="justify" style="max-width: 100%; display: flex; margin-left: auto; margin-right: auto;">
            <div align="justify" style="max-width: 30%; display: block; margin-left: 0; margin-right: auto;">
                <p><strong>Tingying He</strong></p>

                <p>PhD Student</p>

                <p><a href="https://www.aviz.fr/Main/HomePage" target="_blank">AVIZ</a> Research Team</p>

                <p>Université Paris-Saclay</p>

                <p><a href="mailto:tingying.he@inria.fr?cc=petra.isenberg@inria.fr,tobias.isenberg@inria.fr&amp;subject=%5BTexture%20Design%5D%20Question%20about%20the%20experiment1">tingying.he@inria.fr</a></p>
            </div>

            <div align="justify" style="max-width: 30%; display: block; margin-left: 0; margin-right: auto;">
                <p><strong>Petra Isenberg</strong></p>

                <p>Senior Research Scientist</p>

                <p><a href="https://www.aviz.fr/Main/HomePage" target="_blank">AVIZ</a> Research Team</p>

                <p>Inria Saclay Île-de-France</p>

                <p><a href="mailto:petra.isenberg@inria.fr?cc=tingying.he@inria.fr,tobias.isenberg@inria.fr&amp;subject=%5BTexture%20Design%5D%20Question%20about%20the%20experiment1">petra.isenberg@inria.fr</a></p>
            </div>

            <div align="justify" style="max-width: 30%; display: block; margin-left: 0; margin-right: auto;">
                <p><strong><a href="https://tobias.isenberg.cc/" target="_blank">Tobias Isenberg</a></strong></p>

                <p>Senior Research Scientist</p>

                <p><a href="https://www.aviz.fr/Main/HomePage" target="_blank">AVIZ</a> Research Team</p>

                <p>Inria Saclay Île-de-France</p>

                <p><a href="mailto:tobias.isenberg@inria.fr?cc=tingying.he@inria.fr,petra.isenberg@inria.fr&amp;subject=%5BTexture%20Design%5D%20Question%20about%20the%20experiment1">tobias.isenberg@inria.fr</a></p>
            </div>
        </div>
    </div>






</div>
<script>
    //hide next button
    document.addEventListener("DOMContentLoaded", function(){
        let nextBtn = document.getElementById("btn_<?php echo $id;?>");
        nextBtn.style.display = 'none';
    });

    document.getElementById('thankyou_btn').onclick = function (){
        // Get comments
        measurements['optionalComments'] = '"'+ $("#general_comments").val()+ '"';
        // Send comments
        $.ajax({
            url: 'html/ajax/measurements.php', //path to the script who handles this
            type: 'POST',
            data: JSON.stringify(measurements),
            contentType: 'application/json',
            async: false, // Make the request synchronous
            success: function (data) {
                console.log('success')
            }
        })
        // Hide the div 1
        document.getElementById("thankyou_div_1").style.display = 'none';
        // Display the div 2
        document.getElementById("thankyou_div_2").style.display = 'block';

        //when the end.php page shows, trigger logging
        $('body').trigger('finished');
    }


    // let trial_measure
    //$('body').on('show', function(e, type){
    //    // console.log("show");
    //    if (type === '<?php //echo $id;?>//') {
    //        console.log("showing page " + type);
    //        //send the measurements to server
    //        $.ajax({
    //            url: 'html/ajax/measurements.php', //path to the script who handles this
    //            type: 'POST',
    //            data: JSON.stringify(measurements),
    //            contentType: 'application/json',
    //            async: false, // Make the request synchronous
    //            success: function (data) {
    //                console.log('success')
    //            }
    //        })
    //
    //
    //    }
    //});


</script>

