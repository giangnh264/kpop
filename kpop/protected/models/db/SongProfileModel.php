<?php
class SongProfileModel extends BaseSongProfileModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongProfile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getListPorfile()
    {
    	$sql = "SELECT GROUP_CONCAT(profile_id) AS listProfile FROM song_profile";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		return $data['listProfile'];
    }

    public function getProfileByIds($profileids)
    {
    	$c = new CDbCriteria();
    	$c->addInCondition("profile_id", $profileids);
    	return self::model()->findAll($c);
    }
}