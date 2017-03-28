<div id="main-box-1" class="main-box vce-border-top  ">
    <h3 class="main-box-title ">Fresh Topics</h3>
    <div class="main-box-inside ">


        <div class="vce-loop-wrap vce-slider-pagination vce-slider-c">
            <?php
                $news = WebNewsModel::model()->getNewsByCat(1, 4, 0);
                foreach ($news as $item):
            ?>
            <article
                class="vce-post vce-lay-c post-180 post type-post status-publish format-standard has-post-thumbnail hentry category-lifestyle category-technology tag-blog tag-magazine tag-technology-2">

                <div class="meta-image">
                    <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"
                       title="<?php echo Formatter::smartCut($item->title, 90, 0); ?>">
                        <img width="375" height="195" src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                             class="attachment-vce-lay-b size-vce-lay-b wp-post-image" alt=""/> </a>
                </div>

                <header class="entry-header">
                                    <span class="meta-category"><a href="http://demo.mekshq.com/voice/?cat=1" class="category-1">Lifestyle</a> <span>&bull;</span> <a
                                            href="http://demo.mekshq.com/voice/?cat=6" class="category-6">Technology</a></span>
                    <h2 class="entry-title">
                        <a href="http://demo.mekshq.com/voice/?p=180"
                                               title="<?php echo Formatter::smartCut($item->title, 90, 0); ?>"><?php echo Formatter::smartCut($item->title,90, 0); ?>
                        </a></h2>
                    <div class="entry-meta">
                        <div class="meta-item date"><span class="updated"><?php echo Formatter::formatTimeAgo($item->created_time);?></span></div>
                    </div>
                </header>

                <div class="entry-content"><?php echo Formatter::smartCut($item->description, 190, 0); ?></p>
                </div>

            </article>

            <?php endforeach;?>
        </div>

    </div>
</div>
