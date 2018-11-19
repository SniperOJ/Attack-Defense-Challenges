<?php  foreach ( $tags as $tag) { ?>
<li><a href="<?php  echo $tag->Url;  ?>"><?php  echo $tag->Name;  ?><span class="tag-count"> (<?php  echo $tag->Count;  ?>)</span></a></li>
<?php }   ?>