 <?php
     $max_width_card = 300;
    $max_height_card = 300;
    
    //Caculate the new dimension
    $original_width = 4128;
    $original_height = 2322;
    
    $scale_card = min($max_width_card/$original_width, $max_height_card/$original_height); echo $scale_card. "\n";
    $new_width_card = ceil($scale_card*$original_width); echo $original_width. "=".$new_width_card. "\n";
    $new_height_card= ceil($scale_card*$original_height);echo $original_height. "=>".$new_height_card. "\n";
?>
        