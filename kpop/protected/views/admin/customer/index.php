
<?php
Yii::import('application.components.common.Utility');
$js = Yii::app()->clientScript;
$js->registerScriptFile(Yii::app()->request->baseUrl . '/js/admin/base.js', CClientScript::POS_END);

?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/admin-new/css/customer.css" />
<div class="search-form">
<div class="filter form fft">
	<form action="" method="get" id="viewlog">
		<input type="hidden" value="customer/index" name="r">
		<div class="row">
		<label>Số điện thoại:</label>
			<input type="text" name="phone" value="<?php echo $msisdn ?>" size="80" /><input type="submit" value="Tìm" />
		</div>
	</form>
</div>
</div>
    <div class="grid-view" id="menu-grid">       
        <b>Gói AMUSIC</b><br/>
        <table class="items">
            <thead>
                <tr>
                    <th style="width: 130px;"><?php echo Yii::t('admin_customer', 'Số điện thoại'); ?></th>
                    <th style="width: 100px;"><?php echo Yii::t('admin_customer', 'Trạng thái'); ?></th>
                    <th style="width: 100px;"><?php echo Yii::t('admin_customer', 'Gói cước'); ?></th>
                    <th style="width: 60px;">Gia hạn</th>
                    <th style="width: 100px;">Kênh đăng ký</th>
                    <th style="width: 150px;"><?php echo Yii::t('admin_customer', 'Thời gian đăng ký'); ?></th>
                    <th style="width: 150px;"><?php echo Yii::t('admin_customer', 'Thời gian hết hạn'); ?></th>
                    <th style="width: 150px;"><?php echo Yii::t('admin_customer', 'Hành động'); ?></th>
                </tr>
            </thead>
        <tbody>
        <?php if (!empty($subscribe)) { ?>
            <tr class="odd">
                <?php $package_code = AdminPackageModel::model()->findbyPk($subscribe->package_id)->name;?>
                <td><?php echo $subscribe->user_phone; ?></td>
                <td><?php echo ($subscribe->status == 1) ? Yii::t('admin_customer', 'Có gói cước') : Yii::t('admin_customer', 'Chưa đăng ký'); ?></td>
                <td><?php echo $package_code;?></td>
                <td><?php echo $subscribe->status == 1 ? 'Có' : 'Không';?></td>
                <td><?php echo (strpos($subscribe->event, "BIGTET_2016") !== false) ? 'BIGTET2016':$subscribe->source;?></td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($subscribe->created_time)); ?></td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($subscribe->expired_time)); ?></td>
                <td>

                    <a href="javascript:;" onclick="popupPackage()" class="tbl-button">
                        <?php if($subscribe->status == 1):?>
                            <b>Hủy đăng ký</b>
                        <?php else:?>
                            <b>Đăng ký</b>
                        <?php endif;?>
                    </a>
                </td>
            </tr>
        <?php } elseif($msisdn != 0) { ?>
            <tr>
                <td colspan="7"><?php echo Yii::t('admin', 'No match result'); ?></td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="7"><?php echo Yii::t('admin', 'No match result'); ?></td>
            </tr>
        <?php } ?>
        </tbody>
        </table>      
    </div>
<script>
    function popupPackage(){
        $("#dialog").dialog("open");
    }
</script>
<?php
if($subscribe->status == 1){
    include_once '_popupUnRegister.php';

}else{
    include_once '_popupRegister.php';
}
?>