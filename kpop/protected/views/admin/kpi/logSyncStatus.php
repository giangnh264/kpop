<?php
if (is_array($this->time)) {
    if ($this->time['from'] != $this->time['to']) {
        $this->pageLabel = Yii::t('admin', "KPI đồng bộ thuê bao từ ngày: {from} tới {to}", array('{from}' => $this->time['from'], '{to}' => $this->time['to']));
    } else {
        $this->pageLabel = Yii::t('admin', "KPI đồng bộ thuê bao ngày: " . $this->time['from']);
    }
} else {
    $this->pageLabel = Yii::t('admin', "KPI đồng bộ thuê bao ngày: " . $this->time);
}
?>

<div class="search-form oflowh">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table>
        <tr>
            <td style="vertical-align: middle;"><?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?></td>
            <td style="vertical-align: middle;">
                <div class="row created_time">
                    <?php
                    $this->widget('ext.daterangepicker.input', array(
                        'name' => 'time',
                        'value' => isset($_GET['time']) ? CHtml::encode($_GET['time']) : '',
                    ));
                    ?>
                </div>  
            </td>
            <td style="vertical-align: middle;"><input type="submit" value="Xem" /></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->


<div class="content-body grid-view">
    <div class="clearfix"></div>
    <table width="100%" class="items">
        <tr>
            <th height="25" style="vertical-align: middle;">Thời gian</th>
            <th height="25" style="vertical-align: middle;">Tổng số</th>
            <th height="25" style="vertical-align: middle;">Số TB hủy</th>
            <th height="25" style="vertical-align: middle;">Số TB tạm ngừng</th>
            <th height="25" style="vertical-align: middle;">Số TB kich hoạt lại</th>
        </tr>
        <?php
        foreach ($data as $date):
            ?>
            <tr>
                <td><?php echo $date['date'] ?></td>
                <td><?php echo $date['total'] ?></td>
                <td><?php echo $date['total_unsub'] ?></td>
                <td><?php echo $date['total_lock'] ?></td>
                <td><?php echo $date['total_unlock'] ?></td>
            </tr>

            <?php
        endforeach;
        ?>
    </table>
</div>

