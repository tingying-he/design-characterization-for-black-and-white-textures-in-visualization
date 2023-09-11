<div class="row">
    <div class="col">
        <h2>Rating Charts</h2>
        <p>In this section, you will be asked to rate the <b>aesthetics</b> and <b>readability</b> of three types of chart fillings that you have used in the previous sections.</p>
        <p>Please note that the rating is related to the use of chart fillings in general and NOT to the specific data in the chart.</p>
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