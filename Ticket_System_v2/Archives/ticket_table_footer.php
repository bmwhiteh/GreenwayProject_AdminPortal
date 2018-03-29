

<ul class="pagination">

     <?php for ($x = 1; $x <= $total_pages; $x++) {
        if($pageno == $x){
            $class = 'class="active"';
        }else{
            $class = '';
        }
       echo '<li> <a href="?pageno='.$x.'"'.$class.'>'.$x.'</a></li>';
    }?>

    
</ul>