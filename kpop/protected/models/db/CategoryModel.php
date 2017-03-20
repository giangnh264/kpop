<?php

class CategoryModel extends BaseCategoryModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    const DEACTIVE = 0;
    const ACTIVE = 1;

    public function scopes() {
        return array(
            "published" => array(
                "condition" => "`t`.`status` = " . self::ACTIVE,
            ),
        );
    }
}