<style>
table.slpp{
	background: #f1f1f1;
}
table.slpp tr:hover td{
	background: #99F099;
}
table.slpp td{
	background: #FFF;
	padding: 5px;
}
</style>
<?php if($songList):?>
<div class="ul-files success">
<table class="slpp" width="100%">
<tr><td>Song Id</td><td>Song name</td><td>#</td></tr>
<?php foreach ($songList as $value):?>
<tr><td><?php echo $value->song_id;?></td><td><?php echo $value->song->name;?></td><td><a href="javascript:void(0);" onclick="removeItem(<?php echo $value->id;?>)">Xóa</a></td></tr>
<?php endforeach;?>
</table>
</div>
<?php endif;?>