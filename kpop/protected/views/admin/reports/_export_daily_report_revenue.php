<table id="list">
<?php if(!isset($_GET['sum'])):?><tr><td><b>Ngày</b></td><?php foreach ($arr_date as $date) { echo '<td><b>'.date('d/m',strtotime($date)).'</b></td>';}  ?></tr><?php endif;?>
    <tr><td><b>Gói A1</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>- Doanh thu đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['doanh_thu_dang_ky_moi_A1'].'</td>';}  ?></tr>
    <tr><td>- Doanh thu gia hạn</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['doanh_thu_gia_han_dich_vu_A1'].'</td>';}  ?></tr>
    <tr><td>- Doanh thu truy thu</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['doanh_thu_truy_thu_dich_vu_A1'].'</td>';}  ?></tr>
    <tr><td>-Tổng doanh thu A1</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_doanh_thu_A1'].'</td>';}  ?></tr>
    <tr><td><b>Gói A7</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>- Doanh thu đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['doanh_thu_dang_ky_moi_A7'].'</td>';}  ?></tr>
    <tr><td>- Doanh thu gia hạn</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['doanh_thu_gia_han_dich_vu_A7'].'</td>';}  ?></tr>
    <tr><td>- Doanh thu truy thu</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['doanh_thu_truy_thu_dich_vu_A7'].'</td>';}  ?></tr>
    <tr><td>-Tổng doanh thu A7</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_doanh_thu_A7'].'</td>';}  ?></tr>
    <tr><td><b>-Tổng doanh thu</b></td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_doanh_thu'].'</td>';}  ?></tr>

</table>