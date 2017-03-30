<?php
$this->pageLabel = Yii::t('admin', "Thống kê từ {$this->time['from']} Tới {$this->time['to']}");
$curentUrl = Yii::app()->request->getRequestUri();
$this->menu = array(
    array('label' => Yii::t('admin', 'Export'), 'url' => $curentUrl . '&s=2&export=1'),
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
                <select name="type" id="type">
                    <option value="BUZZCITY" <?php echo ($_GET['type'] == 'BUZZCITY') ? " SELECTED" : "" ?> >Buzzcity</option>
                    <option value="CLEVERNET" <?php echo ($_GET['type'] == 'CLEVERNET') ? " SELECTED" : "" ?> >Clevernet</option>
                    <option value="EWAY" <?php echo ($_GET['type'] == 'EWAY') ? " SELECTED" : "" ?> >Eway</option>
                    <option value="SMM" <?php echo ($_GET['type'] == 'SMM') ? " SELECTED" : "" ?> >Smm</option>
                    <option value="ADMOD" <?php echo ($_GET['type'] == 'ADMOD') ? " SELECTED" : "" ?> >Admod</option>
                    <option value="SOSMART" <?php echo ($_GET['type'] == 'SOSMART') ? " SELECTED" : "" ?> >Sosmart</option>
                    <option value="VSERV" <?php echo ($_GET['type'] == 'VSERV') ? " SELECTED" : "" ?> >Vserv</option>
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

<div class="content-body grid-view">
    <table width="100%" class="items">
        <tr>
            <th height="30" style="vertical-align: middle; color: #000">Ngày</th>
            <th height="30" style="vertical-align: middle;color: #000">Ip</th>
            <th height="30" style="vertical-align: middle;color: #000">Số Click</th>
        </tr>
        <?php
        $i = 0;
        foreach ($listIP as $data):
            if ($data['total'] <= 1)
                continue;
            ?>						
            <tr class="<?php echo ($i % 2 == 0) ? "odd" : "even"; ?>">
                <td><?php echo $data['m'] ?></td>
                <td><?php echo $data['user_ip'] ?></td>
                <td><?php echo $data['total'] ?></td>
            </tr>
            <?php
            $i++;
        endforeach;
        ?>
    </table>
</div>
