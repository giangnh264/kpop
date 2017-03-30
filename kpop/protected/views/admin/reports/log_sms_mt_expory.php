<table id="list">
	<?php if(!isset($_GET['sum'])):?><tr><td><b>Ngày</b></td><?php foreach ($arr_date as $date) { echo '<td><b>'.date('d/m',strtotime($date)).'</b></td>';}  ?></tr><?php endif;?>
	<tr><td><b>Thuê bao</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
	<tr><td>Tổng số sms cần gửi</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms gửi thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_success'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms gửi không thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_fail'].'</td>';}  ?></tr>
	<tr><td><b>Gói ngày</b></td></tr>
	<tr><td>Tổng số sms cho thuê bao ngày cần gửi</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_a1'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao ngày thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_success_a1'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao ngày không thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_fail_a1'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao ngày định kỳ 3 ngày</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_3day_a1'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao ngày định kỳ 3 ngày thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_3day_success_a1'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao ngày định kỳ 15 ngày</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_15day_a1'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao ngày định kỳ 15 ngày thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_15day_success_a1'].'</td>';}  ?></tr>

	<tr><td><b>Gói tuần</b></td></tr>
	<tr><td>Tổng số sms cho thuê bao tuần cần gửi</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_a7'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao tuần thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_success_a7'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao tuần không thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_fail_a7'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao tuần định kỳ 3 ngày</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_3day_a7'].'</td>';}  ?></tr>
	<tr><td>Tổng số sms cho thuê bao tuần định kỳ 3 ngày thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['sms_mt_weekly_3day_success_a7'].'</td>';}  ?></tr>

</table>
