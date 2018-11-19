<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<div id="avatardesigner">
<div id="avatarfileselector">
<input type="file" name="Filedata" id="avatarfile" accept="image/*" />
</div>
<div id="avataradjuster">
<img id="avatarimage" style="visibility: hidden;" onload="forceSelectorInsideAvatar();" />
<canvas id="avatarcanvas" style="position: absolute; top: 0px; left: 0px;"></canvas>
<div id="widgetparent" style="position: absolute; left: 0px; top: 0px;">
<div id="selector" class='ui-widget-content' style="position: absolute; width: 120px; height: 120px; overflow:hidden; cursor: move; border: 1px solid lightgrey; background-color: transparent; background-image: none;">
</div>
</div>

<div class="backfileselectiondiv">
<input type="button" name="backfileselection" class="backfileselection" value="Select File" onclick="showAvatarFileSelector();" />
</div>

<div id="slider" style="height: 0px; position: absolute; right: 9px; top: 105px; width: 100px;"></div>

<div class="saveAvatardiv">
<input type="submit" name="confirm" value="确定" class="saveAvatar" style="" onclick="saveAvatar();" />
</div>

<input type="hidden" id="avatar1" name="avatar1" />
<input type="hidden" id="avatar2" name="avatar2" />
<input type="hidden" id="avatar3" name="avatar3" />
</div>
<div id="avatardisplayer">
<canvas id="avatardisplaycanvas"></canvas>

<div class="finishbuttondiv">
<input type="button" value="完成" class="finishbutton" onclick="location.reload(true);" />
</div>
</div>
</div>														

<script src="<?php echo STATICURL;?>js/mobile/jquery.min.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script type="text/javascript">
jQuery.noConflict();
var data = "<?php echo implode(",", $uc_avatarflash);; ?>".split(',');
</script>

<link rel="stylesheet" href="<?php echo STATICURL;?>avatar/avatar.css?<?php echo VERHASH;?>" />							
<script src="<?php echo STATICURL;?>avatar/jquery-ui.min.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script src="<?php echo STATICURL;?>avatar/avatar.js?<?php echo VERHASH;?>" type="text/javascript"></script>

<iframe name="uploadframe" id="uploadframe" style="display: none;"></iframe>
<iframe name="rectframe" id="rectframe" style="display: none;"></iframe>