<?php
require_once(dirname(__FILE__).'/CommonController.php');
class Controller extends CommonController
{
    public function init()
    {
        $this->start_time = microtime(true);
        Yii::app()->messages->forceTranslation = true;
        
        if(isset($_GET['lang']) && $_GET['lang'] != "")
        {
            Yii::app()->language = $_GET['lang'];
            Yii::app()->session['lang'] =  $_GET['lang'];
        }
        else if(!empty(Yii::app()->session['lang']))
        {
            Yii::app()->language = Yii::app()->session['lang'];
        }
        else
        {
            Yii::app()->language = Yii::app()->sourceLanguage;
        }
        if( !isset($_SESSION['id']) || empty($_SESSION['id'])) {
            Yii::app()->controller->redirect('/login/login');
        }
    }
}
