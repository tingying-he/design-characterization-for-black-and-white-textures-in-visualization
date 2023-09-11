<div class="row">
  <div class="col">
      <h1>Chart Performance</h1>
      <p>The content of this page will be set on the Prolific.</p>


<!--      <p>Click "Next" to proceed to the informed consent.</p>-->
  </div>
</div>

<script>
    $('body').on('show', function(e, type){
        // console.log("show");
        if (type === '<?php echo $id;?>'){
            console.log("showing page " + type);


            document.getElementById('progress_bar_<?php echo $id;?>').style.display = 'none';


        }
    });
</script>