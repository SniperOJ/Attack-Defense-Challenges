<?php  foreach ( $comments as $comment) { ?>
<li><a href="<?php  echo $comment->Post->Url;  ?>#cmt<?php  echo $comment->ID;  ?>" title="<?php  echo htmlspecialchars($comment->Author->StaticName . ' @ ' . $comment->Time());  ?>"><?php  echo TransferHTML($comment->Content, '[noenter]');  ?></a></li>
<?php }   ?>