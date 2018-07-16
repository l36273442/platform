<?php
require_once(dirname(__FILE__).'/CommonController.php');
class Controller extends CommonController
{
    public function init()
    {
        $this->start_time = microtime(true);
        Yii::app()->messages->forceTranslation = true;
        
        if(isset($_GET['lang']) && $_GET['lang'] != "" && in_array( $_GET['lang'], $this->lang))
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
            Yii::app()->controller->redirect('/signin');
        }
        $p = PartnerModel::model()->findAll('status=:status' , array(':status'=> 0));
        $this->data['partner'] = array();
        $this->data['link'] = array();
        if($p){
            foreach($p as $v ){
                if($v->type == 1){
                    $this->data['partner'][] = $v->attributes;
                }
                else if($v->type == 0){
                    $this->data['link'][] = $v->attributes;
                }
            }
        }
        $info = InfoModel::model()->find();
        if($info ){
            $this->data['info']=$info->attributes;
        }
        else{
            $this->data['info']['wechat1'] ='';
            $this->data['info']['wechat2'] ='';
            $this->data['info']['phone'] ='';
            $this->data['info']['mobile'] ='';
            $this->data['info']['email'] ='';
            $this->data['info']['about_zh_cn'] ='';
            $this->data['info']['about_en_us'] ='';
        }
    }
}
