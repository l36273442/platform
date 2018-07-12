<?php
require_once(dirname(__FILE__).'/CommonController.php');
class AjaxController extends CommonController
{
    public function init()
    {
        $this->start_time = microtime(true);
        Yii::app()->messages->forceTranslation = true;
        
        if(isset($_GET['lang']) && $_GET['lang'] != "" && in_array( $_GET['lang'], $this->lang))
        {
            Yii::app()->language = $_GET['lang'];
            Yii::app()->session['lang'] = $_GET['lang'];
        }
        else if(!empty(Yii::app()->session['lang']))
        {
            Yii::app()->language = Yii::app()->session['lang'];
        }
        else
        {
            Yii::app()->language = Yii::app()->sourceLanguage;
        }
        if( !isset(Yii::app()->session['id']) || empty(Yii::app()->session['id'])) {
            
            $this->renderError(Yii::t('common','no_login'), 4);
        }        
    }
}
