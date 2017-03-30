<?php
class UserFriendModel extends BaseUserFriendModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserFriend the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * return primaryKey name
     */
    public function primaryKey() {
        return "user_id";
    }
}