<?php if($ccp):?>
<div class="content-body grid-view">
    <div class="clearfix"></div>
    <table width="100%" class="items">
    	 <tr>
    		<th>Ngày</th>
    		<th colspan="2">Lượt nghe</th>
    		<th colspan="2">Lượt tải</th>
                <th colspan="2" style="background: #00376e!important;">Lượt xem video</th>
                <th colspan="2" style="background: #00376e!important;">Lượt tải video</th>
                <th colspan="2">Tổng (Nghe+Tải)Audio <br/> + (Xem+Tải)Video</th>
    		<th width="100">Doanh thu </th>
    	</tr>
    	<tr>
    		<th width="20" >Ngày</th>
    		<th width="20">Tổng lượt nghe CO</th>
    		<th width="20">Tổng lượt nghe</th>
    		<th width="20">Tổng lượt tải CO </th>
    		<th width="20">Tổng lượt tải</th>
                <th width="20" style="background: #00376e!important;">Tổng lượt xem CO</th>
    		<th width="20" style="background: #00376e!important;">Tổng lượt xem</th>
                <th width="20" style="background: #00376e!important;">Tổng lượt tải video CO </th>
    		<th width="20" style="background: #00376e!important;">Tổng lượt tải video</th>
    		<th width="45">Tổng Nghe+Xem+Tải CO </th>
    		<th width="45">Tổng Nghe+Xem+Tải</th>
    		<th colspan="3">Doanh thu Vega hưởng</th>
    		<!--
    		<th width="55">Số thuê bao trừ cước dịch vụ</th>
    		<th width="55">DT dịch vụ</th>
    		<?php if($copyrightType==0):?>
    		<th width="70">DT phân chia</th>
    		<?php else:?>
    		<th width="70">DT phân chia</th>
    		<?php endif;?>
    		-->
    	</tr>

    	<?php 
    		$total = 0;
                $total_play = 0;
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total_video1=0;
                $total_video2=0;
                $total_video3=0;
                $total_video4=0;
                $total5 = 0;
                $total6 = 0;
                $total7 = 0;
                $total8 = 0;
                $total9 = 0;
                $total10 = 0;
                if(!empty($data)):
    		foreach ($data as $ccprev):
				if(!is_array($ccprev)){
					$ccprev = array(
							'date'=>$ccprev,
							'played_count'=>0,
							'revenue_played'=>0,
							'downloaded_count'=>0,
							'revenue_download'=>0,
							'total_download'=>0,
							'total_download_free'=>0,
							'total_listen'=>0,
							'total_listen_free'=>0,
							'user_incurred_charge'=>0,
					);
				}
    	?>
    	<tr>
    		<td><?php echo $ccprev['date']?></td>
    		<td><?php $played_count = (isset($ccprev['played_count']))?$ccprev['played_count']:0; echo $played_count;?></td>
    		<td><?php $total_listen = (isset($ccprev['total_listen']))?$ccprev['total_listen']:0; echo $total_listen;?></td>
    		<td><?php $downloaded_count = (isset($ccprev['downloaded_count']))?$ccprev['downloaded_count']:0; echo $downloaded_count;?></td>
    		<td><?php $total_download = (isset($ccprev['total_download']))?$ccprev['total_download']:0; echo $total_download;?></td>
                <td><?php $played_count_video = (isset($ccprev['played_count_video']))?$ccprev['played_count_video']:0; echo $played_count_video;?></td>
    		<td><?php $total_listen_video = (isset($ccprev['total_listen_video']))?$ccprev['total_listen_video']:0; echo $total_listen_video;?></td>
                <td><?php $downloaded_count_video = (isset($ccprev['downloaded_count_video']))?$ccprev['downloaded_count_video']:0; echo $downloaded_count_video;?></td>
    		<td><?php $total_download_video = (isset($ccprev['total_download_video']))?$ccprev['total_download_video']:0; echo $total_download_video;?></td>
    		<td><?php
    		//Tổng Nghe+Xem+Tải CO
    			$co_listen_download = ($played_count+$downloaded_count + $played_count_video+$downloaded_count_video);
    			echo $co_listen_download?>
    		</td>
    		<td><?php 
    		//Tổng Nghe+Xem+Tải Vega
    		//echo ($total_download+$total_listen + $total_listen_video+$total_download_video)
    		if(isset($ssVega["{$ccprev['date']}"])){
    			echo $ssVegaTotalDay = $ssVega["{$ccprev['date']}"]['streaming_cp']+$ssVega["{$ccprev['date']}"]['download_cp'];
    		}else{
				echo $ssVegaTotalDay=0;
			}
    		?></td>
    		<td>
    		<?php 
    		if(isset($ssVega["{$ccprev['date']}"])){
				$rev = $ssVega["{$ccprev['date']}"];
				$revenueVega = (($rev['streaming_cp']+$rev['download_cp'])/($rev['total_streaming']+$rev['total_download']))*$revenuePackage["{$ccprev['date']}"]*0.3;
			}else{
				$revenueVega = 0;
			}
			echo number_format($revenueVega, 2, ',', ' ');
    		?>
    			
    		</td>
    		<!--
    		<td><?php 
	    		/* $user_incurred_charge = (isset($ccprev['user_incurred_charge']))?$ccprev['user_incurred_charge']:0; 
	    		echo $user_incurred_charge; */
	    		?>
    		</td>
    		<td>
    			<?php
					/* $package_price = 5000;
                    $rev_package = $user_incurred_charge * $package_price;
                    echo  number_format($rev_package, 2, ',', ' '); */
				?>
    		</td>
    		<td>
    		<?php
    		//$revenueShare = $co_listen_download/$ssVegaTotalDay*$rev_package*0.3;
    		//echo number_format($revenueShare, 2, ',', ' ');
    		?>
    		</td>
    		-->
    	</tr>
    	<?php
        $total1 += $played_count;
        $total2 += $total_listen;
        $total3 += $downloaded_count;
        $total4 += $total_download;
        $total_video1 += $played_count_video;
        $total_video2 += $total_listen_video;
        $total_video3 += $downloaded_count_video;
        $total_video4 += $total_download_video;
        $total5 += ($played_count + $downloaded_count) + ($played_count_video + $downloaded_count_video);
        $total6 += $ssVegaTotalDay;
        /*Doanh thu Vega huong*/
        $total7 += $revenueVega;
        /* $total7 += $user_incurred_charge;
        $total8 = $total8 + $rev_package;
        $total9 = $total9 + $revenueShare;
        $total10 = $total10 + $revenueShare; */

    	 endforeach;
    	 endif;
    	 ?>
    	 <tr>
    	 	<td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total_video1; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total_video2; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total_video3; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total_video4; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total5;?></td>
                <td style="background: #5ec411!important;"><?php echo $total6; ?></td>
                <td style="background: #5ec411!important;" colspan="3"><?php echo number_format($total7, 2, ',', ' ');?></td>
                <!-- <td style="background: #5ec411!important;"><?php //echo $total7; ?></td>
                <td style="background: #5ec411!important;"><?php //echo number_format($total8, 2, ',', ' ') ?></td>
                
                 <?php //if($copyrightType==0)://TQ?>
                 <td style="background: #5ec411!important;"><?php //echo number_format($total10, 2, ',', ' ') ?></td>
                 <?php //else:?>
                 <td style="background: #5ec411!important;"><?php //echo number_format($total9, 2, ',', ' ') ?></td>
                 <?php //endif;?>
                 -->
    	 </tr>

    </table>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>
