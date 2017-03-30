<?php if($ccp):?>
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
            <th>Tổng lượt xem video</th>
            <th>Doanh thu xem video</th>
            <th>Tổng lượt tải video</th>
            <th>Doanh thu tải video</th>
            <th>Tổng doanh thu</th>
    	</tr>
    	
    	<?php
    		$total1 = 0; 
                $total_play = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total1_video = 0;
                $total2_video = 0;
                $total3_video = 0;
                $total4_video = 0;
                $total5 = 0;
                $total6 = 0;
                $total7 = 0;
    		foreach ($data as $ccprev):
    
    	?>
    	<tr>
    		<td><?php echo $ccprev['date']?></td>
    		<td><?php 
	    		$total_play = (isset($ccprev['played_count_nofree']))?$ccprev['played_count_nofree']:0;
	    		echo $total_play;
	    	?></td>
    		<td><?php 
    			$revenue_play = (isset($ccprev['total_revenue_play']))?$ccprev['total_revenue_play']:0;
	    		echo $revenue_play;
	    		?>
	    		</td>
    		
    		<td><?php 
    			$total_download = (isset($ccprev['downloaded_count_nofree']))?$ccprev['downloaded_count_nofree']:0;
    			echo $total_download?></td>
    		<td><?php 
    			$revenue_download = (isset($ccprev['total_revenue_download']))?$ccprev['total_revenue_download']:0;
	    		echo $revenue_download;
	    		?>
    		</td>
                <td><?php 
	    		$total_play_video = (isset($ccprev['played_count_nofree_video']))?$ccprev['played_count_nofree_video']:0;
	    		echo $total_play_video;
                    ?>
                </td>
    		<td><?php 
                        $revenue_play_video = (isset($ccprev['total_revenue_play_video']))?$ccprev['total_revenue_play_video']:0;
                        echo $revenue_play_video;
                    ?>
                </td>
                <td>
                    <?php 
    			$total_download_video = (isset($ccprev['downloaded_count_nofree_video']))?$ccprev['downloaded_count_nofree_video']:0;
    			echo $total_download_video;
                    ?>
                </td>
    		<td>
                    <?php 
    			$revenue_download_video = (isset($ccprev['total_revenue_download_video']))?$ccprev['total_revenue_download_video']:0;
	    		echo $revenue_download_video;
                    ?>
    		</td>
    		<td>
                    <?php 

    			$total_rev = ($revenue_download + $revenue_play) + ($revenue_download_video + $revenue_play_video);
                        echo $total_rev;			
                    ?>
                </td>
    	</tr>
    	<?php
		        $total1 += $total_play;
		        $total2 += $revenue_play;
		        $total3 += $total_download;
		        $total4 += $revenue_download;
                        $total1_video += $total_play_video;
		        $total2_video += $revenue_play_video;
		        $total3_video += $total_download_video;
		        $total4_video += $revenue_download_video;
		        $total5 += $total_rev;
    	 endforeach;?>
    	 <tr>
    	 		<td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total1_video; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total2_video; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total3_video; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total4_video; ?></td>
                <td style="background: #5ec411!important;"><?php echo number_format($total5, 2, ',', ' '); ?></td>
          </tr>    	
    </table>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>