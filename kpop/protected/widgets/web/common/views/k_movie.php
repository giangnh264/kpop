<div class="herald-module col-lg-12 col-md-12 col-sm-12" id="herald-module-1-1" data-col="12">

    <div class="herald-mod-wrap">
        <div class="herald-mod-head herald-cat-6">
            <div class="herald-mod-title"><h2 class="h6 herald-mod-h herald-color">K Movie - Drama</h2></div>
            <div class="herald-mod-subnav"><a href="http://demo.mekshq.com/herald/?cat=48">Movie</a><a
                    href="http://demo.mekshq.com/herald/?cat=43">Drama</a></div>
            <div class="herald-mod-actions"><a class="herald-all-link"
                                               href="http://demo.mekshq.com/herald/?cat=6">Xem tất cả</a>
                <div class="herald-slider-controls" data-col="4" data-autoplay="0"></div>
            </div>
        </div>
    </div>
    <div class="row herald-posts row-eq-height herald-slider">

        <?php
        $news = WebNewsModel::model()->getNewsByCat(2, 8, 0);
        foreach ($news as $item):
        ?>
        <article
            class="herald-lay-f post-171 post type-post status-publish format-standard has-post-thumbnail hentry category-entertainment tag-blog tag-music-2 tag-studio">

            <div class="herald-post-thumbnail herald-format-icon-middle">
                <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>$item->url_key));?>"
                   title="Start recording like a pro with the help of these 6 tips">
                    <img width="300" height="168"
                         src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                         class="attachment-herald-lay-f size-herald-lay-f wp-post-image" alt=""
                         srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 300w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 990w,
                          <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 1320w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 470w,
                          <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 640w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 215w,
                          <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 414w"
                         sizes="(max-width: 300px) 100vw, 300px" data-wp-pid="1182"/> </a>
            </div>

            <div class="entry-header"> <span class="meta-category meta-small"><a
                                            href="http://demo.mekshq.com/herald/?cat=6" class="herald-cat-6">Movie</a></span>

                <h2 class="entry-title h5"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>$item->url_key));?>"><?php echo Formatter::smartCut($item->title, 90, 0); ?></a></h2>
                <div class="entry-meta meta-small">
                    <div class="meta-item herald-views">3,286 Lượt xem</div>
                    <div class="meta-item herald-rtime">cách đây 2 phút</div>
                </div>
            </div>
        </article>
        <?php endforeach;?>
    </div>


</div>
