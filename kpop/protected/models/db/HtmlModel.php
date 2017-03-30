<?php
class HtmlModel extends BaseHtmlModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Html the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}