<?php
if (is_array($this->time)) {
    if ($this->time['from'] != $this->time['to']) {
        $this->pageLabel = Yii::t('admin', "Monitoring nhận diện từ ngày: {from} tới {to}", array('{from}' => $this->time['from'], '{to}' => $this->time['to']));
    } else {
        $this->pageLabel = Yii::t('admin', "Monitoring nhận diện ngày: " . $this->time['from']);
    }
} else {
    $this->pageLabel = Yii::t('admin', "Monitoring nhận diện ngày: " . $this->time);
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
            <td style="vertical-align: middle;"><input type="submit" value="View" /></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->


<div class="content-body grid-view">
    <div class="clearfix"></div>
    <table width="100%" class="items">
        <tr>
            <th height="25" style="vertical-align: middle; color: #000">Thời gian</th>
            <th height="25" style="vertical-align: middle; color: #000">Thất bại</th>
            <th height="25" style="vertical-align: middle; color: #000">Thành công</th>
        </tr>
        <?php
        $total = 0;
        $total_failed = 0;
        $total_success = 0;
        foreach ($data as $date):
            ?>
            <tr>
                <td><?php echo $date['date'] ?></td>
                <td><?php echo $date['failed'] ?></td>
                <td><?php echo $date['success'] ?></td>
            </tr>

            <?php
            $total += $date['total'];
            $total_failed += $date['failed'];
            $total_success += $date['success'];
        endforeach;
        ?>
        <?php if ($total != 0): ?>
            <tr>
                <td><b>Tổng hợp</b></td>
                <td><?php echo $total_failed . "/" . $total . " = <b>" . ($total_failed / $total) * 100 . "%</b>"; ?></td>
                <td><?php echo $total_success . "/" . $total . " = <b>" . ($total_success / $total) * 100 . "%</b>"; ?></td>
            </tr>
        <?php endif; ?>
    </table>
    <div class="list_ip" style="max-width: 100%; margin: 5px 0px;">
        <b>Các IP detect không thành công: </b>
        <?php
        foreach ($ips as $ip) {
            echo $ip['login_ip'] . ", ";
        }
        ?>
    </div>
</div>

