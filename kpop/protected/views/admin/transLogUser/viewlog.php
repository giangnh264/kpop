<?php
$this->pageLabel = Yii::t("admin","Tra cứu log Thuê bao");
?>
<div class="search-form">
<div class="filter form">
	<form action="" method="get">
		<input type="hidden" value="transLogUser/viewLog" name="r">
		<div class="row">
		<label>SDT:</label>
			<input type="text" name="phone" value="<?php echo $phone ?>" size="80" />
		</div>
		 <div class="row">
            <label>Channel</label>
            <?php echo CHtml::dropDownList('channel',$channel, $this->channelList); ?>
        </div>
		<div class="row"><input type="submit" value="Tìm" /></div>
	</form>
</div>
</div>
<div style="clear: both;height: 20px;"></div>
<?php if($phone && Formatter::isPhoneNumber(Formatter::removePrefixPhone($phone))):?>
<h4>Thông tin thuê bao <?php echo $phone ?></h4>
<div class="grid-view">

<table class="items">
<thead>
	<tr>
		<th>Thuê bao</th>
		<th>Trạng thái Thuê bao</th>
		<th>Gói dịch vụ</th>
		<th>Ngày đăng ký</th>
		<th>Ngày hết hạn</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td><?php echo $phone ?></td>
		<td><?php echo ($subscribe->status==1)?"Đang hoạt động":"Không hoạt động"?></td>
		<td><?php if($subscribe){echo $subscribe->package_id;}?></td>
		<td><?php if($subscribe){echo $subscribe->created_time;}?></td>
		<td><?php if($subscribe){echo $subscribe->expired_time;}?></td>
	</tr>
</tbody>
</table>

</div>

<h4>Lịch sử đăng ký và hủy dịch vụ của thuê bao <b><?php echo $phone ?></b></h4>
<div>
<?php 
if(empty($channel)){
$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'log_dk_huy',
				'dataProvider'=>$modelDK->search(),
				'columns'=>array(
						'id',
						array(
							'header'=>'Số DT',
							'type'=>'raw',
							'value'=>'$data->user_phone',
						),
						'transaction',
						'channel',
						'obj1_id',
						'obj1_name',
						//'obj2_id',
						//'obj2_name',
						/* array(
							'header'=>'Sự kiện'
						), */
						array(
							'header'=>'Event',
							'type'=>'raw',
							'value'=>'($data->channel=="vinaphone")?$data->note:""',
						),
						'price',
						'return_code',
				        'created_time',
					),
				));

}else{
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'log_dk_huy',
		'dataProvider'=>$modelDKViNA->search(),
		'columns'=>array(
				'id',
				array(
						'header'=>'Số DT',
						'type'=>'raw',
						'value'=>'$data->msisdn_a',
				),
				'type',
				'application',
				'username',
				'clientip',
				'channel',
				'package_name',
				array(
						'header'=>'Event',
						'type'=>'raw',
						'value'=>'$data->note',
				),
				'error_id',
				'error_desc',
				'created_datetime',
		),
));
}
				?>
</div>
<h4>Lịch sử gia hạn của thuê bao <b><?php echo $phone ?></b></h4>
<div>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'log-gia-han',
				'dataProvider'=>$modelRenew->search(),
				'columns'=>array(
						'id',
						array(
							'header'=>'Số DT',
							'type'=>'raw',
							'value'=>'$data->user_phone',
						),
						'transaction',
						'channel',
						'obj1_id',
						'obj1_name',
						array(
							'header'=>'Event',
							'type'=>'raw',
							'value'=>'($data->channel=="vinaphone")?$data->note:""',
						),
						'price',
						'return_code',
				        'created_time',
					),
				));
				?>
</div>
<h4>Lịch sử mua và tặng nội dung của thuê bao <b><?php echo $phone ?></b></h4>
<div>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'log-content',
				'dataProvider'=>$modelContent->search(),
				'columns'=>array(
						'id',
						array(
							'header'=>'Số DT',
							'type'=>'raw',
							'value'=>'$data->user_phone',
						),
						'transaction',
						'channel',
						'obj1_id',
						'obj1_name',
						array(
							'header'=>'Event',
							'type'=>'raw',
							'value'=>'($data->channel=="vinaphone")?$data->note:""',
						),
						'price',
						'return_code',
				        'created_time',
					),
				));
				?>
</div>
<?php endif;?>