<?php 
ini_set('memory_limit', '1024M');
ini_set("pcre.backtrack_limit", "5000000");
ini_set('max_execution_time', -1); ?>
<style>
table{
    width: 100% !important;
}

/*.border{
    border: 2px solid black;
}*/

.hr_line{
    margin: 5px 0px;
    color: black;
}

.break { page-break-before: always; } 
.break_after { page-break-before: none; } 

</style>
  
<!--  -->
<div class="container-fluid border_full">
    <div class="row">
        <div class="">
           
            <?php
            foreach($print_barcode as $print) {
                if ($print !== "." && $print !== "..") {?>                    
                    <img style="margin-top:20px;" src="application/cache/<?php echo $print?>" width="16%" height="90px" />
               <?php }?>
               
               <?php }?>
            </a>
        

        </div>
    </div>
</div>









