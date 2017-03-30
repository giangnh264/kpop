<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>CSKH AMUSIC</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/admin-new/css/customer.css" />
<?php
$this->pageLabel = Yii::t("admin", "Tra cứu Trạng thái freedata");
?>
<div class="search-form">
    <div class="filter form fft">
        <form action="" method="get" id="viewlog">
        	<input type="hidden" name="r" value="<?php echo $this->route?>">
            <div class="row">
                <input type="text" name="phone" value="<?php echo $msisdn ?>" size="80" />
                <input type="submit" value="Tìm" />
            </div>
        </form>
    </div>
</div>

<div style="clear: both;height: 20px;"></div>
<?php if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))): ?>
    <div class="box_content">
        <div class="sub_status" style="overflow: hidden;">
        	<table class="items" cellpadding="5" cellspacing="5" style="width: 50%; float: left;">
        			<tr> 
						<th align="right" style="padding: 5px" width="150">Số điện thoại</th>
						<td><?php echo $msisdn ?></td>
					</tr>
					<tr>
						<th align="right" style="padding: 5px">Tình trạng</th>
						<td><?php echo ($subscribe->status==1)?"Đang hoạt động":"Không hoạt động"?></td>
					</tr>
					<tr>
						<th align="right" style="padding: 5px">Gói dịch vụ</th>
						<td>
				            <?php if($subscribe){
				                $package = PackageModel::model()->findByPk($subscribe->package_id);
				                if($package) echo $package->name;
				            }?>
				        </td>
					</tr>
					<tr>
						<th align="right" style="padding: 5px">Ngày đăng ký gần nhất</th>
						<td><?php if($subscribe){echo $subscribe->last_subscribe_time;}?></td>
					</tr>
					<tr>
						<th align="right" style="padding: 5px">Ngày hết hạn</th>
						<td><?php if($subscribe){echo $subscribe->expired_time;}?></td>
					</tr>
				</table>
				
				<table class="items" cellpadding="5" cellspacing="5" style="width: 50%; float: left;">
				<?php foreach(@$freeDataStatus["cp_reply"] as $key=>$val):
				if(in_array($key, array("cp_id","cp_transaction_id","cpid","spid","aservret"))) continue;
				?> 
					<tr>
					<th align="right" style="padding: 5px" width="150"><?php echo $key?></th>
						<td><?php echo $val ?></td>
					</tr>
				<?php endforeach;?>
				</table>
				
        </div>
        <div ></div>
    </div>

<?php else: ?>
    <h3>Số điện thoại không hợp lệ hoặc không phải Mobifone.</h3>
<?php endif; ?>