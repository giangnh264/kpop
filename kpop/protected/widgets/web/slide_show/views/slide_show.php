<div class="herald-section container herald-no-sid" id="herald-section-0">

    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="row">
                <div class="herald-module col-lg-12 col-md-12 col-sm-12" id="herald-module-0-0">

                    <div class="herald-fa-wrapper herald-fa-2 ">

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="herald-fa-list">
                                    <?php
                                    $news = WebNewsModel::model()->getLastet(4, 0);
                                    foreach ($news as $item):
                                        $category = WebCategoryModel::model()->findbyPk($item->category_id);
                                        ?>
                                        <article class="herald-fa-item herald-cat-2">

                                            <header class="entry-header">

                                                <span class="meta-category"><a href="#" class="herald-cat-2"><?php echo $category->name;?></a></span>

                                                <h2 class="entry-title h6"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"><span class="herald-format-icon"><i class="fa fa-camera"></i></span><?php echo $item->title;?></a></h2>
                                                <div class="entry-meta">
                                                    <div class="meta-item herald-date"><span
                                                            class="updated">6 days ago</span></div>
                                                    <div class="meta-item herald-comments"><a
                                                            href="http://demo.mekshq.com/herald/?p=157#comments">6 Comments</a></div>
                                                </div>

                                                <div class="entry-content">
                                                    <p><?php echo $item->title;?></p>
                                                </div>

                                                <a href="#" class="fa-post-bg"></a>

                                            </header>

                                            <a class="fa-post-thumbnail" href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"
                                               title="The simplest way to make the best of your vacation"><img width="550" height="520"  src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                                                                                                               class="attachment-herald-lay-fa1-full size-herald-lay-fa1-full wp-post-image" alt="" data-wp-pid="1209"/></a>
                                        </article>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


    </div>

</div>