<?php  foreach ( $articles as $article) { ?>
<li><a href="<?php  echo $article->Url;  ?>"><?php  echo $article->Title;  ?></a></li>
<?php }   ?>