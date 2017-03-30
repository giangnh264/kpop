<div id="main-box-7" class="main-box vce-border-top  ">
    <h3 class="main-box-title ">Nổi bật trong tuần</h3>
    <div class="main-box-inside ">

        <div class="vce-loop-wrap vce-slider-pagination vce-slider-e">
            <?php
                foreach ($datas as $item):
            ?>
                <article
                        class="vce-post vce-lay-e post-203 post type-post status-publish format-standard has-post-thumbnail hentry category-environment category-technology tag-earth tag-ecology tag-solar-energy">

                        <div class="meta-image">
                            <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"
                               title="Solar Energy for Mother Earth and Everyday Smiles">
                                <img width="145" height="100"
                                     src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                                     class="attachment-vce-lay-d size-vce-lay-d wp-post-image" alt=""
                                     srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>,
                                            <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 380w"
                                     sizes="(max-width: 145px) 100vw, 145px"/>
                                <span class="vce-format-icon">
                                    <?php if($item->category_id == 4):?>
                                        <i class="fa fa-picture-o"></i>
                                    <?php else:?>
                                        <i class="fa fa-play"></i>
                                    <?php endif;?>

                                </span>
                            </a>
                        </div>

                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"
                                                       title="<?php echo $item->title; ?>"><?php echo Formatter::smartCut($item->title, 50, 0); ?></a></h2>
                        </header>

                    </article>
            <?php endforeach;?>

        </div>

    </div>
</div>
