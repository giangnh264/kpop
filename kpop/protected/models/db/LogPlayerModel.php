<?php
class LogPlayerModel extends BaseLogPlayerModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogPlayer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     *
     * return primaryKey name
     */
    public function primaryKey()
    {
        return "id";
    }
}