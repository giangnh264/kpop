<?php
$this->breadcrumbs=array(
    'Report'=>array('/report'),
    'Overview',
);
$this->pageLabel = Yii::t('admin', "Thống kê doanh thu gói : {CCPNAME} ",array('{CCPNAME}'=>isset($ccp->name)?$ccp->name:"Chưa chọn nhà cung cấp"));
$curentUrl =  Yii::app()->request->getRequestUri();
$this->menu=array(
    array('label'=>Yii::t('admin','Export'), 'url'=>$curentUrl.'&export=1'),
);
$cs=Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('bbq');
$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
$cssFile=$baseScriptUrl.'/styles.css';
$cs->registerCssFile($cssFile);
$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl."/css/report.css");
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form">
    <?php $this->renderPartial('_revCCpfilter',array('ccpList'=>$ccpList,'ccp_id' =>$ccp_id,'copyrightType'=>$copyrightType,'package'=>$package)); ?>

</div><!-- search-form -->
<?php if($ccp):?>
    <style>
        table tr td{
            padding: 4px;
        }
    </style>
    <div class="content-body grid-view">
        <div class="clearfix"></div>
        <?php if($package == 3):?>
            <table width="100%" class="items">
                <tr>
                    <th>Ngày</th>
                    <th colspan="2">Lượt nghe</th>
                    <th colspan="2">Lượt tải</th>
                    <th colspan="2">Lượt xem video</th>
                    <th colspan="2">Lượt tải video</th>
                    <th colspan="2">Tổng (Nghe+Tải)Audio <br/> + (Xem+Tải)Video</th>
                    <th width="100">Doanh thu </th>
                </tr>
                <tr>
                    <th width="20" >Ngày</th>
                    <th width="20">Tổng lượt nghe CO</th>
                    <th width="20">Tổng lượt nghe</th>
                    <th width="20">Tổng lượt tải CO </th>
                    <th width="20">Tổng lượt tải</th>
                    <th width="20">Tổng lượt xem CO</th>
                    <th width="20">Tổng lượt xem</th>
                    <th width="20">Tổng lượt tải video CO </th>
                    <th width="20">Tổng lượt tải video</th>
                    <th width="45">Tổng Nghe+Xem+Tải CO </th>
                    <th width="45">Tổng Nghe+Xem+Tải</th>
                    <th colspan="3">Doanh thu Vega hưởng</th>
                </tr>

                <?php
                $total = 0;
                $total_play = 0;
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total_video1=0;
                $total_video2=0;
                $total_video3=0;
                $total_video4=0;
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
                                'user_incurred_charge'=>0,
                            );
                        }
                        ?>
                        <tr>
                            <td><?php echo $ccprev['date']?></td>
                            <td><?php $played_count = (isset($ccprev['played_count']))?$ccprev['played_count']:0; echo $played_count;?></td>
                            <td><?php $total_listen = (isset($ccprev['total_listen']))?$ccprev['total_listen']:0; echo $total_listen;?></td>
                            <td><?php $downloaded_count = (isset($ccprev['downloaded_count']))?$ccprev['downloaded_count']:0; echo $downloaded_count;?></td>
                            <td><?php $total_download = (isset($ccprev['total_download']))?$ccprev['total_download']:0; echo $total_download;?></td>
                            <td><?php $played_count_video = (isset($ccprev['played_count_video']))?$ccprev['played_count_video']:0; echo $played_count_video;?></td>
                            <td><?php $total_listen_video = (isset($ccprev['total_listen_video']))?$ccprev['total_listen_video']:0; echo $total_listen_video;?></td>
                            <td><?php $downloaded_count_video = (isset($ccprev['downloaded_count_video']))?$ccprev['downloaded_count_video']:0; echo $downloaded_count_video;?></td>
                            <td><?php $total_download_video = (isset($ccprev['total_download_video']))?$ccprev['total_download_video']:0; echo $total_download_video;?></td>
                            <td><?php
                                //Tổng Nghe+Xem+Tải CO
                                $co_listen_download = ($played_count+$downloaded_count + $played_count_video+$downloaded_count_video);
                                echo $co_listen_download?>
                            </td>
                            <td><?php
                                //Tổng Nghe+Xem+Tải Vega
                                $ssVegaTotalDay = $total_download+$total_listen + $total_listen_video+$total_download_video;
                                echo $ssVegaTotalDay
                                /*
                                if(isset($ssVega["{$ccprev['date']}"])){
                                    echo $ssVegaTotalDay = $ssVega["{$ccprev['date']}"]['streaming_cp']+$ssVega["{$ccprev['date']}"]['download_cp'];
                            }else{
                                    echo $ssVegaTotalDay=0;
                        }
                                 *
                                 */
                                ?></td>
                            <td colspan="3">
                                <?php
                                if(isset($ssVega["{$ccprev['date']}"])){
                                    $rev = $ssVega["{$ccprev['date']}"];
                                    $revenueVega = $revenuePackage["{$ccprev['date']}"]*0.2;
                                }else{
                                    $revenueVega = 0;
                                }
                                echo number_format($revenueVega, 2, ',', ' ');
                                ?>

                            </td>
                        </tr>
                        <?php
                        $total1 += $played_count;
                        $total2 += $total_listen;
                        $total3 += $downloaded_count;
                        $total4 += $total_download;
                        $total_video1 += $played_count_video;
                        $total_video2 += $total_listen_video;
                        $total_video3 += $downloaded_count_video;
                        $total_video4 += $total_download_video;
                        $total5 += ($played_count + $downloaded_count) + ($played_count_video + $downloaded_count_video);
                        $total6 +=  $ssVegaTotalDay;
                        /*Doanh thu Vega huong*/
                        $total7 += $revenueVega;

                    endforeach;
                endif;
                ?>
                <tr>
                    <td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                    <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video1; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video2; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video3; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video4; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total5;?></td>
                    <td style="background: #5ec411!important;"><?php echo $total6; ?></td>
                    <td style="background: #5ec411!important;" colspan="3"><?php echo number_format($total7, 2, ',', ' ');?></td>
                </tr>

            </table>



            <!--- GOI NGAY--->
        <?php elseif ($package == 1): //goi ngay?>
            <table width="100%" class="items">
                <tr>
                    <th>Ngày</th>
                    <th colspan="2">Lượt nghe</th>
                    <th colspan="2">Lượt tải</th>
                    <th colspan="2">Lượt xem video</th>
                    <th colspan="2">Lượt tải video</th>
                    <th colspan="2">Tổng (Nghe+Tải)Audio <br/> + (Xem+Tải)Video</th>
                    <th colspan="2" width="100">Doanh thu </th>
                </tr>
                <tr>
                    <th width="20" >Ngày</th>
                    <th width="20">Tổng lượt nghe CO</th>
                    <th width="20">Tổng lượt nghe</th>
                    <th width="20">Tổng lượt tải CO </th>
                    <th width="20">Tổng lượt tải</th>
                    <th width="20">Tổng lượt xem CO</th>
                    <th width="20">Tổng lượt xem</th>
                    <th width="20">Tổng lượt tải video CO </th>
                    <th width="20">Tổng lượt tải video</th>
                    <th width="45">Tổng Nghe+Xem+Tải CO </th>
                    <th width="45">Tổng Nghe+Xem+Tải</th>
                    <th width="45">Doanh thu Vega hưởng</th>
                </tr>

                <?php
                $total = 0;
                $total_play = 0;
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total_video1=0;
                $total_video2=0;
                $total_video3=0;
                $total_video4=0;
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
                                'user_incurred_charge'=>0,
                            );
                        }
                        ?>
                        <tr>
                            <td><?php echo $ccprev['date']?></td>
                            <td><?php $played_count = (isset($ccprev['played_count_A1']))?$ccprev['played_count_A1']:0; echo $played_count;?></td>
                            <td><?php $total_listen = (isset($ccprev['total_listen_A1']))?$ccprev['total_listen_A1']:0; echo $total_listen;?></td>
                            <td><?php $downloaded_count = (isset($ccprev['downloaded_count_A1']))?$ccprev['downloaded_count_A1']:0; echo $downloaded_count;?></td>
                            <td><?php $total_download = (isset($ccprev['total_download_A1']))?$ccprev['total_download_A1']:0; echo $total_download;?></td>
                            <td><?php $played_count_video = (isset($ccprev['played_count_video_A1']))?$ccprev['played_count_video_A1']:0; echo $played_count_video;?></td>
                            <td><?php $total_listen_video = (isset($ccprev['total_listen_video_A1']))?$ccprev['total_listen_video_A1']:0; echo $total_listen_video;?></td>
                            <td><?php $downloaded_count_video = (isset($ccprev['downloaded_count_video_A1']))?$ccprev['downloaded_count_video_A1']:0; echo $downloaded_count_video;?></td>
                            <td><?php $total_download_video = (isset($ccprev['total_download_video_A1']))?$ccprev['total_download_video_A1']:0; echo $total_download_video;?></td>
                            <td><?php
                                //Tổng Nghe+Xem+Tải CO
                                $co_listen_download = ($played_count+$downloaded_count + $played_count_video+$downloaded_count_video);
                                echo $co_listen_download?>
                            </td>
                            <td><?php
                                //Tổng Nghe+Xem+Tải Vega
                                $ssVegaTotalDay = $total_download+$total_listen + $total_listen_video+$total_download_video;
                                echo $ssVegaTotalDay
                                ?></td>
                            <td colspan="3">
                                <?php
                                if(isset($ssVega["{$ccprev['date']}"])){
                                    $rev = $ssVega["{$ccprev['date']}"];
                                    $revenueVega = $revenuePackage["{$ccprev['date']}"]*0.2;
                                }else{
                                    $revenueVega = 0;
                                }
                                echo number_format($revenueVega, 2, ',', ' ');
                                ?>

                            </td>
                        </tr>
                        <?php
                        $total1 += $played_count;
                        $total2 += $total_listen;
                        $total3 += $downloaded_count;
                        $total4 += $total_download;
                        $total_video1 += $played_count_video;
                        $total_video2 += $total_listen_video;
                        $total_video3 += $downloaded_count_video;
                        $total_video4 += $total_download_video;
                        $total5 += ($played_count + $downloaded_count) + ($played_count_video + $downloaded_count_video);
                        $total6 += $ssVegaTotalDay;
                        /*Doanh thu Vega huong*/
                        $total7 += $revenueVega;

                    endforeach;
                endif;
                ?>
                <tr>
                    <td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                    <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video1; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video2; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video3; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video4; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total5;?></td>
                    <td style="background: #5ec411!important;"><?php echo $total6; ?></td>
                    <td style="background: #5ec411!important;" colspan="3"><?php echo number_format($total7, 2, ',', ' ');?></td>
                </tr>

            </table>
        <?php elseif ($package == 2)://goi tuan?>
            <table width="100%" class="items">
                <tr>
                    <th>Ngày</th>
                    <th colspan="2">Lượt nghe</th>
                    <th colspan="2">Lượt tải</th>
                    <th colspan="2">Lượt xem video</th>
                    <th colspan="2">Lượt tải video</th>
                    <th colspan="2">Tổng (Nghe+Tải)Audio <br/> + (Xem+Tải)Video</th>
                    <th colspan="2" width="100">Doanh thu </th>
                </tr>
                <tr>
                    <th width="20" >Ngày</th>
                    <th width="20">Tổng lượt nghe CO</th>
                    <th width="20">Tổng lượt nghe</th>
                    <th width="20">Tổng lượt tải CO </th>
                    <th width="20">Tổng lượt tải</th>
                    <th width="20">Tổng lượt xem CO</th>
                    <th width="20">Tổng lượt xem</th>
                    <th width="20">Tổng lượt tải video CO </th>
                    <th width="20">Tổng lượt tải video</th>
                    <th width="45">Tổng Nghe+Xem+Tải CO </th>
                    <th width="45">Tổng Nghe+Xem+Tải</th>
                    <th width="45">Doanh thu Vega hưởng</th>
                </tr>

                <?php
                $total = 0;
                $total_play = 0;
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total_video1=0;
                $total_video2=0;
                $total_video3=0;
                $total_video4=0;
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
                                'user_incurred_charge'=>0,
                            );
                        }
                        ?>
                        <tr>
                            <td><?php echo $ccprev['date']?></td>
                            <td><?php $played_count = (isset($ccprev['played_count_A7']))?$ccprev['played_count_A7']:0; echo $played_count;?></td>
                            <td><?php $total_listen = (isset($ccprev['total_listen_A7']))?$ccprev['total_listen_A7']:0; echo $total_listen;?></td>
                            <td><?php $downloaded_count = (isset($ccprev['downloaded_count_A7']))?$ccprev['downloaded_count_A7']:0; echo $downloaded_count;?></td>
                            <td><?php $total_download = (isset($ccprev['total_download_A7']))?$ccprev['total_download_A7']:0; echo $total_download;?></td>
                            <td><?php $played_count_video = (isset($ccprev['played_count_video_A7']))?$ccprev['played_count_video_A7']:0; echo $played_count_video;?></td>
                            <td><?php $total_listen_video = (isset($ccprev['total_listen_video_A7']))?$ccprev['total_listen_video_A7']:0; echo $total_listen_video;?></td>
                            <td><?php $downloaded_count_video = (isset($ccprev['downloaded_count_video_A7']))?$ccprev['downloaded_count_video_A7']:0; echo $downloaded_count_video;?></td>
                            <td><?php $total_download_video = (isset($ccprev['total_download_video_A7']))?$ccprev['total_download_video_A7']:0; echo $total_download_video;?></td>
                            <td><?php
                                //Tổng Nghe+Xem+Tải CO
                                $co_listen_download = ($played_count+$downloaded_count + $played_count_video+$downloaded_count_video);
                                echo $co_listen_download?>
                            </td>
                            <td><?php
                                //Tổng Nghe+Xem+Tải Vega
                                $ssVegaTotalDay = $total_download+$total_listen + $total_listen_video+$total_download_video;
                                echo $ssVegaTotalDay;

                                ?></td>
                            <td colspan="3">
                                <?php
                                if(isset($ssVega["{$ccprev['date']}"])){
                                    $rev = $ssVega["{$ccprev['date']}"];
                                    $revenueVega = $revenuePackage["{$ccprev['date']}"]*0.2;

                                }else{
                                    $revenueVega = 0;
                                }
                                echo number_format($revenueVega, 2, ',', ' ');
                                ?>

                            </td>
                        </tr>
                        <?php
                        $total1 += $played_count;
                        $total2 += $total_listen;
                        $total3 += $downloaded_count;
                        $total4 += $total_download;
                        $total_video1 += $played_count_video;
                        $total_video2 += $total_listen_video;
                        $total_video3 += $downloaded_count_video;
                        $total_video4 += $total_download_video;
                        $total5 += ($played_count + $downloaded_count) + ($played_count_video + $downloaded_count_video);
                        $total6 += $ssVegaTotalDay;
                        /*Doanh thu Vega huong*/
                        $total7 += $revenueVega;

                    endforeach;
                endif;
                ?>
                <tr>
                    <td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                    <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video1; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video2; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video3; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total_video4; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total5;?></td>
                    <td style="background: #5ec411!important;"><?php echo $total6; ?></td>
                    <td style="background: #5ec411!important;" colspan="3"><?php echo number_format($total7, 2, ',', ' ');?></td>
                </tr>

            </table>
        <?php endif; ?>
    </div>
<?php else:?>
    <div><br><b>Không có dữ liệu</b></div>
<?php endif;?>
