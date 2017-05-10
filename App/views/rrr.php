<?php
include "App/views/tpl/header.tpl";
echo $content_view[2];
?>
<br>
{TEXT}

<?php for($i=1;$i<=4;$i++){ ?>
<li>Menu Item <?php echo $content_view[$i] ?></li>
<?php }
include "App/views/tpl/footer.tpl";
?>