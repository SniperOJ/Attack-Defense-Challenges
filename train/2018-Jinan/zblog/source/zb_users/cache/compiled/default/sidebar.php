<?php  /* Template Name:侧栏模板 */  ?>
<?php  foreach ( $sidebar as $module) { ?>
<?php  include $this->GetTemplate('module');  ?>
<?php }   ?>