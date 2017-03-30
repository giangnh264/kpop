<?php if($data):?>
<div class="content-body grid-view">
    <div class="clearfix"></div>
    <table width="100%" class="items">
    	<!-- <tr>
    		<th>Ngày</th>
    		<th colspan="2">Lượt nghe</th>
    		<th colspan="2">Lượt tải</th>
    		<th colspan="2">Tổng Nghe+Tải</th>
    		<th>Doanh thu thuê bao</th>
    		<th>Doanh thu CP</th>
    	</tr>-->
    	<tr>
    		<th>Ngày</th>
    		<th>Tổng lượt nghe</th>
    		<th>Doanh thu nghe</th>
    		<th>Tổng lượt tải</th>
    		<th>Doanh thu tải</th>
    		<th>Tổng doanh thu</th>
			<th>Doanh thu phân chia</th>
    	</tr>
    	
    	<?php
    		$total = 0; 
                $total_play = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total5 = 0;
                $total6 = 0;
                $total7 = 0;
    		foreach ($data as $ccprev):
    
    	?>
    	<tr>
    		<td><?php echo $ccprev['date']?></td>
    		<td><?php 
	    		$total_play = $ccprev['played_count_nofree'];
	    		echo $total_play;
	    	?></td>
    		<td><?php 
    			$revenue_play = $ccprev['total_revenue_play'];
	    		echo $revenue_play;
	    		?>
	    		</td>
    		
    		<td><?php 
    			$total_download = $ccprev['downloaded_count_nofree'];
    			echo $total_download?></td>
    		<td><?php 
    			$revenue_download = $ccprev['total_revenue_download'];
	    		echo $revenue_download;
	    		?>
    		</td>
    		<td><?php 

    			$total_rev = $revenue_download + $revenue_play;
				echo $total_rev;			
    			?>
    			</td>
    		<td><?php echo $total_campuchia = round($total_rev*$perc/100,2);?></td>
    	</tr>
    	<?php
		        $total1 += $total_play;
		        $total2 += $revenue_play;
		        $total3 += $total_download;
		        $total4 += $revenue_download;
		        $total5 += $total_rev;
		        $total6 += $total_campuchia;
    	 endforeach;?>
    	 <tr>
    	 		<td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
                <td style="background: #5ec411!important;"><?php echo number_format($total5, 2, ',', ' '); ?></td>
                <td style="background: #5ec411!important;"><?php echo $total6; ?></td>
          </tr>
    	
    </table>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>
