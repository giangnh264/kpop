<?php
class GenreModel extends BaseGenreModel {

    const ALL = -1;
    const DEACTIVE = 0;
    const ACTIVE = 1;

    /**
     * Returns the static model of the specified AR class.
     * @return Genre the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('sorder', $this->sorder);
        $criteria->compare('status', $this->status);
        $criteria->compare('is_hot', $this->is_hot);
        $criteria->compare('is_new', $this->is_new);
        $criteria->compare('is_collection', $this->is_collection);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array('defaultOrder' => 'sorder ASC, id ASC'),
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }

    public static function getSubcontentType($genreId)
    {
        $genre = GenreModel::model()->findByPk($genreId);
        if ($genre)
        {
        	$viGenre = yii::app()->params['VNGenre'];
        	$QTEGenre = yii::app()->params['QTEGenre'];

            //if ($genre == yii::app()->params['VNGenre'] || $genre->parent_id == yii::app()->params['VNGenre'])
            if (in_array($genre->id, $QTEGenre) || in_array($genre->parent_id, $QTEGenre))
            {
                 return 'QTE';
            }
            else
            {
               return 'VI';
            }
        }
        else
        {
            return 'VI';
        }
    }

    public function getSubGenre($genreId, $status=null)
    {
        $criteria = new CDbCriteria;
        if(isset($status)){
            $criteria->condition = "parent_id=:GENRE AND status =:GENSTATUS";
            $criteria->params = array(":GENRE"=>$genreId, 'GENSTATUS'=>$status);
        }
        else{
            $criteria->condition = "parent_id=:GENRE";
            $criteria->params = array(":GENRE"=>$genreId);
        }
            
        $criteria->order = 'name';
        $results = GenreModel::model()->findAll($criteria);
        return $results;
    }

}