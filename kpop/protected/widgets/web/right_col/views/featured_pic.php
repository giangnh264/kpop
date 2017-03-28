<div id="vce_posts_widget-5" class="widget vce_posts_widget"><h4 class="widget-title">Featured  Posts</h4>

    <ul class="vce-post-slider" data-autoplay="">
        <?php
        foreach ($datas as $item):
        ?>
        <li>
            <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>" class="featured_image_sidebar"
               title="<?php echo $item->title; ?>"><span class="vce-post-img">
                    <img width="380" height="260"  src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                        class="attachment-vce-fa-grid size-vce-fa-grid wp-post-image" alt=""
                        srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 380w,
                                <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 145w"
                        sizes="(max-width: 380px) 100vw, 380px"/></span></a>
            <div class="vce-posts-wrap">
                <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"
                   title="S<?php echo $item->title; ?>" class="vce-post-link"><?php echo Formatter::smartCut($item->title, 50, 0); ?></a>
                <div class="entry-meta">
                    <div class="meta-item rtime"><?php echo Formatter::formatTimeAgo($item->created_time);?></div>
                </div>
            </div>
        </li>
        <?php endforeach;?>
    </ul>


</div>