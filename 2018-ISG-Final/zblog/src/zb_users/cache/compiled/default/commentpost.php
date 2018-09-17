<?php  /* Template Name:评论发布框 */  ?>
<div class="post" id="divCommentPost">
	<p class="posttop"><a name="comment"><?php if ($user->ID>0) { ?><?php  echo $user->StaticName;  ?><?php } ?><?php  echo $lang['default']['add_reply'];  ?>:</a><a rel="nofollow" id="cancel-reply" href="#divCommentPost" style="display:none;"><small><?php  echo $lang['default']['cancel_reply'];  ?></small></a></p>
	<form id="frmSumbit" target="_self" method="post" action="<?php  echo $article->CommentPostUrl;  ?>" >
	<input type="hidden" name="inpId" id="inpId" value="<?php  echo $article->ID;  ?>" />
	<input type="hidden" name="inpRevID" id="inpRevID" value="0" />
<?php if ($user->ID>0) { ?>
	<input type="hidden" name="inpName" id="inpName" value="<?php  echo $user->Name;  ?>" />
	<input type="hidden" name="inpEmail" id="inpEmail" value="<?php  echo $user->Email;  ?>" />
	<input type="hidden" name="inpHomePage" id="inpHomePage" value="<?php  echo $user->HomePage;  ?>" />
<?php }else{  ?>
	<p><input type="text" name="inpName" id="inpName" class="text" value="<?php  echo $user->Name;  ?>" size="28" tabindex="1" /> <label for="inpName"><?php  echo $lang['msg']['name'];  ?>(*)</label></p>
	<p><input type="text" name="inpEmail" id="inpEmail" class="text" value="<?php  echo $user->Email;  ?>" size="28" tabindex="2" /> <label for="inpEmail"><?php  echo $lang['msg']['email'];  ?></label></p>
	<p><input type="text" name="inpHomePage" id="inpHomePage" class="text" value="<?php  echo $user->HomePage;  ?>" size="28" tabindex="3" /> <label for="inpHomePage"><?php  echo $lang['msg']['homepage'];  ?></label></p>
<?php if ($option['ZC_COMMENT_VERIFY_ENABLE']) { ?>
	<p><input type="text" name="inpVerify" id="inpVerify" class="text" value="" size="28" tabindex="4" /> <label for="inpVerify"><?php  echo $lang['msg']['validcode'];  ?>(*)</label>
	<img style="width:<?php  echo $option['ZC_VERIFYCODE_WIDTH'];  ?>px;height:<?php  echo $option['ZC_VERIFYCODE_HEIGHT'];  ?>px;cursor:pointer;" src="<?php  echo $article->ValidCodeUrl;  ?>" alt="" title="" onclick="javascript:this.src='<?php  echo $article->ValidCodeUrl;  ?>&amp;tm='+Math.random();"/>
	</p>
<?php } ?>

<?php } ?>
	<p><label for="txaArticle"><?php  echo $lang['msg']['content'];  ?>(*)</label></p>
	<p><textarea name="txaArticle" id="txaArticle" class="text" cols="50" rows="4" tabindex="5" ></textarea></p>
	<p><input name="sumbit" type="submit" tabindex="6" value="提交" onclick="return zbp.comment.post()" class="button" /></p>
	</form>
	<p class="postbottom"><?php  echo $lang['default']['reply_notice'];  ?></p>
</div>