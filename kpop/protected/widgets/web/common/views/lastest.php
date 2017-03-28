<div id="main-box-11" class="main-box vce-border-top  ">
    <h3 class="main-box-title ">Tin Mới Cập Nhật</h3>
    <div class="main-box-inside ">
        <div class="vce-loop-wrap">
            <?php
                $news = WebNewsModel::model()->getNewsByCat(1, 10, 0);
                foreach ($news as $item):
            ?>
                    <article class="vce-post vce-lay-b post-174 post type-post status-publish format-standard has-post-thumbnail hentry category-environment">

                        <div class="meta-image">
                            <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>" title="San Francisco is the Most Photographed City in North America">
                                <img width="375" height="195" src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>" class="attachment-vce-lay-b size-vce-lay-b wp-post-image" alt="">							</a>
                        </div>


                        <header class="entry-header">
                            <span class="meta-category"><a href="http://demo.mekshq.com/voice/?cat=5" class="category-5">Environment</a></span>
                            <h2 class="entry-title"><a href="http://demo.mekshq.com/voice/?p=174" title=" <?php echo Formatter::smartCut($item->title, 90, 0); ?>"> <?php echo Formatter::smartCut($item->title, 90, 0); ?></a></h2>
                            <div class="entry-meta"><div class="meta-item date"><span class="updated"><?php echo Formatter::formatTimeAgo($item->created_time);?></span></div><div class="meta-item comments"><a href="http://demo.mekshq.com/voice/?p=174#comments">1 Comment</a></div></div>	</header>


                    </article>
            <!--<article
                class="vce-post vce-lay-b post-203 post type-post status-publish format-standard has-post-thumbnail hentry category-environment category-technology tag-earth tag-ecology tag-solar-energy">

                <div class="meta-image">
                    <a href="<?php /*echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));*/?>"
                       title="Solar Energy for Mother Earth and Everyday Smiles">
                        <img width="375" height="195" src="<?php /*echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;*/?>"
                             class="attachment-vce-lay-b size-vce-lay-b wp-post-image" alt=""/> </a>
                </div>


                <header class="entry-header"> <span class="meta-category">
                        <a href="http://demo.mekshq.com/voice/?cat=5"  class="category-5">Environment</a>
                    <h2 class="entry-title">
                        <a href="<?php /*echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));*/?>" title="<?php /*echo Formatter::smartCut($item->title, 90, 0); */?>">Solar
                            <?php /*echo Formatter::smartCut($item->title, 90, 0); */?></a></h2>
                    <div class="entry-meta">
                        <div class="meta-item date"><span class="updated"><?php /*echo Formatter::formatTimeAgo($item->created_time);*/?></span></div>
                    </div>
                </header>


            </article>-->
            <?php endforeach;?>
        </div>
        <nav id="vce-pagination" class="vce-load-more">
            <a href="http://demo.mekshq.com/voice/?paged=2"> Load more</a></nav>


    </div>
</div>