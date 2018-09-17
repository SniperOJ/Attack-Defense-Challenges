<?php  /* Template Name:文章页文章内容 */  ?>
<div class="post single">
	<h4 class="post-date"><?php  echo $article->Time();  ?></h4>
	<h2 class="post-title"><?php  echo $article->Title;  ?></h2>
	<div class="post-body"><?php  echo $article->Content;  ?></div>
	<h5 class="post-tags"></h5>
	<h6 class="post-footer">
		<?php  echo $lang['msg']['author'];  ?>:<?php  echo $article->Author->StaticName;  ?> | <?php  echo $lang['msg']['category'];  ?>:<?php  echo $article->Category->Name;  ?> | <?php  echo $lang['default']['view'];  ?>:<?php  echo $article->ViewNums;  ?> | <?php  echo $lang['msg']['comment'];  ?>:<?php  echo $article->CommNums;  ?>
	</h6>
</div>

<?php if (!$article->IsLock) { ?>
<?php  include $this->GetTemplate('comments');  ?>
<?php } ?>