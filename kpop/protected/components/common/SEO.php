<?php
class SEO extends CApplicationComponent
{
    public $metaTitle;
    public $metaDescription;
    public $metaKeyword;
    public $canonical;

    public $metaKeyOthers = array();
    public $metaProperties = array();
    public function setMetaTitle($value)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        $this->metaTitle = $value.' | AMUSIC.VN';
    }
    public function setMetaDescription($value)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        $this->metaDescription = $value;
    }
    public function setMetaKeyword($value)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        $this->metaKeyword = $value;
    }

    public function setCanonical($value)
    {
        $this->canonical = $value;
    }
    public function addMetaProp($name, $value)
    {
        $value = strip_tags($value);
        //$value = addslashes($value);
        $value = CHtml::encode($value);
        if($name=='og:title'){
            if($value!=''){
                $value.=" | AMUSIC.VN";
            }else{
                $value="AMUSIC.VN";
            }
        }elseif($name=='og:site_name')
        {
            $value="AMUSIC.VN";
        }elseif($name=='og:updated_time')
        {
            $value = date('Y-m-d H:i:s', $value);
        }
        $this->metaProperties[] = array(
            'name'=>$name,
            'value'=>$value
        );
    }
    public function addMetaKeyword($name, $value)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        $this->metaKeyOthers[$name] = $value;
    }
    public function renderMeta()
    {
        if(empty($this->metaTitle)){
            $this->metaTitle = Yii::app()->params['htmlMetadata']['title'];
        }
        if(empty($this->metaDescription)){
            $this->metaDescription = Yii::app()->params['htmlMetadata']['description'];
        }
        if(empty($this->metaKeyword)){
            $this->metaKeyword = Yii::app()->params['htmlMetadata']['keywords'];
        }
        if(empty($this->canonical)){
            $this->canonical = Yii::app()->request->getHostInfo().Yii::app()->request->url;
        }
        echo CHtml::tag('link',array(
            'rel'=>'canonical',
            'href'=>$this->canonical
        ));

        $metaKeywords = CMap::mergeArray(
            array(
                'title'=>$this->metaTitle,
                'description'=>$this->metaDescription,
                'keywords'=>$this->metaKeyword,
            ),
            $this->metaKeyOthers
        );
        foreach($metaKeywords as $name => $content) {
            echo CHtml::metaTag($content, $name) . PHP_EOL;
        }
        if(!empty($this->metaProperties)) {
            foreach ($this->metaProperties as $key => $content)
                echo '<meta property="'.$content['name'].'" content="' . $content['value'] . '" />' . PHP_EOL; // we can't use Yii's method for this.
        }

    }
}