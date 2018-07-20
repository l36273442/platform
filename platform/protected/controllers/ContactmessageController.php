<?php

class ContactMessageController extends CommonController
{
    public function actionSetMessage(){

        $p = $this->getParams('REQUEST');
        if( !isset($p['name']) || empty($p['name']) ){
            $this->renderError(Yii::t('common','param_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['email']) || empty($p['email']) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/',$p['email'])){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['offer']) || empty($p['offer']) ){
            $this->renderError(Yii::t('common','param_empty'), ErrorCode::PARAM_EMPTY); 
        }
        $m = new ContactMessageModel();
        $m->name = $p['name'];
        $m->email = $p['email'];
        $m->message = $p['offer'];
        if(isset($_SESSION['id'])){
            $m->uid = $_SESSION['id'];
        }
        $re = $m->save();
        if($re ){
            $this->renderJson(Yii::t('common','success'));
        }
        else{
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR); 
        }
    }

}
