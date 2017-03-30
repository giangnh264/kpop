<table id="list">
<?php if(!isset($_GET['sum'])):?><tr><td><b>Ngày</b></td><?php foreach ($arr_date as $date) { echo '<td><b>'.date('d/m',strtotime($date)).'</b></td>';}  ?></tr><?php endif;?>
<?php $packages = PackageModel::model()->findAll();?>
<?php foreach ($packages as $package ):?>
<tr><td><b>Gói <?php echo $package->code;?></b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Đăgn ký mới</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_subscribe_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>- Bị Hủy</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_bysystem_unsubscribe_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>- Chủ động Hủy</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_byme_unsubscribe_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>- Lũy kế thuê bao</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_luyke_package_'.$package->code].'</td>';}  ?></tr>
<tr><td>- Thuê bao có phát sinh giao dịch</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['_m_msisdn_psgd_package_'.$package->code].'</td>';}  ?></tr>
<?php endforeach;?>

</table>
