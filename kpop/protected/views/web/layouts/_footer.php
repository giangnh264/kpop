<footer id="footer" class="herald-site-footer herald-slide">


    <div class="footer-widgets container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div id="text-3" class="widget widget_text">
                    <div class="textwidget"><p><a href="<?php echo Yii::app()->params['base_url']?>"><img src="<?php echo Yii::app()->request->baseUrl?>/web/images/logo-kpop.png"
                                                                                                          alt="Tin tức Kpop"></a></p>
                        <p>Thông tin đầy đủ về các idol Kpop HOT nhất hiện nay</p>
                        </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div id="herald_posts_widget-10" class="widget herald_posts_widget"><h4 class="widget-title h6"><span>TIN HOT NHẤT</span>
                    </h4>

                    <div class="row ">
                        <?php
                        $news = WebNewsModel::model()->getNewsByCat(1, 3, 0);
                        foreach ($news as $item):
                        ?>
                        <article
                            class="herald-lay-g post-157 post type-post status-publish format-gallery has-post-thumbnail hentry category-travel post_format-post-format-gallery">
                            <div class="row">

                                <div class="col-lg-4 col-xs-3">
                                    <div class="herald-post-thumbnail">
                                        <a href="#"
                                           title="The simplest way to make the best of your vacation">
                                            <img width="74" height="55"
                                                 src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                                                 class="attachment-herald-lay-g1 size-herald-lay-g1 wp-post-image"
                                                 alt=""
                                                 srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 74w,
                                                 <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 111w,
                                                 <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 215w,
                                                 <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 300w"
                                                 sizes="(max-width: 74px) 100vw, 74px" data-wp-pid="1209"/> </a>
                                    </div>
                                </div>

                                <div class="col-lg-8 col-xs-9 herald-no-pad">
                                    <div class="entry-header">

                                        <h2 class="entry-title h7"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"><span
                                                    class="herald-format-icon"><i class="fa fa-camera"></i></span><?php echo Formatter::smartCut($item->title, 50, 0); ?></a></h2>
                                        <div class="entry-meta meta-small">
                                            <div class="meta-item herald-views">11,733 Views</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </article>
                        <?php endforeach;?>
                    </div>


                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div id="herald_posts_widget-11" class="widget herald_posts_widget"><h4 class="widget-title h6"><span>ĐỌC NHIỀU NHẤT</span>
                    </h4>

                    <div class="row ">
                        <?php
                        $news = WebNewsModel::model()->getNewsByCat(2, 3, 0);
                        foreach ($news as $item):
                        ?>
                        <article
                            class="herald-lay-g post-157 post type-post status-publish format-gallery has-post-thumbnail hentry category-travel post_format-post-format-gallery">
                            <div class="row">

                                <div class="col-lg-4 col-xs-3">
                                    <div class="herald-post-thumbnail">
                                        <a href="#"
                                           title="The simplest way to make the best of your vacation">
                                            <img width="74" height="55"
                                                 src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                                                 class="attachment-herald-lay-g1 size-herald-lay-g1 wp-post-image"
                                                 alt=""
                                                 srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 74w,
                                                 <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 111w,
                                                 <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 215w,
                                                 <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 300w"
                                                 sizes="(max-width: 74px) 100vw, 74px" data-wp-pid="1209"/> </a>
                                    </div>
                                </div>

                                <div class="col-lg-8 col-xs-9 herald-no-pad">
                                    <div class="entry-header">

                                        <h2 class="entry-title h7"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"><span
                                                    class="herald-format-icon"><i class="fa fa-camera"></i></span><?php echo Formatter::smartCut($item->title, 50, 0); ?></a></h2>
                                        <div class="entry-meta meta-small">
                                            <div class="meta-item herald-views">11,733 Views</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </article>
                        <?php endforeach;?>
                    </div>


                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div id="tag_cloud-3" class="widget widget_tag_cloud"><h4 class="widget-title h6"><span>Tags</span></h4>
                    <div class="tagcloud"><a href='http://demo.mekshq.com/herald/?tag=awesome'
                                             class='tag-link-55 tag-link-position-1' title='3 topics'
                                             style='font-size: 13.3846153846pt;'>awesome</a>
                        <a href='http://demo.mekshq.com/herald/?tag=bass' class='tag-link-51 tag-link-position-2'
                           title='1 topic' style='font-size: 8pt;'>bass</a>
                        <a href='http://demo.mekshq.com/herald/?tag=blog' class='tag-link-8 tag-link-position-3'
                           title='11 topics' style='font-size: 22pt;'>blog</a>
                        <a href='http://demo.mekshq.com/herald/?tag=company' class='tag-link-9 tag-link-position-4'
                           title='5 topics' style='font-size: 16.6153846154pt;'>company</a>
                        <a href='http://demo.mekshq.com/herald/?tag=company-culture'
                           class='tag-link-10 tag-link-position-5' title='1 topic' style='font-size: 8pt;'>company
                            culture</a>
                        <a href='http://demo.mekshq.com/herald/?tag=earth' class='tag-link-11 tag-link-position-6'
                           title='1 topic' style='font-size: 8pt;'>earth</a>
                        <a href='http://demo.mekshq.com/herald/?tag=eco' class='tag-link-12 tag-link-position-7'
                           title='1 topic' style='font-size: 8pt;'>eco</a>
                        <a href='http://demo.mekshq.com/herald/?tag=ecology' class='tag-link-13 tag-link-position-8'
                           title='1 topic' style='font-size: 8pt;'>ecology</a>
                        <a href='http://demo.mekshq.com/herald/?tag=entrepreneurship'
                           class='tag-link-14 tag-link-position-9' title='1 topic' style='font-size: 8pt;'>entrepreneurship</a>
                        <a href='http://demo.mekshq.com/herald/?tag=environment-2'
                           class='tag-link-15 tag-link-position-10' title='3 topics'
                           style='font-size: 13.3846153846pt;'>environment</a>
                        <a href='http://demo.mekshq.com/herald/?tag=fashion-2' class='tag-link-16 tag-link-position-11'
                           title='1 topic' style='font-size: 8pt;'>fashion</a>
                        <a href='http://demo.mekshq.com/herald/?tag=fashoin' class='tag-link-17 tag-link-position-12'
                           title='2 topics' style='font-size: 11.2307692308pt;'>fashoin</a>
                        <a href='http://demo.mekshq.com/herald/?tag=food-2' class='tag-link-18 tag-link-position-13'
                           title='2 topics' style='font-size: 11.2307692308pt;'>food</a>
                        <a href='http://demo.mekshq.com/herald/?tag=funk' class='tag-link-19 tag-link-position-14'
                           title='1 topic' style='font-size: 8pt;'>funk</a>
                        <a href='http://demo.mekshq.com/herald/?tag=future' class='tag-link-20 tag-link-position-15'
                           title='1 topic' style='font-size: 8pt;'>future</a>
                        <a href='http://demo.mekshq.com/herald/?tag=lifestyle-2'
                           class='tag-link-21 tag-link-position-16' title='1 topic'
                           style='font-size: 8pt;'>lifestyle</a>
                        <a href='http://demo.mekshq.com/herald/?tag=magazine' class='tag-link-22 tag-link-position-17'
                           title='9 topics' style='font-size: 20.5641025641pt;'>magazine</a>
                        <a href='http://demo.mekshq.com/herald/?tag=music-2' class='tag-link-23 tag-link-position-18'
                           title='6 topics' style='font-size: 17.8717948718pt;'>music</a>
                        <a href='http://demo.mekshq.com/herald/?tag=new' class='tag-link-52 tag-link-position-19'
                           title='4 topics' style='font-size: 15.1794871795pt;'>new</a>
                        <a href='http://demo.mekshq.com/herald/?tag=pasta' class='tag-link-24 tag-link-position-20'
                           title='1 topic' style='font-size: 8pt;'>pasta</a>
                        <a href='http://demo.mekshq.com/herald/?tag=photos' class='tag-link-25 tag-link-position-21'
                           title='1 topic' style='font-size: 8pt;'>photos</a>
                        <a href='http://demo.mekshq.com/herald/?tag=post' class='tag-link-56 tag-link-position-22'
                           title='1 topic' style='font-size: 8pt;'>post</a>
                        <a href='http://demo.mekshq.com/herald/?tag=rock' class='tag-link-54 tag-link-position-23'
                           title='1 topic' style='font-size: 8pt;'>rock</a>
                        <a href='http://demo.mekshq.com/herald/?tag=solar-energy'
                           class='tag-link-26 tag-link-position-24' title='1 topic' style='font-size: 8pt;'>solar
                            energy</a>
                        <a href='http://demo.mekshq.com/herald/?tag=songs' class='tag-link-53 tag-link-position-25'
                           title='1 topic' style='font-size: 8pt;'>songs</a>
                        <a href='http://demo.mekshq.com/herald/?tag=studio' class='tag-link-27 tag-link-position-26'
                           title='1 topic' style='font-size: 8pt;'>studio</a>
                        <a href='http://demo.mekshq.com/herald/?tag=sustainability'
                           class='tag-link-28 tag-link-position-27' title='1 topic' style='font-size: 8pt;'>sustainability</a>
                        <a href='http://demo.mekshq.com/herald/?tag=technology-2'
                           class='tag-link-29 tag-link-position-28' title='2 topics'
                           style='font-size: 11.2307692308pt;'>technology</a>
                        <a href='http://demo.mekshq.com/herald/?tag=tips' class='tag-link-30 tag-link-position-29'
                           title='1 topic' style='font-size: 8pt;'>tips</a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="hel-l herald-go-hor">
                        <div class="herald-copyright">Copyright &copy; 2017. Created by <a href="https://www.facebook.com/Mr.Koigiang" target="_blank">KOI GIANG</a>
                        </div>
                    </div>

                    <div class="hel-r herald-go-hor">
                        <ul id="menu-herald-social-1" class="herald-soc-nav">
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1037"><a
                                    href="https://www.facebook.com/Mr.Koigiang"><span
                                        class="herald-social-name">Facebook</span></a></li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1038"><a
                                    href="https://twitter.com/koigiang"><span
                                        class="herald-social-name">Twitter</span></a></li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1039"><a
                                    href="https://plus.google.com/u/0/107033946089516550101"><span
                                        class="herald-social-name">Google+</span></a></li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1040"><a
                                    href="https://www.instagram.com/koigiang/"><span class="herald-social-name">Instagram</span></a>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

</footer>