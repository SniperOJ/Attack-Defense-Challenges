<?php  /* Template Name:侧栏模板 */  ?>
<?php  foreach ( $sidebar2 as $module) { ?>
<?php  include $this->GetTemplate('module');  ?>
<?php }   ?>