<?php  $i = $maxLi;  ?><?php  $j = 0;  ?><?php  $s = '';  ?>
<?php if ($style==2) { ?>
    <?php  foreach ( $catalogs as $catalog) { ?>
        <?php if ($catalog->Level == 0) { ?>
            <?php  $s = $s . '<li class="li-cate"><a href="' . $catalog->Url . '">' . $catalog->Name . '</a><!--' . $catalog->ID . 'begin--><!--' . $catalog->ID . 'end--></li>';  ?>
        <?php } ?>
    <?php }   ?>

    <?php  for( $i = 1; $i <= 3; $i++) { ?> 
        <?php  foreach ( $catalogs as $catalog) { ?>
            <?php if ($catalog->Level == $i) { ?>
                <?php  $s = str_replace('<!--' . $catalog->ParentID . 'end-->', '<li class="li-subcate"><a href="' . $catalog->Url . '">' . $catalog->Name . '</a><!--' . $catalog->ID . 'begin--><!--' . $catalog->ID . 'end--></li><!--' . $catalog->ParentID . 'end-->', $s);  ?>
            <?php } ?>
        <?php }   ?>
    <?php  }   ?>

    <?php  foreach ( $catalogs as $catalog) { ?>
        <?php  $s = str_replace('<!--' . $catalog->ID . 'begin--><!--' . $catalog->ID . 'end-->', '', $s);  ?>
    <?php }   ?>
    <?php  foreach ( $catalogs as $catalog) { ?>
        <?php  $s = str_replace('<!--' . $catalog->ID . 'begin-->', '<ul class="ul-subcates">', $s);  ?>
        <?php  $s = str_replace('<!--' . $catalog->ID . 'end-->', '</ul>', $s);  ?>
    <?php }   ?>
    <?php ob_clean() ?><?php  echo $s;  ?>
<?php }elseif($style==1) {  ?>
<?php  foreach ( $catalogs as $catalog) { ?>
<li><?php  echo $catalog->Symbol;  ?><a href="<?php  echo $catalog->Url;  ?>"><?php  echo $catalog->Name;  ?></a></li>
<?php  $j =$j + 1;  ?>
<?php if ($i != 0 && $j >= $i) { ?>
<?php break; ?>
<?php } ?>
<?php }   ?>
<?php }else{  ?>
<?php  foreach ( $catalogs as $catalog) { ?>
<li><a href="<?php  echo $catalog->Url;  ?>"><?php  echo $catalog->Name;  ?></a></li>
<?php  $j =$j + 1;  ?>
<?php if ($i != 0 && $j >= $i) { ?>
    <?php break; ?>
<?php } ?>
<?php }   ?>
<?php } ?>