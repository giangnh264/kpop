<table width>
<tr><td colspan="3" style="background: #ccc"><h1>Thống kê báo cáo Đăng ký</h1></td></tr>
<tr><td colspan="3"><h3><?php echo Yii::t('admin', "Kỳ báo cáo: ".$_GET['songreport']['date'])?></h3></td></tr>
</table>
<table border="1">
    <?php if(!isset($_GET['sum'])):?><tr><td><b>Ngày</b></td><?php foreach ($arr_date as $date) { echo '<td><b>'.date('d/m',strtotime($date)).'</b></td>';}  ?></tr><?php endif;?>
<tr><td><b>Gói AM</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Tổng số thuê bao gia hạn AM</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_AM'].'</td>';}  ?></tr>
<tr><td>-Tổng số thuê bao gia hạn AM thất bại</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_khong_thanh_cong_AM'].'</td>';}  ?></tr>
<tr><td>-Tổng số thuê bao gia hạn AM thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_thanh_cong_AM'].'</td>';}  ?></tr>
<tr><td>+++Tổng số thuê bao gia hạn AM thành công đúng hạn</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_thanh_cong_dung_han_AM'].'</td>';}  ?></tr>
<tr><td>+++Tổng số thuê bao gia hạn AM thành công truy thu</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_thanh_cong_truy_thu_AM'].'</td>';}  ?></tr>

<tr><td><b>Gói AM7</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Tổng số thuê bao gia hạn AM7</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_AM7'].'</td>';}  ?></tr>
<tr><td>-Tổng số thuê bao gia hạn AM7 thất bại</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_khong_thanh_cong_AM7'].'</td>';}  ?></tr>
<tr><td>-Tổng số thuê bao gia hạn AM7 thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_thanh_cong_AM7'].'</td>';}  ?></tr>
<tr><td>+++Tổng số thuê bao gia hạn AM7 thành công đúng hạn</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_thanh_cong_dung_han_AM7'].'</td>';}  ?></tr>
<tr><td>+++Tổng số thuê bao gia hạn AM7 thành công truy thu</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_thanh_cong_truy_thu_AM7'].'</td>';}  ?></tr>

<tr><td><b>Tổng</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Tổng số thuê bao gia hạn cần gọi</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han'].'</td>';}  ?></tr>
<tr><td>-Tổng số thuê bao gia hạn thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_thanh_cong_trong_ngay'] .'</td>';}  ?></tr>
<tr><td>-Tổng số thuê bao gia hạn thất bại</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_khong_thanh_cong'].'</td>';}  ?></tr>
</table>
