<?php
$this->breadcrumbs = array(
    'Report' => array('/report'),
    'Overview',
);
$this->pageLabel = Yii::t('admin', "Thống kê số lượt gia hạn thành công từ các Tb đăng ký qua IVR");
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
            <td style="vertical-align: middle;" ><?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?></td>
            <td style="vertical-align: middle;">
                <div class="row created_time">
                    <?php
                    $this->widget('ext.daterangepicker.input', array(
                        'name' => 'songreport[date]',
                        'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
                    ));
                    ?>
                </div>  
            </td>
            <td style="vertical-align: middle;">
                <input type="submit" value="View" />			
            </td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
    <p>Kết quả: <?php echo $total > 0 ? $total : 0; ?></p>
</div><!-- search-form -->
