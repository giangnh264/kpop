<?php
class BmRingtoneCategoryModel extends RingtoneCategoryModel
{
    public static function getRingtoneSubcontentType($categoryId)
    {
        $category = BmRingtoneCategoryModel::model()->findByPk($categoryId);
        if ($category)
        {
            if ($category->id == 25 || $category->parent_id == 25)
            {
                return 'VI';
            }
            else
            {
                return 'QTE';
            }
        }
        else
        {
            return 'QTE';
        }
    }
}

?>
