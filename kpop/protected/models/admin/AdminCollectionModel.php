<?php

Yii::import('application.models.db.CollectionModel');

class AdminCollectionModel extends CollectionModel
{
    var $className = __CLASS__;
	public $_onlySong = false;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

	public function relations()
    {
        return  CMap::mergeArray( parent::relations(),   array(
            'col_gen'=>array(self::HAS_ONE, 'AdminCollectionGenreModel', 'collect_id','condition' => 'col_gen.genre_id = '.Yii::app()->request->getParam('genre_id')),
        ));
    }


	public function newsearch($genre_id)
	{
		$criteria=new CDbCriteria;
        $criteria->select = "collect_id";
		$criteria->condition = "genre_id = $genre_id";

        $collectionIds = AdminCollectionGenreModel::model()->findAll($criteria);
        $collect_ids = array();
        if(count($collectionIds)){
            foreach($collectionIds as $collect_id)
                $collect_ids[] = $collect_id->collect_id;
        }
        $collect_ids_str = implode(',',$collect_ids);
        $new_criteria = new CDbCriteria;;
        $new_criteria->condition = " t.id IN ($collect_ids_str)";
        $new_criteria->with = "col_gen";
        $new_criteria->order = "col_gen.sorder ASC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$new_criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}

    public static function getCollectionViewMenu_old(){

       $id = Yii::app()->request->getParam('id');

       $cri = new CDbCriteria();
       $cri->select = "id,name";
       $cri->condition = "status = 1";
       $suggestLists = AdminSuggestModel::model()->findAll($cri);
       $arr_suggetId = array(array('label' => Yii::t('admin', 'Toàn bộ'), 'url' => '/admin.php?r=collection/view&id='.$id, "active" => "active", 'linkOptions' => array('id' => 'basic-info')),);
       foreach ($suggestLists as $suggest) {
           $arr = array();
           $arr['label'] = $suggest->name;
           $arr['url'] = '/admin.php?r=collection/view&id='.$id."&suggest=".$suggest->id;
           $arr_suggetId[] = $arr;
       }

       return $arr_suggetId;
    }


    /** duyet bang collection_item lay nhung genre id, Moi genre ung voi 1 menu item
     * @return array menu item
     */
    public static function getCollectionViewMenu(){
        $collect_id = Yii::app()->request->getParam('id',1);
        $sql = "SELECT DISTINCT genre_id FROM collection_genre WHERE genre_id <> '' AND genre_id IS NOT NULL ";
        $results =  Yii::app()->db->createCommand($sql)->queryAll();
        $genre_ids = array(
                        array(
                            'label' => Yii::t('admin', 'Danh sách'),
                            'url' => array('/collection/index'),
                        ));
        foreach($results as $result){
            $genreModel = GenreModel::model()->findByPk($result["genre_id"]);
            $genre_ids[] = array(
                        'label' => Yii::t('admin', $genreModel->name),
                        'url' => array('collection/index',"genre_id" => $result["genre_id"]),
                    );
        }
        $genre_ids[] = array(
                        'label' => Yii::t('admin', 'Show ở trang chủ'),
                        'url' => array('collection/index',"custom_field" => 'home_page'),
                    );
        return $genre_ids;

    }

    public function chart()
    {
    	$criteria=new CDbCriteria;
    	$criteria->compare('name',$this->name,true);
    	$criteria->compare('code',$this->code,true);
    	$criteria->compare('web_home_page',$this->web_home_page);
    	$criteria->compare('cc_type',$this->cc_type);
    	$criteria->compare('cc_genre',$this->cc_genre);
    	$criteria->compare('cc_week_num',$this->cc_week_num);
    	$criteria->compare('cc_week_begin',$this->cc_week_begin);
    	$criteria->compare('cc_week_end',$this->cc_week_end);
   		$criteria->order = "id DESC ";

    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    			'pagination'=>array(
    					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
    			),
    	));
    }
}