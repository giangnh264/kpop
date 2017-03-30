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
            <td style="vertical-align:middle">&nbsp;&nbsp;Cú pháp:&nbsp;&nbsp;</td>
            <td style="vertical-align:middle">
            <?php
            $sources = PackageOfflineModel::model()->published()->findAll();
            ?>
            <select name="type" id="type">
            <?php foreach($sources as $value):
                $source = strtoupper($value->code);
                if(in_array("PackageOfflineRole",Yii::app()->user->roles)){
                    $user_list = explode(";", $value->admin_user);
                    if(in_array(Yii::app()->user->username, $user_list)){?>
                        <option value="<?php echo $source?>" <?php echo (isset($_GET['type']) && $_GET['type'] == $source) ? " SELECTED" : "" ?> ><?php echo $source?></option>
                    <?php }
                }else{?>
                    <option value="<?php echo $source?>" <?php echo (isset($_GET['type']) && $_GET['type'] == $source) ? " SELECTED" : "" ?> ><?php echo $source?></option>
                <?php }
            ?>
            <?php endforeach;?>
            </select>

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
<?php if(!empty($mes)):  ?>
    <div style="padding: 10px 20px;font-weight: bold;font-size: 15px;"><?php echo $mes;?></div>
<?php else:?>
<div class="content-body grid-view">
    <table width="100%" class="items">
        <tr>
            <th height="30" style="vertical-align: middle; color: #000">Ngày</th>
            <th height="30" style="vertical-align: middle;color: #000">Tổng số ĐK</th>
            <th height="30" style="vertical-align: middle;color: #000">Tổng số ĐK thành công</th>
            <th height="30" style="vertical-align: middle;color: #000">Tổng số ĐK không thành công</th>
            <th height="30" style="vertical-align: middle;color: #000">Tổng số thuê bao lũy kế</th>
            <th height="30" style="vertical-align: middle;color: #000">Tổng số lượt thuê bao hủy</th>
            <th height="30" style="vertical-align: middle;color: #000">Tổng số lượt thuê bao gia hạn</th>
            <th height="30" style="vertical-align: middle;color: #000">Tổng số lượt thuê bao gia hạn thành công</th>
            <th height="30" style="vertical-align: middle;color: #000">Tổng số lượt thuê bao gia hạn không thành công</th>
            <th height="30" style="vertical-align: middle;color: #000">Tổng doanh thu</th>
        </tr>
        <?php
        $i = 0;
        foreach ($data as $data): ?>
            <tr class="<?php echo ($i % 2 == 0) ? "odd" : "even"; ?>">
                <td><?php echo $data['date'] ?></td>
                <td><?php echo $data['total_subs'] ?></td>
                <td><?php echo $data['total_subs_success'] ?></td>
                <td><?php echo $data['total_subs_unsuccess'] ?></td>
                <td><?php echo $data['total_accumulated'] ?></td>
                <td><?php echo $data['total_unsubs'] ?></td>
                <td><?php echo $data['total_ext'] ?></td>
                <td><?php echo $data['total_ext_success'] ?></td>
                <td><?php echo $data['total_ext_unsuccess'] ?></td>
                <td><?php echo $data['total_revenue'] ?></td>
            </tr>
            <?php
            $total_subs += $data['total_subs'];
            $total_subs_success += $data['total_subs_success'];
            $total_subs_unsuccess += $data['total_subs_unsuccess'];
            $total_accumulated += $data['total_accumulated'];
            $total_unsubs += $data['total_unsubs'];
            $total_ext += $data['total_ext'];
            $total_ext_success += $data['total_ext_success'];
            $total_ext_unsuccess += $data['total_ext_unsuccess'];
            $total_revenue += $data['total_revenue'];
            $i++;
        endforeach;
        ?>
        <tr>
            <td style="background: #D54E21!important;"><b>Tổng số</b></td>
            <td style="background: #5ec411!important;"><?php echo $total_subs ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_subs_success ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_subs_unsuccess ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_accumulated ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_unsubs ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_ext ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_ext_success ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_ext_unsuccess ?></td>
            <td style="background: #5ec411!important;"><?php echo $total_revenue ?></td>
        </tr>
    </table>
</div>
<?php endif;?>