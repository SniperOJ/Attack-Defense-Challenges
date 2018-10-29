<table id="tbCalendar">
    <caption><a href="<?php  echo $prevMonthUrl;  ?>">«</a>&nbsp;&nbsp;&nbsp;<a href="<?php  echo $nowMonthUrl;  ?>"><?php  echo $nowYear;  ?>年<?php  echo $nowMonth;  ?>月</a>&nbsp;&nbsp;&nbsp;<a href="<?php  echo $nextMonthUrl;  ?>">»</a></caption>
    <thead><tr><?php  for( $i = 1; $i <= 7; $i++) { ?> <th title="<?php  echo $lang['week'][$i];  ?>" scope="col"><small><?php  echo $lang['week_abbr'][$i];  ?></small></th><?php  }   ?></tr></thead>
    <tbody>
    <tr>
<?php 
$numberOfDays = date('t', strtotime($date));
$dayOfWeek = date('N', strtotime($date . '-1'));
$lastDayOfWeek = 7 - date('N', strtotime($date . '-' . $numberOfDays));
$dayOfWeekColspan = $dayOfWeek - 1;
$lastDayOfWeekColspan = $lastDayOfWeek - 1;
 ?>
<?php if ($dayOfWeek > 1) { ?><td class="pad" colspan="<?php  echo $dayOfWeekColspan;  ?>"></td><?php } ?>
<?php 
$weekCounter = $dayOfWeek - 1;
for ($i = 1; $i <= $numberOfDays; $i++) {
	 ?><td><?php if (isset($arraydate[$i])) { ?><a href="<?php  echo $arraydate[$i]['Url'];  ?>" title="<?php  echo $arraydate[$i]['Date'];  ?> (<?php  echo $arraydate[$i]['Count'];  ?>)" target="_blank"><?php  echo $i;  ?></a><?php }else{  ?><?php  echo $i;  ?><?php } ?></td><?php 
	$weekCounter++;
	if ($weekCounter % 7 == 0) {
     ?></tr><tr><?php 
    }
}
 ?>
<?php if ($lastDayOfWeek > 1) { ?><td class="pad" colspan="<?php  echo $lastDayOfWeekColspan;  ?>"> </td><?php } ?>
	</tr></tbody>
</table>