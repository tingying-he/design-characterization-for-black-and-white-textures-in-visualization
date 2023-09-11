<div class="row">
    <div class="col">
        <h2>Training Finished</h2>
        <p>You have finished the training, click the button below to start the real experiment. </p>
    </div>
</div>
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