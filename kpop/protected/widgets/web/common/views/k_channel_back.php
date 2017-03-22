<div class="herald-module col-lg-12 col-md-12 col-sm-12" id="herald-module-1-0" data-col="12">

    <div class="herald-mod-wrap">
        <div class="herald-mod-head ">
            <div class="herald-mod-title"><h2 class="h6 herald-mod-h herald-color">TIN TỨC</h2></div>
        </div>
    </div>
    <div class="row herald-posts row-eq-height ">

        <?php
        $news = WebNewsModel::model()->getNewsByCat(1, 2, 0);
        foreach ($news as $item):
        ?>
            <article
                class="herald-lay-c post-191 post type-post status-publish format-standard has-post-thumbnail hentry category-food-and">

                <div class="herald-post-thumbnail herald-format-icon-middle">
                    <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"
                       title="Pasta is the secret ingredient for a healthy lifestyle">
                        <img width="470" height="264"
                             src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                             class="attachment-herald-lay-b size-herald-lay-b wp-post-image" alt=""
                             srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 470w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 990w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 1320w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 640w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 215w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 300w, <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 414w"
                             sizes="(max-width: 470px) 100vw, 470px" data-wp-pid="1258"/> </a>
                </div>

                <div class="entry-header">
                                    <span class="meta-category"><a href="http://demo.mekshq.com/herald/?cat=4" class="herald-cat-4">TIN TỨC</a></span>

                    <h2 class="entry-title h3"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"><?php echo Formatter::smartCut($item->title, 90, 0); ?></a></h2>
                    <div class="entry-meta">
                        <div class="meta-item herald-date"><span class="updated">6 days ago</span></div>
                        <div class="meta-item herald-author">
                            <div class="coauthors couauthors-icon"><span class="vcard author"><span
                                        class="fn"><a
                                            href="http://demo.mekshq.com/herald?author_name=meks1">Patrick Callahan</a></span></span><span
                                    class="vcard author"><span class="fn"><a
                                            href="http://demo.mekshq.com/herald?author_name=meks2">Lisa Scholfield</a></span></span><span
                                    class="vcard author"><span class="fn"><a
                                            href="http://demo.mekshq.com/herald?author_name=meks3">John Bergstein</a></span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="entry-content">
                    <p><?php echo Formatter::smartCut($item->description, 200, 0); ?></p>
                </div>

            </article>
        <?php endforeach;?>

    </div>


</div>
