<?php
$this->pageLabel = Yii::t('admin', "Thống kê Quà tặng âm nhạc");
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
            <?php /*

             */ ?>
            <td style="vertical-align:middle"><?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?>&nbsp;</td>
            <td>
                <div class="row created_time">
                    <?php
                    $this->widget('ext.daterangepicker.input', array(
                        'name' => 'songreport[date]',
                        'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
                    ));
                    ?>
                </div>
            </td>
            <td>&nbsp;&nbsp;</td>
            <td valign="middle" style="vertical-align:middle">Phí quà tặng&nbsp;</td>
            <td valign="middle" style="vertical-align:middle">
                <select name="fillter[price]">
                    <option value="0" <?php echo ($price == 0) ? " SELECTED" : "" ?> >Miễn phí</option>
                    <option value="1" <?php echo ($price == 1) ? " SELECTED" : "" ?> >Mất phí</option>
                </select>           	
            </td>
        </tr>
        <tr>
            <td colspan="5" style="vertical-align:middle;" align="center">
                <input type="submit" value="View" />
            </td>
        </tr>
    </table>
<?php $this->endWidget(); ?>
</div><!-- search-form -->
<div class="clb"></div>

<div class="content-body grid-view">
    <table width="100%" class="items">
        <tr>
            <th height="20" style="vertical-align: middle; color: #FFF">Ngày</th>
            <th height="20" style="vertical-align: middle;color: #FFF">Tổng số lượt</th>
            <th height="20" style="vertical-align: middle;color: #FFF">Tổng số thuê bao</th>
            <th height="20" style="vertical-align: middle;color: #FFF">Số TB thành công</th>
            <th height="20" style="vertical-align: middle;color: #FFF">Số TB thất bại</th>
        </tr>
<?php foreach ($data as $data): ?>
            <tr>
                <td><?php echo $data['m'] ?></td>
                <td><?php echo $data['total'] ?></td>
                <td><?php echo $data['total_phone'] ?></td>
                <td><?php echo $data['total_success'] ?></td>
                <td><?php echo ($data['total_phone'] - $data['total_success']) < 0 ? 0 : ($data['total_phone'] - $data['total_success']) // $data['total_fail'] ?></td>			
            </tr>
<?php endforeach; ?>
    </table>
</div>

