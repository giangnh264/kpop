<?php
class UserExtraModel extends BaseUserExtraModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserExtra the static model class
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