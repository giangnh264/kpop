<?php

class TopContentModel extends BaseTopContentModel
{
    /**
        * Returns the static model of the specified AR class.
        * @return TopContent the static model class
        */
    const ACTIVE = 1;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function scopes() {
        return array(
            "published" => array(
                "condition" => "`t`.`status` = " . self::ACTIVE,
            ),
        );
    }

    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('name',$this->name,true);
            $criteria->compare('t.group',$this->group,false);
            $criteria->compare('type',$this->type,true);
            $criteria->compare('content_id',$this->content_id);
            $criteria->compare('link',$this->link,true);
            $criteria->compare('sorder',$this->sorder);
            $criteria->compare('status',$this->status);
            
            $criteria->order = 'sorder ASC';
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                    ),
            ));
    }

    /**
     * Lay danh sach type: song, video, album, playlist
     * @return array
     */
    public static function getTypeArray() {
        return array(
            '' => Yii::t('admin', "Select a type"),
            'album' => Yii::t('admin', "Album"),
            'video_playlist' => Yii::t('admin', 'Live show'),
        );
    }
    
    /*public function getAvatarUrl($id = null, $size='', $cacheBrowser = false) {
        if (!isset($id))
            $id = $this->id;

        // browser cache
        if ($cacheBrowser) {
            $version = isset($this->updated_time) ? $this->updated_time : 0;
        }
        else
            $version = time();

        $path = AvatarHelper::getAvatar("topContent", $id);
        return $path . "?v=" . $version;
    }*/

    public function getAvatarUrl($id=null, $size="300", $cacheBrowser = false)
    {
        if(!isset($id)) $id = $this->id;

        $path = AvatarHelper::getAvatar("topContent", $id, $size);
        return $path."?v=".time();;
    }
    
    /*public function getAvatarPath($id = null, $isFolder = false) {
        if (!isset($id))
            $id = $this->id;
        if ($isFolder) {
            $savePath = Common::storageSolutionEncode($id);
        } else {
            $savePath = Common::storageSolutionEncode($id) . $id . ".jpg";
        }
        $path = Yii::app()->params['storage']['topContentDir']. DS . $savePath;
        return $path;
    }*/
    public function getAvatarPath($id=null,$size=150,$isFolder = false)
    {
        if(!isset($id)) $id = $this->id;
        if($isFolder){
            $savePath = Common::storageSolutionEncode($id);
        }else{
            $savePath = Common::storageSolutionEncode($id).$id.".jpg";
        }
        $savePath = Common::storageSolutionEncode($id).$id.".jpg";
        $path = Yii::app()->params['storage']['topContentDir'].DS.$size.DS.$savePath;
        return $path;
    }
    
    public function saveAvatar($source, $id = null){
        if (!isset($id))
           $id = $this->id;
        $fileSystem = new Filesystem();
        
        // get avatar folder
        $folderPath = $this->getAvatarPath($this->id, true);
        
        // Create folder by ID
        $fileSystem->mkdirs($folderPath);
        @chmod($folderPath, 0775);

        // Get link file by ID
        $savePath = $this->getAvatarPath($model->id);
                
        // Delete file if exists
        if(file_exists($savePath)) {
            $fileSystem->remove($savePath);
        }
        
        //save file
        if(file_exists($source)) {
            //move_uploaded_file($source, $savePath);
            $fileSystem->copy($source, $savePath);
            $fileSystem->remove($source);
        }
    }

    public function getTopContent($group = 'home', $limit = 10, $offset = 0){
        $sql = "SELECT * FROM top_content WHERE `group` = :GR AND status = 1 ORDER BY sorder ASC LIMIT :LIMIT OFFSET :OFFSET";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":GR", $group, PDO::PARAM_STR);
        $command->bindParam(":LIMIT", $limit, PDO::PARAM_INT);
        $command->bindParam(":OFFSET", $offset, PDO::PARAM_INT);
        return $command->queryAll();
    }

    public function getCountTopContent($group = 'home'){
        $sql = "SELECT COUNT(*) FROM top_content WHERE `group` = :GR AND status = 1";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":GR", $group, PDO::PARAM_STR);
        return $command->queryScalar();
    }


}