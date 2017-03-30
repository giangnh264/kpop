<?php

Yii::import('application.models.db.LogCdrModel');

class AdminLogCdrModel extends LogCdrModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function getContentPrice($time)
    {
    	$sql = "SELECT transaction, price
    			FROM log_cdr
    			WHERE price >= 0 AND not(transaction ='play_album' and price <> 4000) AND created_time>='{$time['from']}' AND created_time<='{$time['to']}'
    			GROUP BY concat_ws('_',transaction, price)
    			ORDER BY price ASC
    	";
    	return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getContentCP($time,$cpId)
    {
    	$sql = "
    			SELECT
					SUM(CASE WHEN (reason ='CONTENT' AND content_type='MUSIC' AND genre_type='VI' AND cp_id='$cpId') THEN 1 ELSE 0 END) AS total_count_song_vi,
					SUM(CASE WHEN (reason ='CONTENT' AND content_type='MUSIC' AND genre_type='QTE' AND cp_id='$cpId') THEN 1 ELSE 0 END) AS total_count_song_qte,
					SUM(CASE WHEN (reason ='CONTENT' AND content_type='VIDEO' AND genre_type='VI' AND cp_id='$cpId') THEN 1 ELSE 0 END) AS total_count_video_vi,
					SUM(CASE WHEN (reason ='CONTENT' AND content_type='VIDEO' AND genre_type='QTE' AND cp_id='$cpId') THEN 1 ELSE 0 END) AS total_count_video_qte,
					SUM(CASE WHEN (reason ='CONTENT' AND content_type='MUSIC' AND genre_type='VI' AND cp_id='$cpId') THEN price ELSE 0 END) AS total_price_song_vi,
					SUM(CASE WHEN (reason ='CONTENT' AND content_type='MUSIC' AND genre_type='QTE' AND cp_id='$cpId') THEN price ELSE 0 END) AS total_price_song_qte,
					SUM(CASE WHEN (reason ='CONTENT' AND content_type='VIDEO' AND genre_type='VI' AND cp_id='$cpId') THEN price ELSE 0 END) AS total_price_video_vi,
					SUM(CASE WHEN (reason ='CONTENT' AND content_type='VIDEO' AND genre_type='QTE' AND cp_id='$cpId') THEN price ELSE 0 END) AS total_price_video_qte,
					SUM(CASE WHEN (reason ='CHACHAFUN' AND content_type IN ('MUSIC','VIDEO')) THEN 1 ELSE 0 END) AS total_all_trans_chachafun,
					SUM(CASE WHEN (reason ='CHACHAFUN' AND content_type IN ('MUSIC','VIDEO') AND cp_id='$cpId') THEN 1 ELSE 0 END) AS total_cp_trans_chachafun,
					#SUM(CASE WHEN (reason IN ('RENEW_FUN','REG_FUN')) THEN price ELSE 0 END) AS total_price_chachafun
					SUM(CASE WHEN (transaction IN ('subscribe','subscribe_ext')) THEN price ELSE 0 END) AS total_price_chachafun,
					SUM(CASE WHEN (reason ='MUSICGIFT') THEN 1 ELSE 0 END) AS total_count_musicgift,
					SUM(CASE WHEN (reason ='MUSICGIFT') THEN price ELSE 0 END) AS total_price_musicgift
				FROM log_cdr WHERE created_time BETWEEN '{$time['from']}' AND '{$time['to']}'
    			";
    	return Yii::app()->db->createCommand($sql)->queryRow();
    }
}