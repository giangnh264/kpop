<?php
if (is_array($this->time)) {
    if ($this->time['from'] != $this->time['to']) {
        $this->pageLabel = Yii::t('admin', "Monitoring đăng ký từ ngày: {from} tới {to}", array('{from}' => $this->time['from'], '{to}' => $this->time['to']));
    } else {
        $this->pageLabel = Yii::t('admin', "Monitoring đăng ký ngày: " . $this->time['from']);
    }
} else {
    $this->pageLabel = Yii::t('admin', "Monitoring đăng ký ngày: " . $this->time);
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
            <td style="vertical-align: middle;"></td>
        </tr>
        <tr>
            <td style="vertical-align: middle;">Gói cước</td>
            <td style="vertical-align: middle;">
                <?php
                $cp = CMap::mergeArray(
                                array('0' => "Tất cả"), CHtml::listData($packge, 'id', 'name')
                );
                echo CHtml::dropDownList("packge", isset($_GET['packge']) ? CHtml::encode($_GET['packge']) : 0, $cp)
                ?>
            </td>
            <td style="vertical-align: middle;"><input type="submit" value="View" /></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->


<div class="content-body grid-view">
    <?php if ($phone_list): ?>
        <br/>
        <h4>Thống kê lỗi theo thuê bao:</h4>
        <br/>
        <table width="30%" class="items">
            <tr>
                <th height="25" style="vertical-align: middle; color: #000">Thuê bao</th>
                <th height="25" style="vertical-align: middle; color: #000"><?php echo $title; ?></th>
            </tr>
            <?php foreach ($phone_list as $user): ?>
                <tr>
                    <td><?php echo $user['user_phone'] ?></td>
                    <td><?php echo $user['cnt'] ?>x[<?php echo $user['return_code'] ?>]</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <br/>
    <div class="clearfix"></div>
    <table width="100%" class="items">
        <tr>
            <th height="25" style="vertical-align: middle; color: #000">Thời gian</th>
            <th height="25" style="vertical-align: middle; color: #000">Không đủ tiền</th>
            <th height="25" style="vertical-align: middle; color: #000">Thất bại</th>
            <th height="25" style="vertical-align: middle; color: #000">Thành công</th>
        </tr>
        <?php
        $total = 0;
        $total_balance = 0;
        $total_failed = 0;
        $total_success = 0;
        foreach ($data as $date):
            ?>
            <tr>
                <td><?php echo $date['date'] ?></td>
                <td>
                    <?php if ($date['balance'] != 0): ?>
                        <a href="<?php echo Yii::app()->request->url ?>&act=balance&time_note=<?php echo $date['date'] ?>"><?php echo $date['balance'] ?></a>
                    <?php else: ?>
                        <?php echo $date['balance'] ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($date['failed'] != 0): ?>
                        <a href="<?php echo Yii::app()->request->url ?>&act=false&time_note=<?php echo $date['date'] ?>"><?php echo $date['failed'] ?></a>
                    <?php else: ?>
                        <?php echo $date['failed'] ?>
                    <?php endif; ?>
                </td>
                <td><?php echo $date['success'] ?></td>
            </tr>

            <?php
            $total += $date['total'];
            $total_balance += $date['balance'];
            $total_failed += $date['failed'];
            $total_success += $date['success'];
        endforeach;
        ?>
        <?php if ($total != 0): ?>
            <tr>
                <td>Tổng hợp</td>
                <td><?php echo $total_balance . "/" . $total . " = <b>" . ($total_balance / $total) * 100 . "%</b>"; ?></td>
                <td><?php echo $total_failed . "/" . $total . " = <b>" . ($total_failed / $total) * 100 . "%</b>"; ?></td>
                <td><?php echo $total_success . "/" . $total . " = <b>" . ($total_success / $total) * 100 . "%</b>"; ?></td>

            </tr>
        <?php endif; ?>
    </table>
    <br/>
    <h4>Thống kê lỗi:</h4>
    <br/>
    <table width="30%" class="items">
        <tr>
            <th height="25" style="vertical-align: middle; color: #000">Mã lỗi</th>
            <th height="25" style="vertical-align: middle; color: #000">Mô tả</th>
            <th height="25" style="vertical-align: middle; color: #000">Số lần gặp</th>
        </tr>
        <?php foreach ($errors as $err): ?>
            <tr>
                <td>#<?php echo $err['return_code'] ?></td>
                <td>
                <?php 
                $errorBilling = Yii::app()->params['errorBilling'];
                echo isset($errorBilling[$err['return_code']])?$errorBilling[$err['return_code']]:"N/A"; 
                ?>
                </td>
                <td><?php echo $err['total'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>