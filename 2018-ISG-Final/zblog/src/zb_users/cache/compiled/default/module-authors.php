<?php  foreach ( $authors as $author) { ?>
<li><a href="<?php  echo $author->Url;  ?>"><?php  echo $author->Name;  ?><span class="article-nums"> (<?php  echo $author->Articles;  ?>)</span></a></li>
<?php }   ?>
