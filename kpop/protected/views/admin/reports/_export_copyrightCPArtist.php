<?php if($data):?>
<style>
table tr td{
	padding: 4px;
}
</style>
<div class="content-body grid-view">
    <div class="clearfix"></div>
    <table width="100%" class="items">
    	 <tr>
    		<th width="30">Ngày</th>
    		<th colspan="2">Lượt nghe</th>
    		<th colspan="2">Lượt tải</th>
    		<th colspan="2">Tổng Nghe+Tải</th>
    		<th></th>
    		<th colspan="2">Doanh thu </th>
    	</tr>
    	<tr>
    		<th width="30" >Ngày</th>
    		<th width="30">Tổng lượt nghe CO</th>
    		<th width="30">Tổng lượt nghe </th>
    		<th width="30">Tổng lượt tải CO </th>
    		<th width="30">Tổng lượt tải</th>
    		<th width="50">Tổng Nghe+Tải CO </th>
    		<th width="50">Tổng Nghe+Tải</th>
    		<th width="60">Số thuê bao trừ cước dịch vụ</th>
    		<th width="60">DT dịch vụ</th>
    		<th width="70">DT phân chia</th>
    	</tr>

    	<?php
    			$total = 0;
                $total_play = 0;
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
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
							'user_incurred_charge'=>0
					);
				}
    	?>
    	<tr>
    		<td><?php echo $ccprev['date']?></td>
    		<td><?php echo $ccprev['played_count']?></td>
    		<td><?php echo $ccprev['total_listen']?></td>
    		<td><?php echo $ccprev['downloaded_count']?></td>
    		<td><?php echo $ccprev['total_download']?></td>
    		<td><?php
    			$co_listen_download = ($ccprev['played_count']+$ccprev['downloaded_count']);
    			echo $co_listen_download?>
    		</td>
    		<td><?php echo ($ccprev['total_download']+$ccprev['total_listen'])?></td>
    		<td><?php echo $ccprev['user_incurred_charge']?></td>
    		<td>
    			<?php
    				$package_price = 5000;
    				$rev_share = 30/100;
    				$download_play_ccp = $ccprev['played_count'] + $ccprev['downloaded_count'];
    				$rev_package = $ccprev['user_incurred_charge'] * $package_price * $rev_share;
    				echo  number_format($rev_package, 2, ',', ' ');
    				?>
    		</td>
    		<td>
    		<?php
    		$total_dl_pl = ($ccprev['total_download']+$ccprev['total_listen']);
    		$rev_cc_co=0;
			$total_dl_pl = ($total_dl_pl<=0)?1:$total_dl_pl;
			$rev_co = ($rev_package * $download_play_ccp)/$total_dl_pl;
			echo  number_format($rev_co, 2, ',', ' ');
    		?>
    		</td>
    	</tr>
    	<?php
        $total1 += $ccprev['played_count'];
        $total2 += $ccprev['total_listen'];
        $total3 += $ccprev['downloaded_count'];
        $total4 += $ccprev['total_download'];
        $total5 += ($ccprev['played_count'] + $ccprev['downloaded_count']);
        $total6 += ($ccprev['total_listen'] + $ccprev['total_download']);
        $total7 += $ccprev['user_incurred_charge'];
        $total8 = $total8 + $rev_package;
        $total9 = $total9 + $rev_co;
        $total10 = $total10 + $rev_cc_co;

    	 endforeach;
    	 endif;
    	 ?>
    	 <tr>
    	 	<td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total5;?></td>
                <td style="background: #5ec411!important;"><?php echo $total6; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total7; ?></td>
                <td style="background: #5ec411!important;"><?php echo number_format($total8, 2, ',', ' ') ?></td>
                <td style="background: #5ec411!important;"><?php echo number_format($total9, 2, ',', ' ') ?></td>
    	 </tr>

    </table>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>
