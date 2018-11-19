<?php  foreach ( $urls as $url) { ?>
<li><a href="<?php  echo $url->Url;  ?>"><?php  echo $url->Name;  ?> (<?php  echo $url->Count;  ?>)</a></li>
<?php }   ?>