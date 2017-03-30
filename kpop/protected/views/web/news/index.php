<div id="content" class="container site-content vce-sid-right">

    <div id="primary" class="vce-main-content">
        <?php $category = CategoryModel::model()->findByPk($news->category_id); ?>
        <main id="main" class="main-box main-box-single">

            <article
                class="vce-single post-191 post type-post status-publish format-standard has-post-thumbnail hentry category-food tag-chocolates tag-food-2 tag-magazine tag-sugar tag-sweet">

                <header class="entry-header">
                    <span class="meta-category"><a
                            href="<?php echo Yii::app()->createUrl('category/index', array('url_key' => $category->url_key)); ?>"
                            class="category-2"><?php echo $category->name; ?></a></span>

                    <h1 class="entry-title"><?php echo $news->title; ?></h1>
                    <div class="entry-meta">
                        <div class="meta-item date">
                            <span class="updated"> <?php echo Formatter::formatTimeAgo($news->created_time); ?></span>
                        </div>


                    </div>
                </header>
                <div class="meta-image">
                    <img width="810" height="540"
                         src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $news->url_img; ?>"
                         class="attachment-vce-lay-a size-vce-lay-a wp-post-image" alt=""
                         srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $news->url_img; ?> 810w,
                         <?php echo Yii::app()->params['storage']['NewsUrl'] . $news->url_img; ?> 300w,
                         <?php echo Yii::app()->params['storage']['NewsUrl'] . $news->url_img; ?> 1024w,
                         <?php echo Yii::app()->params['storage']['NewsUrl'] . $news->url_img; ?> 1140w"
                         sizes="(max-width: 810px) 100vw, 810px">
                </div>


                <!--  <div class="entry-headline">
                      <p>Master cleanse mumblecore sriracha, whatever typewriter fashion axe PBR&amp;B Echo Park heirloom YOLO gentrify distillery Cosby sweater. Fingerstache pork belly lumbersexual umami church-key craft beer. Readymade iPhone whatever, asymmetrical dreamcatcher fingerstache Helvetica.</p>
                  </div>-->


                <div class="entry-content">
                    <?php echo $news->content; ?>
                </div>


                <footer class="entry-footer">
                    <div class="meta-tags">
                        <?php foreach ($news->relations_tag_news as $relations_tag_new) : ?>
                            <a href="#" rel="tag"><?php echo $relations_tag_new->tag->name; ?></a>
                        <?php endforeach; ?>
                    </div>
                </footer>


                <div class="vce-share-bar">
                    <ul class="vce-share-items">
                        <li><a class="fa fa-facebook" href="javascript:void(0);"
                               data-url="http://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdemo.mekshq.com%2Fvoice%2F%3Fp%3D191&amp;t=Stunning+Health+Benefits+of+Eating+Chocolates"></a>
                        </li>
                        <li><a class="fa fa-twitter" href="javascript:void(0);"
                               data-url="http://twitter.com/intent/tweet?url=http%3A%2F%2Fdemo.mekshq.com%2Fvoice%2F%3Fp%3D191&amp;text=Stunning+Health+Benefits+of+Eating+Chocolates"></a>
                        </li>
                        <li><a class="fa fa-google-plus" href="javascript:void(0);"
                               data-url="https://plus.google.com/share?url=http%3A%2F%2Fdemo.mekshq.com%2Fvoice%2F%3Fp%3D191"></a>
                        </li>
                        <li><a class="fa fa-pinterest" href="javascript:void(0);"
                               data-url="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fdemo.mekshq.com%2Fvoice%2F%3Fp%3D191&amp;media=http%3A%2F%2Fdemo.mekshq.com%2Fvoice%2Fwp-content%2Fuploads%2F2014%2F11%2Fvoice_18.jpg&amp;description=Stunning+Health+Benefits+of+Eating+Chocolates"></a>
                        </li>
                        <li><a class="fa fa-linkedin" href="javascript:void(0);"
                               data-url="http://www.linkedin.com/shareArticle?mini=true&amp;url=http%3A%2F%2Fdemo.mekshq.com%2Fvoice%2F%3Fp%3D191&amp;title=Stunning+Health+Benefits+of+Eating+Chocolates"></a>
                        </li>
                    </ul>
                </div>

                <div class="vce-ad vce-ad-container"><a href="http://mekshq.com/item/voice" target="_blank"><img
                            src="http://mekshq.com/static/voice/voice_banner_single_top.jpg"></a></div>

            </article>


            <nav class="prev-next-nav">

                <div class="vce-prev-link">
                    <a href="http://demo.mekshq.com/voice/?p=192" rel="next"><span class="img-wrp"><img width="375"
                                                                                                        height="195"
                                                                                                        src="http://demo.mekshq.com/voice/wp-content/uploads/2014/11/voice_152-375x195.jpg"
                                                                                                        class="attachment-vce-lay-b size-vce-lay-b wp-post-image"
                                                                                                        alt=""><span
                                class="vce-pn-ico"><i class="fa fa fa-chevron-left"></i></span></span><span
                            class="vce-prev-next-link">Hipster Yoga at the End of the World</span></a></div>


                <div class="vce-next-link">
                    <a href="http://demo.mekshq.com/voice/?p=174" rel="prev"><span class="img-wrp"><img width="375"
                                                                                                        height="195"
                                                                                                        src="http://demo.mekshq.com/voice/wp-content/uploads/2014/11/voice_74-375x195.jpg"
                                                                                                        class="attachment-vce-lay-b size-vce-lay-b wp-post-image"
                                                                                                        alt=""><span
                                class="vce-pn-ico"><i class="fa fa fa-chevron-right"></i></span></span><span
                            class="vce-prev-next-link">San Francisco is the Most Photographed City in North America</span></a>
                </div>
            </nav>
        </main>
    </div>
</div>

