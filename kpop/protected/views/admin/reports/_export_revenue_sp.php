<?php 
if(count($data)>0):
$priceUnique = array_unique($price);
?>
<h1><?php echo $this->pageLabel;?></h1>
<div class="content-body grid-view">
    <div class="clearfix"></div>
    <table width="100%" class="items" border="1">
    	 <tr>
    		<th>Ngày</th>
    		<?php if(count($priceUnique)>0):?>
    		<?php foreach ($priceUnique as $value):
    				$k=0;
    		?>
    			<?php foreach ($price as $key => $item):?>
    					<?php if($item==$value){$k++;} ?>
    			<?php endforeach;?>
    		<th colspan="<?php echo $k;?>"><?php echo $value;?></th>
    		<?php endforeach;?>
    		<?php endif;?>
    	</tr>
    	<tr>
    		<th>#</th>
    		<?php if(count($priceUnique)>0):?>
    		<?php foreach ($priceUnique as $value):?>
    				<?php foreach ($price as $key => $item):?>
    					<?php if($item==$value): ?>
    					<th><?php 
    					if(strpos($key, $item)!==false){
    						 echo str_replace($item, '', $key);
    					}else{
							echo $key;
						}
    						 ?>
    					</th>
    					<?php endif;?>
    				<?php endforeach;?>
    		<?php endforeach;?>
    		<?php endif;?>
    	</tr>
    	<?php
		if(count($timeLabel)>0):
	    	foreach ($timeLabel as $key => $valueData):
		?>
				<?php if(is_array($valueData)):?>
			    	<tr>
			    		<td><?php echo $valueData['date'];?></td>
			    		<?php if(count($priceUnique)>0):?>
			    		<?php foreach ($priceUnique as $value):?>
			    				<?php foreach ($price as $key => $item):?>
			    					<?php if($item==$value): ?>
			    					<td><?php echo $valueData['total_'.$key.'_'.$value];?></td>
			    					<?php endif;?>
			    				<?php endforeach;?>
			    		<?php endforeach;?>
			    		<?php endif;?>
			    	</tr>
			    <?php else:?>
			    <tr>
			    		<td><?php echo $valueData;?></td>
			    		<?php if(count($priceUnique)>0):?>
			    		<?php foreach ($priceUnique as $value):?>
			    				<?php foreach ($price as $key => $item):?>
			    					<?php if($item==$value): ?>
			    					<td>0</td>
			    					<?php endif;?>
			    				<?php endforeach;?>
			    		<?php endforeach;?>
			    		<?php endif;?>
			    	</tr>
			    <?php endif;?>
	    <?php
	    	endforeach;
    	endif;
    	?>
    	<!-- Total -->
    	<tr>
    		<td>Tổng</td>
    		<?php if(count($priceUnique)>0):?>
    		<?php foreach ($priceUnique as $value):?>
    				<?php foreach ($price as $key => $item):?>
    					<?php if($item==$value): ?>
    					<td><?php echo $total['total_'.$key.'_'.$value];?></td>
    					<?php endif;?>
    				<?php endforeach;?>
    		<?php endforeach;?>
    		<?php endif;?>
    	</tr>
    	<?php
		/*if(count($data)>0):
	    	foreach ($data as $key => $valueData):
		?>
			    	<tr>
			    		<td><?php echo $valueData['date'];?></td>
			    		<?php if(count($priceUnique)>0):?>
			    		<?php foreach ($priceUnique as $value):?>
			    				<?php foreach ($price as $key => $item):?>
			    					<?php if($item==$value): ?>
			    					<td><?php echo $valueData['total_'.$key.'_'.$value];?></td>
			    					<?php endif;?>
			    				<?php endforeach;?>
			    		<?php endforeach;?>
			    		<?php endif;?>
			    	</tr>
	    <?php
	    	endforeach;
    	endif;*/
    	?>
  	</table>
</div>
<?php else:?>
<p>Không có dữ liệu</p>
 <?php endif;?>