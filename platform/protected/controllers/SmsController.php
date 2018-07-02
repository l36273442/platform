<?php
class SmsController extends CommonController{
    public function actionsendSmsTradeCode(){
        if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
            $this->renderError(Yii::t('common','no_login'), 4); 
        }
        if( isset(Yii::app()->session['sms_uptpass_code_time']) && time() < Yii::app()->session['sms_uptpass_code_time'] + SMS_SEND_INTERVAL ){
            $this->renderError(Yii::t('common','sms_interval').' SMS_SEND_INTERVAL ', ErrorCode::USERS_EMPTY);  
        }
        $uid = $_SESSION['id'];
        $user = UserModel::model()->findByPk($_SESSION['id']);
        
        if( empty($user) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::USERS_EMPTY);  
        }
        $mobile = trim($user['country_code'].$user['phone'] , '+');
        $sms_code = rand(100000,999999);
        $content = Yii::t('common','sms_uptpass_code');
        $content = str_replace('{{{sms_expire}}}' , SMS_REGISTER_EXPIRE , $content );
        $content = str_replace('{{{sms_code}}}' , $sms_code , $content);
        $sms = new HeySkyApi();
        $re = $sms->send( $mobile ,$content);
        if( !$re ){
            $this->renderError(Yii::t('common','sms_send_fail'), ErrorCode::PARAM_EMPTY); 
        }
        $sms_log = new SmsLogModel();
        $sms_log->name = $this->getId().':'.$this->getAction()->getId();
        $sms_log->smsid = $re['mtmsgid'];
        $sms_log->cpid  = $re['cpid'];
        $sms_log->sms_content = $content; 
        $sms_log->content = json_encode( $re , JSON_UNESCAPED_UNICODE );
        $sms_log->ctime = time();
        $re_sms = $sms_log->save();
        Yii::app()->session['sms_uptpass_code'] = $sms_code;
        Yii::app()->session['sms_uptpass_code_time'] = time()+ SMS_UPTPASS_EXPIRE * 60;
        Yii::app()->session['sms_uptpass_code_expire'] = time()+ SMS_UPTPASS_EXPIRE * 60;
        if( !$re_sms ){
            Yii::log( '写入SmSLog fali '.json_encode( $re , JSON_UNESCAPED_UNICODE ) , CLogger::LEVEL_ERROR , 'system_error'); 
        }
        $this->renderJson(Yii::t('common','success'));

    }
    public function actionSendSmsCode(){
        $p = $this->getParams('POST');
        if( !isset($p['country_code']) || empty($p['country_code']) ){
            $this->renderError(Yii::t('common','country_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['mobile']) || empty($p['mobile']) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( isset(Yii::app()->session['sms_register_code_time']) && time() < Yii::app()->session['sms_register_code_time'] + SMS_SEND_INTERVAL ){
            $this->renderError(Yii::t('common','sms_interval').' SMS_SEND_INTERVAL ', ErrorCode::USERS_EMPTY);  
        }
        $re = UserModel::model()->getUserByPhone( $p['country_code'] , $p['mobile']) ;
        if( $re ){
            $this->renderError(Yii::t('common','account_exists'), ErrorCode::USERS_ERROR);
        }
        $country_code = trim($p['country_code']);
        $mobile = trim($p['mobile']);
        $mobile = trim($country_code.$mobile , '+');
        $sms = new HeySkyApi();
        $content = Yii::t('common','sms_register_code');
        $content = str_replace('{{{sms_expire}}}' , SMS_REGISTER_EXPIRE , $content );
        $sms_code = rand(100000,999999);
        $content = str_replace('{{{sms_code}}}' , $sms_code , $content);
        $re = $sms->send( $mobile ,$content);
        if( !$re ){
            $this->renderError(Yii::t('common','sms_send_fail'), ErrorCode::PARAM_EMPTY); 
        }
        $sms_log = new SmsLogModel();
        $sms_log->name = $this->getId().':'.$this->getAction()->getId();
        $sms_log->smsid = $re['mtmsgid'];
        $sms_log->cpid  = $re['cpid'];
        $sms_log->sms_content = $content; 
        $sms_log->content = json_encode( $re , JSON_UNESCAPED_UNICODE );
        $sms_log->ctime = time();
        $re_sms = $sms_log->save();
        Yii::app()->session['sms_register_code'] = $sms_code;
        Yii::app()->session['sms_register_code_time'] = time();;
        Yii::app()->session['sms_register_code_expire'] = time()+ SMS_REGISTER_EXPIRE * 60;
        if( !$re_sms ){
            Yii::log( '写入SmSLog fail '.json_encode( $re , JSON_UNESCAPED_UNICODE ) , CLogger::LEVEL_ERROR , 'system_error'); 
        }
        $this->renderJson(Yii::t('common','success'));

    }
    public function actionSendSmsForgetCode(){
        $p = $this->getParams('POST');
        if( !isset($p['country_code']) || empty($p['country_code']) ){
            $this->renderError(Yii::t('common','country_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['mobile']) || empty($p['mobile']) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( isset(Yii::app()->session['sms_forget_code_time']) && time() < Yii::app()->session['sms_forget_code_time'] + SMS_SEND_INTERVAL ){
            $this->renderError(Yii::t('common','sms_interval').' SMS_SEND_INTERVAL ', ErrorCode::USERS_EMPTY);  
        }
        $re = UserModel::model()->getUserByPhone( $p['country_code'] , $p['mobile']) ;
        if( !$re ){
            $this->renderError(Yii::t('common','account_not_exists'), ErrorCode::USERS_ERROR);
        }
        $country_code = trim($p['country_code']);
        $mobile = trim($p['mobile']);
        $mobile = trim($country_code.$mobile , '+');
        $sms = new HeySkyApi();
        $content = Yii::t('common','sms_uppass_code');
        $content = str_replace('{{{sms_expire}}}' , SMS_FORGET_EXPIRE , $content );
        $sms_code = rand(100000,999999);
        $content = str_replace('{{{sms_code}}}' , $sms_code , $content);
        $re = $sms->send( $mobile ,$content);
        if( !$re ){
            $this->renderError(Yii::t('common','sms_send_fail'), ErrorCode::PARAM_EMPTY); 
        }
        $sms_log = new SmsLogModel();
        $sms_log->name = $this->getId().':'.$this->getAction()->getId();
        $sms_log->smsid = $re['mtmsgid'];
        $sms_log->cpid  = $re['cpid'];
        $sms_log->sms_content = $content; 
        $sms_log->content = json_encode( $re , JSON_UNESCAPED_UNICODE );
        $sms_log->ctime = time();
        $re_sms = $sms_log->save();
        Yii::app()->session['sms_forget_code'] = $sms_code;
        Yii::app()->session['sms_forget_code_time'] = time();;
        if( !$re_sms ){
            Yii::log( '写入SmSLog fail '.json_encode( $re , JSON_UNESCAPED_UNICODE ) , CLogger::LEVEL_ERROR , 'system_error'); 
        }
        $this->renderJson(Yii::t('common','success'));

    }
    public function actionSendSmsUpCode(){
        if(!isset($_SESSION['id']) || empty($_SESSION['id'])){
            $this->renderError(Yii::t('common','no_login'), 4); 
        }
        if( isset(Yii::app()->session['sms_uppass_code_time']) && time() < Yii::app()->session['sms_uptpass_code_time'] + SMS_SEND_INTERVAL ){
            $this->renderError(Yii::t('common','sms_interval').' SMS_SEND_INTERVAL ', ErrorCode::USERS_EMPTY);  
        }
        $uid = $_SESSION['id'];
        $user = UserModel::model()->findByPk($_SESSION['id']);
        
        if( empty($user) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::USERS_EMPTY);  
        }
        $mobile = trim($user['country_code'].$user['phone'] , '+');
        $sms_code = rand(100000,999999);
        $content = Yii::t('common','sms_uppass_code');
        $content = str_replace('{{{sms_expire}}}' , SMS_REGISTER_EXPIRE , $content );
        $content = str_replace('{{{sms_code}}}' , $sms_code , $content);
        $sms = new HeySkyApi();
        $re = $sms->send( $mobile ,$content);
        if( !$re ){
            $this->renderError(Yii::t('common','sms_send_fail'), ErrorCode::PARAM_EMPTY); 
        }
        $sms_log = new SmsLogModel();
        $sms_log->name = $this->getId().':'.$this->getAction()->getId();
        $sms_log->smsid = $re['mtmsgid'];
        $sms_log->cpid  = $re['cpid'];
        $sms_log->sms_content = $content; 
        $sms_log->content = json_encode( $re , JSON_UNESCAPED_UNICODE );
        $sms_log->ctime = time();
        $re_sms = $sms_log->save();
        Yii::app()->session['sms_uppass_code'] = $sms_code;
        Yii::app()->session['sms_uppass_code_time'] = time()+ SMS_UPPASS_EXPIRE * 60;
        if( !$re_sms ){
            Yii::log( '写入SmSLog fali '.json_encode( $re , JSON_UNESCAPED_UNICODE ) , CLogger::LEVEL_ERROR , 'system_error'); 
        }
        $this->renderJson(Yii::t('common','success'));


    }
}
    
