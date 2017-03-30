<table width>
<tr><td colspan="3" style="background: #ccc"><h1>Thống kê báo cáo Đăng ký</h1></td></tr>
<tr><td colspan="3"><h3><?php echo Yii::t('admin', "Kỳ báo cáo: ".$_GET['songreport']['date'])?></h3></td></tr>
</table>
<table border="1">
<?php if(!isset($_GET['sum'])):?><tr><td><b>Ngày</b></td><?php foreach ($arr_date as $date) { echo '<td><b>'.date('d/m',strtotime($date)).'</b></td>';}  ?></tr><?php endif;?>
    <tr><td><b>Đăng ký</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td><b>Gói A1</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>Web</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_web'].'</td>';}  ?></tr>
    <tr><td>Sms</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_sms'].'</td>';}  ?></tr>
    <tr><td>Wap</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_wap'].'</td>';}  ?></tr>
    <tr><td>App Android</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_api_android'].'</td>';}  ?></tr>
    <tr><td>App IOS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_api-ios'].'</td>';}  ?></tr>
    <tr><td>App Windows Phone</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1_qua_window-phone'].'</td>';}  ?></tr>
    <tr><td><b>Tổng A1</b></td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A1'].'</td>';}  ?></tr>

    <tr><td><b>Gói A7</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>Web</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_web'].'</td>';}  ?></tr>
    <tr><td>Sms</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_sms'].'</td>';}  ?></tr>
    <tr><td>Wap</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_wap'].'</td>';}  ?></tr>
    <tr><td>App Android</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_api_android'].'</td>';}  ?></tr>
    <tr><td>App IOS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_api-ios'].'</td>';}  ?></tr>
    <tr><td>App Windows Phone</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7_qua_window-phone'].'</td>';}  ?></tr>
    <tr><td><b>Tổng A7</b></td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki_goi_A7'].'</td>';}  ?></tr>
    <tr><td><b>Tổng Đăng ký</b></td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_ki'].'</td>';}  ?></tr>

    <tr><td><b></b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td><b>Hủy</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td><b>Gói A1</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>Sms</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_huy_dang_ki_goi_A1_qua_sms'].'</td>';}  ?></tr>
    <tr><td><b>Gói A7</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>Sms</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_huy_dang_ki_goi_A7_qua_sms'].'</td>';}  ?></tr>
</table>
