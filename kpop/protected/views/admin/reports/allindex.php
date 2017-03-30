<div class="content-body grid-view">
<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>
    <div class="fl">        
        <div class="row created_time">
            <?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?>
            <?php
            $this->widget('ext.daterangepicker.input', array(
                'name' => 'songreport[date]',
                'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
            ));
            ?>
        </div>
    </div>
    <div class="" style="float:left">
        <p style="width:100%;float: left;padding: 10px 0;">
            <input type="checkbox" name="sum" id="sum" value="" style="float:left"/> 
            <label for="sum" style="width:auto;margin-top: 4px;">Tính tổng các ngày (Không hiển thị chi tiết theo ngày)</label>
        </p>
        <?php echo CHtml::submitButton('Search'); ?>
        <?php echo CHtml::resetButton('Reset') ?>
        <?php echo CHtml::submitButton('Export', array('name'=>'Export', 'value'=>'Export')) ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->    
<style>
	table#list tr:hover td,
	table#list tr.actived td{
		background: #F5DB1D!important;
		font-weight: bold;
	}
    .popdiv{ left: 0;
    overflow: scroll;margin-top: 20px;
    position: absolute;
    width: 100%;}
    #showp{float:right;position: relative;z-index: 1000;}
    
</style>
<script>
    /**
     * Comment
     */
    var click = 0;
    function showfull() {
        click++;
        $("#list").toggleClass('popdiv');
        var text = (click % 2 ==0)?'Hiển thị đầy đủ':'Hiển thị rút gọn';
        $("#showp a").html(text);
        console.log(click);        
    }
</script>
<p><b>
<?php echo Yii::t('admin', "Kỳ báo cáo: ".$_GET['songreport']['date'])?>
<br><br>
Tiêu chí đánh giá</b>
</p>
<?php if(count($arr_res)>9):?><p id="showp"><a href="javascript:void(0)" onclick="showfull()">Hiển thị đầy đủ</a></p><?php endif;?>
<div style="overflow: auto; clear: both">
<table id="list">
<?php if(!isset($_GET['sum'])):?><tr><td><b>Ngày</b></td><?php foreach ($arr_date as $date) { echo '<td><b>'.date('d/m',strtotime($date)).'</b></td>';}  ?></tr><?php endif;?>
<tr><td><b>Thuê bao</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Tổng số thuê bao hiện tại</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_hien_tai'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao sử dụng gói cước tuần A7</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_kich_hoat_A7'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao sử dụng gói cước ngày A1</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_dang_kich_hoat_A1'].'</td>';}  ?></tr>

<tr><td><b>Đăng ký</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Tổng số lượt đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_luot_dang_ky'].'</td>';}  ?></tr>
<tr><td>- Số lượt đăng ký gói tuần (A7)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_luot_dang_ky_am7'].'</td>';}  ?></tr>
<tr><td>- Số lượt đăng ký gói ngày (A1)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_luot_dang_ky_am1'].'</td>';}  ?></tr>
<tr><td>Số thuê bao đăng ký thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_dk_thanh_cong'].'</td>';}  ?></tr>

<tr><td>Số thuê bao đăng ký thành công theo từng kênh</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số thuê bao đăng ký thành công qua website</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_dang_ky_thanh_cong_qua_web'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đăng ký thành công qua SMS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_dang_ky_thanh_cong_qua_sms'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đăng ký thành công qua wapsite</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_dang_ky_thanh_cong_qua_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đăng ký thành công qua ứng dụng</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_dang_ky_thanh_cong_qua_app'].'</td>';}  ?></tr>
<tr><td>+ Số thuê bao đăng ký thành công qua điện thoại Android</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_dang_ky_thanh_cong_qua_app_mobile_android'].'</td>';}  ?></tr>
<tr><td>+ Số thuê bao đăng ký thành công qua điện thoại iOS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_dang_ky_thanh_cong_qua_app_mobile_ios'].'</td>';}  ?></tr>

<tr><td>Số lượt đăng ký không thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_dk_ko_thanh_cong'].'</td>';}  ?></tr>
<tr><td>- Số lượt đăng ký không thành công do đã có tài khoản</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_dk_ko_thanh_cong_da_co_tai_khoan'].'</td>';}  ?></tr>
<tr><td>- Số lượt đăng ký không thành công do không trừ được tiền</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_dk_ko_thanh_cong_ko_tru_duoc_tien'].'</td>';}  ?></tr>

<tr><td><b>Hủy đăng ký</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Tổng số thuê bao hủy đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_huy_dich_vu'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao tự hủy</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_tu_huy'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao bị hủy do không trừ được cước</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_huy_khong_tru_duoc_cuoc'].'</td>';}  ?></tr>
<tr><td>Số thuê bao hủy theo từng kênh</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số thuê bao hủy qua website</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_tu_huy_qua_web'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao hủy qua SMS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_tu_huy_qua_sms'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao hủy qua wapsite</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_tu_huy_qua_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao hủy qua ứng dụng</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_tu_huy_qua_app'].'</td>';}  ?></tr>
<tr><td>+ Số thuê bao hủy qua điện thoại Android</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_tu_huy_qua_phone_android'].'</td>';}  ?></tr>
<tr><td>+ Số thuê bao hủy qua điện thoại iOS</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_tu_huy_qua_phone_ios'].'</td>';}  ?></tr>

<tr><td><b>Trừ cước thuê bao tháng</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số thuê bao đến kì gia hạn</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_can_gia_han'].'</td>';}  ?></tr>
<tr><td>Số thuê bao cần truy thu cước (nợ cước)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_can_truy_thu_cuoc'].'</td>';}  ?></tr>
<tr><td>Số thuê bao cần thu cước (đúng hạn + nợ cước)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_can_thu_cuoc'].'</td>';}  ?></tr>
<tr><td>Số thuê bao trừ được cước đúng hạn</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_gia_han_thanh_cong'].'</td>';}  ?></tr>
<!-- <tr><td>Số thuê bao truy thu cước thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_truy_thu_cuoc_thanh_cong'].'</td>';}  ?></tr>-->
<tr><td>Tỉ lệ trừ cước đúng hạn thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['ti_le_tru_cuoc_dung_han_thanh_cong'].'%</td>';}  ?></tr>
<!--<tr><td>Tỉ lệ truy thu cước thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['ti_le_truy_thu_cuoc_thanh_cong'].'</td>';}  ?></tr>-->
<tr><td>Tỉ lệ truy thu cước thành công</td><?php foreach ($arr_res as $result) { echo '<td>'.(round($result['so_thue_bao_gia_han_thanh_cong']/$result['so_thue_bao_can_thu_cuoc'],2)*100).'%</td>';}  ?></tr>

<tr><td><b>Hoạt động của khách hàng trên wapsite dịch vụ</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số lượt truy cập vào wapsite dịch vụ</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_luot_truy_cap_wap'].'</td>';}  ?></tr>
<tr><td>- Số lượt thuê bao truy cập (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_luot_truy_cap_wap_da_dang_ki'].'</td>';}  ?></tr>
<tr><td>- Số lượt khách vãng lai truy cập (chưa đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_luot_truy_cap_wap_chua_dang_ki'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao truy cập wapsite</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_truy_cap_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ truy cập wapsite</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_truy_cap_wap_da_dang_ki'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ truy cập wapsite</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_truy_cap_wap_chua_dang_ki'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ truy cập dịch vụ</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Tỉ lệ thuê bao chưa đăng kí dịch vụ truy cập wapsite/Tổng số thuê bao truy cập wapsite</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['msisdn_chua_dk___tong_so_luot_truy_cap_wap'].'%</td>';}  ?></tr>
<tr><td>- Tỉ lệ thuê bao đã đăng kí dịch vụ truy cập wapsite/Tổng số thuê bao đã đăng ký dịch vụ</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['msisdn_da_dk_truy_cap___tong_so_msisdn_da_dk_tren_wap'].'%</td>';}  ?></tr>
<!-- nghe bai hat -->
<tr><td>Số lượt nghe bài hát</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số lượt nghe bài hát theo tình trạng đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số lượt nghe bài hát được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_nghe_tren_wap_tb_dang_ky'].'</td>';}  ?></tr>
<tr><td>- Số lượt nghe bài hát được thực hiện bởi khách vãng lai (chưa đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_nghe_tren_wap_tb_mac_dinh'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao nghe bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_nghe_bai_hat_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ nghe bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dk_nghe_bai_hat_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ nghe bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_chua_dk_nghe_bai_hat_tren_wap'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ trung bình nghe bài hát</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số bài hát được nghe trung bình/1 thuê bao chưa đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_duoc_nghe_tren_wap___msisdn_chua_dk'].'</td>';}  ?></tr>
<tr><td>- Số bài hát được nghe trung bình/1 thuê bao đã đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_duoc_nghe_tren_wap___msisdn_da_dk'].'</td>';}  ?></tr>
<tr><td>- Số bài hát được nghe trung bình/1 thuê bao có hoạt động nghe</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_duoc_nghe_tren_wap___msisdn_co_nghe_bai_hat'].'</td>';}  ?></tr>
<!-- xem video -->
<tr><td>Số lượt xem video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số lượt xem video theo tình trạng đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số lượt xem video được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tb_dang_ky_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số lượt xem video được thực hiện bởi khách vãng lai (chưa đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tb_mac_dinh_tren_wap'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao xem video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_xem_video_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ xem video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dk_xem_video_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ xem video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_chua_dk_xem_video_tren_wap'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ trung bình xem video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số video được xem trung bình/1 thuê bao chưa đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.(isset($result['so_video_trung_binh_duoc_xem_thuebao_chua_dk'])?$result['so_video_trung_binh_duoc_xem_thuebao_chua_dk']:0).'</td>';}  ?></tr>
<tr><td>- Số video được xem trung bình/1 thuê bao đã đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tren_wap___msisdn_da_dk'].'</td>';}  ?></tr>
<tr><td>- Số video được xem trung bình/1 thuê bao có hoạt động nghe</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tren_wap___msisdn_co_nghe_video'].'</td>';}  ?></tr>
<!-- tai bai hat -->
<tr><td>Số lượt tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_download_bai_hat_wap'].'</td>';}  ?></tr>
<tr><td>Số lượt tải bài hát theo tình trạng đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số lượt tải bài hát được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_download_bai_hat_tb_dang_ky_tren_wap'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_tai_bai_hat_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dang_ky_tai_bai_hat_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_mac_dinh_tai_bh_tren_wap'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ trung bình tải bài hát</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số bài hát được tải trung bình/1 thuê bao đã đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_download___msisdn_da_dk_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số bài hát được tải trung bình/1 thuê bao có hoạt động tải</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_download___msisdn_co_download_bai_hat_tren_wap'].'</td>';}  ?></tr>
<!-- tai video -->
<tr><td>Số lượt tải video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số lượt tải video theo trạng thái đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số lượt tải video được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_download_video_tb_dang_ky_tren_wap'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao tải video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_download_video_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ tải video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dang_ky_tai_video_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ tải video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_mac_dinh_tai_video_tren_wap'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ trung bình tải video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số video được tải trung bình/1 thuê bao chưa đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_video_download___msisdn_chua_dk_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số video được tải trung bình/1 thuê bao đã đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_video_download___msisdn_da_dk_tren_wap'].'</td>';}  ?></tr>
<tr><td>- Số video được tải trung bình/1 thuê bao có hoạt động tải</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_video_download___msisdn_co_download_video_tren_wap'].'</td>';}  ?></tr>
<!-- download nội dung-->
<tr><td>-Tỷ lệ download các loại nội dung </td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>--	Số lượt download bài hát</td></tr>
<tr><td>--	Số lượt download video</td></tr>
    <!-- playlist -->
<tr><td>Số playlist mới được tạo trên wapsite</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_playlist_tao_tren_wap'].'</td>';}  ?></tr>
<tr><td>Số thuê bao tạo playlist</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_msisdn_tao_playlist_tren_wap'].'</td>';}  ?></tr>
<tr><td>Số playlist được tạo trung bình/1 thuê bao </td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_playlist_duoc_tao__msisdn'].'</td>';}  ?></tr>

    <!-- app client -->
<tr><td><b>Hoạt động của khách hàng trên app</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số lượt truy cập vào app</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_luot_truy_cap_app'].'</td>';}  ?></tr>
<tr><td>- Số lượt thuê bao truy cập (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_luot_truy_cap_app_da_dang_ki'].'</td>';}  ?></tr>
<tr><td>- Số lượt khách vãng lai truy cập (chưa đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_luot_truy_cap_app_chua_dang_ki'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao truy cập app</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_truy_cap_app'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ truy cập app</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_truy_cap_app_da_dang_ki'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ truy cập app</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_truy_cap_app_chua_dang_ki'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ truy cập dịch vụ</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Tỉ lệ thuê bao đã đăng kí dịch vụ truy cập app/Tổng số thuê bao truy cập app</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['msisdn_da_dk___tong_so_luot_truy_cap_app'].'</td>';}  ?></tr>
<tr><td>- Tỉ lệ thuê bao chưa đăng kí dịch vụ truy cập app/Tổng số thuê bao truy cập app</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['msisdn_chua_dk___tong_so_luot_truy_cap_app'].'</td>';}  ?></tr>
<tr><td>- Tỉ lệ thuê bao đã đăng kí dịch vụ truy cập app/Tổng số thuê bao đã đăng ký dịch vụ</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['msisdn_da_dk_truy_cap___tong_so_msisdn_da_dk_tren_app'].'</td>';}  ?></tr>

<tr><td>Số lượt nghe bài hát</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số lượt nghe bài hát theo tình trạng đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số lượt nghe bài hát được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_nghe_tren_app_tb_dang_ky'].'</td>';}  ?></tr>
<tr><td>- Số lượt nghe bài hát được thực hiện bởi khách vãng lai (chưa đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_nghe_tren_app_tb_mac_dinh'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao nghe bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_nghe_bai_hat_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ nghe bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dk_nghe_bai_hat_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ nghe bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_chua_dk_nghe_bai_hat_tren_app'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ trung bình nghe bài hát</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số bài hát được nghe trung bình/1 thuê bao chưa đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_duoc_nghe_tren_app___msisdn_chua_dk'].'</td>';}  ?></tr>
<tr><td>- Số bài hát được nghe trung bình/1 thuê bao đã đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_duoc_nghe_tren_app___msisdn_da_dk'].'</td>';}  ?></tr>
<tr><td>- Số bài hát được nghe trung bình/1 thuê bao có hoạt động nghe</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_duoc_nghe_tren_app___msisdn_co_nghe_bai_hat'].'</td>';}  ?></tr>
<tr><td>Số lượt xem video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số lượt xem video theo tình trạng đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số lượt xem video được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tb_dang_ky_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số lượt xem video được thực hiện bởi khách vãng lai (chưa đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tb_mac_dinh_tren_app'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao xem video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_xem_video_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ xem video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dk_xem_video_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ xem video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_chua_dk_xem_video_tren_app'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ trung bình xem video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số video được xem trung bình/1 thuê bao chưa đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_chua_dk_xem_video_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số video được xem trung bình/1 thuê bao đã đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tren_app___msisdn_da_dk'].'</td>';}  ?></tr>
<tr><td>- Số video được xem trung bình/1 thuê bao có hoạt động nghe</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tren_app___msisdn_co_nghe_video'].'</td>';}  ?></tr>
<tr><td>Số lượt tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_download_bai_hat_app'].'</td>';}  ?></tr>
<tr><td>Số lượt tải bài hát theo tình trạng đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số lượt tải bài hát được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_download_bai_hat_tb_dang_ky_tren_app'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_tai_bai_hat_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dang_ky_tai_bai_hat_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_mac_dinh_tai_bh_tren_app'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ trung bình tải bài hát</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số bài hát được tải trung bình/1 thuê bao đã đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_download___msisdn_da_dk_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số bài hát được tải trung bình/1 thuê bao có hoạt động tải</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_bai_hat_download___msisdn_co_download_bai_hat_tren_app'].'</td>';}  ?></tr>
<tr><td>Số lượt tải video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số lượt tải video theo trạng thái đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số lượt tải video được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_download_video_tb_dang_ky_tren_app'].'</td>';}  ?></tr>
<tr><td>Tổng số thuê bao tải video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_download_video_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao đã đăng ký dịch vụ tải video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dang_ky_tai_video_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số thuê bao chưa đăng ký dịch vụ tải video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_mac_dinh_tai_video_tren_app'].'</td>';}  ?></tr>
<tr><td>Tỉ lệ trung bình tải video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>- Số video được tải trung bình/1 thuê bao chưa đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_video_download___msisdn_chua_dk_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số video được tải trung bình/1 thuê bao đã đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_video_download___msisdn_da_dk_tren_app'].'</td>';}  ?></tr>
<tr><td>- Số video được tải trung bình/1 thuê bao có hoạt động tải</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_video_download___msisdn_co_download_video_tren_app'].'</td>';}  ?></tr>

<!-- End App Client -->

<!-- Web -->
<tr><td><b>Hoạt động của khách hàng trên web</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>

    <!-- nghe bai hat -->
    <tr><td>Số lượt nghe bài hát</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>Số lượt nghe bài hát theo tình trạng đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>- Số lượt nghe bài hát được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_nghe_tren_web_tb_dang_ky'].'</td>';}  ?></tr>
    <tr><td>- Số lượt nghe bài hát được thực hiện bởi khách vãng lai (chưa đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_nghe_tren_web_tb_mac_dinh'].'</td>';}  ?></tr>
    <tr><td>Tổng số thuê bao nghe bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_nghe_bai_hat_tren_web'].'</td>';}  ?></tr>
    <tr><td>- Số thuê bao đã đăng ký dịch vụ nghe bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dk_nghe_bai_hat_tren_web'].'</td>';}  ?></tr>
    <tr><td>- Số thuê bao chưa đăng ký dịch vụ nghe bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_chua_dk_nghe_bai_hat_tren_web'].'</td>';}  ?></tr>

    <!-- xem video -->
    <tr><td>Số lượt xem video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>Số lượt xem video theo tình trạng đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>- Số lượt xem video được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tb_dang_ky_tren_web'].'</td>';}  ?></tr>
    <tr><td>- Số lượt xem video được thực hiện bởi khách vãng lai (chưa đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_xem_video_tb_mac_dinh_tren_web'].'</td>';}  ?></tr>
    <tr><td>Tổng số thuê bao xem video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_xem_video_tren_web'].'</td>';}  ?></tr>
    <tr><td>- Số thuê bao đã đăng ký dịch vụ xem video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dk_xem_video_tren_web'].'</td>';}  ?></tr>
    <tr><td>- Số thuê bao chưa đăng ký dịch vụ xem video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_chua_dk_xem_video_tren_web'].'</td>';}  ?></tr>


    <!-- tai bai hat -->
    <tr><td>Số lượt tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_download_bai_hat_web'].'</td>';}  ?></tr>
    <tr><td>Số lượt tải bài hát theo tình trạng đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>- Số lượt tải bài hát được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_download_bai_hat_tb_dang_ky_tren_web'].'</td>';}  ?></tr>
    <tr><td>Tổng số thuê bao tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_tai_bai_hat_tren_web'].'</td>';}  ?></tr>
    <tr><td>- Số thuê bao đã đăng ký dịch vụ tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dang_ky_tai_bai_hat_tren_web'].'</td>';}  ?></tr>
    <tr><td>- Số thuê bao chưa đăng ký dịch vụ tải bài hát</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_mac_dinh_tai_bh_tren_web'].'</td>';}  ?></tr>

    <tr><td>Số lượt tải video</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>Số lượt tải video theo trạng thái đăng ký</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
    <tr><td>- Số lượt tải video được thực hiện bởi thuê bao (đã đăng ký)</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_luot_download_video_tb_dang_ky_tren_web'].'</td>';}  ?></tr>
    <tr><td>Tổng số thuê bao tải video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_thue_bao_download_video_tren_web'].'</td>';}  ?></tr>
    <tr><td>- Số thuê bao đã đăng ký dịch vụ tải video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_dang_ky_tai_video_tren_web'].'</td>';}  ?></tr>
    <tr><td>- Số thuê bao chưa đăng ký dịch vụ tải video</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['so_thue_bao_mac_dinh_tai_video_tren_web'].'</td>';}  ?></tr>

    <!-- End Web-->

<tr><td><b>Nội dung</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Tổng số bài hát đang kích hoạt trên hệ thống</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_bai_hat_active'].'</td>';}  ?></tr>
<tr><td>Tổng số album đang kích hoạt trên hệ thống</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_album_active'].'</td>';}  ?></tr>
<tr><td>Tổng số playlist đang kích hoạt trên hệ thống</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_playlist_active'].'</td>';}  ?></tr>
<tr><td>Tổng số sự kiện đang kích hoạt trên hệ thống</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_news_event_active'].'</td>';}  ?></tr>
<tr><td>Số tin tức đang kích hoạt trên hệ thống</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_news_active'].'</td>';}  ?></tr>

<tr><td>Phát triển nội dung</td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Số bài hát mới thêm</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_bai_hat_upload'].'</td>';}  ?></tr>
<tr><td>Số album mới thêm</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_album_upload'].'</td>';}  ?></tr>
<tr><td>Số playlist mới thêm</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_playlist_upload'].'</td>';}  ?></tr>
<tr><td>Số sự kiện mới thêm</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_news_event_upload'].'</td>';}  ?></tr>
<tr><td>Số tin tức mới thêm</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_so_news_upload'].'</td>';}  ?></tr>

<tr><td><b>Doanh thu</b></td><td colspan="<?php echo count($arr_res)?>"></td></tr>
<tr><td>Doanh thu đăng ký</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['doanh_thu_dang_ky_moi'].'</td>';}  ?></tr>
<tr><td>Doanh thu gia hạn</td><?php foreach ($arr_res as $result) { echo '<td>'.$result['doanh_thu_gia_han_dich_vu'].'</td>';}  ?></tr>
<?php /*<tr><td>Doanh thu truy thu</td></tr>*/?>

<tr><td><b>Tổng doanh thu</b></td><?php foreach ($arr_res as $result) { echo '<td>'.$result['tong_doanh_thu'].'</td>';}  ?></tr>
</table>
</div>
</div>
<script>
$("table#list tr").click(function(){
	$("table#list tr").removeClass("actived");
	if($(this).hasClass("actived")){
			$(this).removeClass("actived")
		}else{
			$(this).addClass("actived")
		}
})
</script>