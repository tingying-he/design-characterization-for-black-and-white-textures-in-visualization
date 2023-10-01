<?php
$question_index = 1;
$texture_index = 2;

include 'html/components/learning.php';
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