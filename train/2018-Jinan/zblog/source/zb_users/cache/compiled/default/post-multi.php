<?php  /* Template Name:列表页普通文章 */  ?>
<div class="post multi">
	<h4 class="post-date"><?php  echo $article->Time();  ?></h4>
	<h2 class="post-title"><a href="<?php  echo $article->Url;  ?>"><?php  echo $article->Title;  ?></a></h2>
	<div class="post-body"><?php  echo $article->Intro;  ?></div>
	<h5 class="post-tags"></h5>
	<h6 class="post-footer">
		<?php  echo $lang['msg']['author'];  ?>:<?php  echo $article->Author->StaticName;  ?> | <?php  echo $lang['msg']['category'];  ?>:<?php  echo $article->Category->Name;  ?> | <?php  echo $lang['default']['view'];  ?>:<?php  echo $article->ViewNums;  ?> | <?php  echo $lang['msg']['comment'];  ?>:<?php  echo $article->CommNums;  ?>
	</h6>
</div>