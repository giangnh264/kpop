<?php
$this->pageLabel = Yii::t('admin', "Thống kê từ {$this->time['from']} Tới {$this->time['to']}");
$curentUrl = Yii::app()->request->getRequestUri();
$this->menu = array(
    array('label' => Yii::t('admin', 'Export'), 'url' => $curentUrl . '&s=1&export=1'),
);
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Bộ lọc', '#', array('class' => 'search-button')); ?>
</div>
<div class="search-form oflowh">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>
    <table>
        <tr>
            <td style="vertical-align:middle"><?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?>&nbsp;</td>
            <td style="vertical-align:middle">
                <div class="row created_time">
                    <?php
                    $this->widget('ext.daterangepicker.input', array(
                        'name' => 'songreport[date]',
                        'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
                    ));
                    ?>
                </div>
            </td>
            <td style="vertical-align:middle">&nbsp;&nbsp;Loại:&nbsp;&nbsp;</td>
            <td style="vertical-align:middle">
            <?php $sources = Yii::app()->params['ads_source'];
            $criteria = new CDbCriteria();
            $criteria->condition = "id IN (61,63,65,67) AND status = 1";
            $criteria->order="id DESC";
            $sources = AdminAdsSourceModel::model()->published()->findAll($criteria);
            ?>
            <select name="type" id="type">
            <?php foreach($sources as $value):
            $source = strtoupper($value->name);
            ?>
			<option value="<?php echo $source?>" <?php echo (isset($_GET['type']) && $_GET['type'] == $source) ? " SELECTED" : "" ?> ><?php echo $source?></option>
            <?php endforeach;?>
            </select>
                <?php /*<select name="type" id="type">
                    <option value="BUZZCITY" <?php echo ($_GET['type'] == 'BUZZCITY') ? " SELECTED" : "" ?> >Buzzcity</option>
                    <option value="CLEVERNET" <?php echo ($_GET['type'] == 'CLEVERNET') ? " SELECTED" : "" ?> >Clevernet</option>
                    <option value="EWAY" <?php echo ($_GET['type'] == 'EWAY') ? " SELECTED" : "" ?> >Eway</option>
                    <option value="SMM" <?php echo ($_GET['type'] == 'SMM') ? " SELECTED" : "" ?> >Smm</option>
                    <option value="ADMOD" <?php echo ($_GET['type'] == 'ADMOD') ? " SELECTED" : "" ?> >Admod</option>
                    <option value="SOSMART" <?php echo ($_GET['type'] == 'SOSMART') ? " SELECTED" : "" ?> >Sosmart</option>
                    <option value="SOSMART_T10" <?php echo ($_GET['type'] == 'SOSMART_T10') ? " SELECTED" : "" ?> >Sosmart.t10</option>
                    <option value="VSERV" <?php echo ($_GET['type'] == 'VSERV') ? " SELECTED" : "" ?> >Vserv</option>
                    <option value="AMOBI" <?php echo ($_GET['type'] == 'AMOBI') ? " SELECTED" : "" ?> >Amobi</option>
                    <option value="INMOBI_T10" <?php echo ($_GET['type'] == 'INMOBI_T10') ? " SELECTED" : "" ?> >Inmobi.t10</option>
                    <option value="ADMICRO" <?php echo ($_GET['type'] == 'ADMICRO') ? " SELECTED" : "" ?> >Admicro</option>
                </select>
				*/?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="vertical-align:middle">&nbsp;<input type="submit" value="View" /></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->
<div class="clb"></div>

<div class="content-body grid-view">
    <table width="100%" class="items">
        <tr>
            <th height="30" style="vertical-align: middle; color: #FFF">Ngày</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Tổng số Click</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Click 3G</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Số Click trùng IP</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Số Click nhận diện được</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Số Click nhận diện không trùng Ip</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Số đăng ký thành công</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Số đăng ký hủy</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Số lượt gia hạn thành công</th>
            
            <th height="30" style="vertical-align: middle;color: #FFF">Số lượt xem mất phí</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Số lượt tải mất phí</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Số thuê xem miễn phí</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Số lượt tải miễn phí</th>
            
            <th height="30" style="vertical-align: middle;color: #FFF">Doanh thu gia hạn</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Doanh thu nội dung</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Doanh thu đăng ký</th>
            <th height="30" style="vertical-align: middle;color: #FFF">Tổng doanh thu</th>
        </tr>
        <?php
        $i = 0;
        foreach ($data as $data):
            $total_rev = 0;
            $total_rev = ($data['total_revenue_ext'] + $data['total_revenue_content'] + $data['total_revenue_subs']);
            ?>
            <tr class="<?php echo ($i % 2 == 0) ? "odd" : "even"; ?>">
                <td><?php echo $data['date'] ?></td>
                <td><?php echo $data['click_total'] ?></td>
                <td><?php echo $data['click_3g'] ?></td>
                <td><?php echo $data['click_unique'] ?></td>
                <td><?php echo $data['click_detect'] ?></td>
                <td><?php echo $data['click_detect_unique'] ?></td>
                <td><?php echo $data['total_subs_success'] ?></td>
                <td><?php echo $data['total_unsubs'] ?></td>
                <td><?php echo $data['total_subs_ext_success'] ?></td>
                
                <td><?php echo $data['total_play'] ?></td>
                <td><?php echo $data['total_download'] ?></td>
                <td><?php echo $data['total_subs_play'] ?></td>
                <td><?php echo $data['total_subs_download'] ?></td>
                
                <td><?php echo $data['total_revenue_ext'] ?></td>
                <td><?php echo $data['total_revenue_content'] ?></td>
                <td><?php echo $data['total_revenue_subs'] ?></td>
                <td><?php echo $total_rev;?></td>
            </tr>
            <?php
            $click_total += $data['click_total'];
            $click_3g += $data['click_3g'];
            $click_unique += $data['click_unique'];
            $click_detect += $data['click_detect'];
            $click_detect_unique += $data['click_detect_unique'];
            $total_subs_success += $data['total_subs_success'];
            $total_unsubs += $data['total_unsubs'];
            $total_subs_ext_success += $data['total_subs_ext_success'];
            
            $total_play +=$data['total_play'];
            $total_download +=$data['total_download'];
            $total_subs_play +=$data['total_subs_play'];
            $total_subs_download +=$data['total_subs_download'];
            
            $total_revenue_ext_subs += $data['total_revenue_ext'];
            $total_revenue_content += $data['total_revenue_content'];
            $total_revenue_subs += $data['total_revenue_subs'];
            $totalcontent += $total_rev;
            $i++;
        endforeach;
        ?>
        <tr>
            <td style="background: #D54E21!important;"><b>Tổng số</b></td>
            <td style="background: #5ec411!important;"><?php echo $click_total ?></td>
            <td style="background: #5ec411!important;"><?php echo $click_3g ?></td>
            <td style="background: #5ec411!important;"><?php echo $click_unique ?></td>
            <td style="background: #5ec411!important;"><?php echo $click_detect ?></td>
            <td style="background: #5ec411!important;"><?php echo $click_detect_unique ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_subs_success ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_unsubs ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_subs_ext_success ?></td>
            
            <td style="background: #5ec411!important;"><?php echo $total_play ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_download ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_subs_play ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_subs_download ?></td>
            
            <td style="background: #5ec411!important;"><?php echo $total_revenue_ext_subs ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_revenue_content ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_revenue_subs ?></td>
            <td style="background: #5ec411!important;"><?php echo $totalcontent ?></td>
        </tr>
    </table>
</div>
