<?php
class SmsController extends CommonController{
    public function actionsendSmsLoginCode(){
        $p = $this->getParams('POST');
        if( !isset($p['country_code']) || empty($p['country_code']) ){
            $this->renderError(Yii::t('common','country_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['mobile']) || empty($p['mobile']) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['password']) || empty($p['password']) ){
            $this->renderError(Yii::t('common','img_code_err'), ErrorCode::PARAM_ERROR);  
        }
        $re = UserModel::model()->getUserByPhone( $p['country_code'] , $p['mobile']) ;
        if( md5($p['password']) != $re['password'] ){
            $this->renderError(Yii::t('common','user_password_err'), ErrorCode::USERS_ERROR);
        }

        $country_code = trim($p['country_code']);
        $mobile = trim($p['mobile']);
        $mobile = trim($country_code.$mobile , '+');
        $sms = new HeySkyApi();
        $content = Yii::t('common','sms_uppass_code');
        $content = str_replace('{{{sms_expire}}}' , SMS_EXPIRE , $content );
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
        $sms_log->phone = $mobile;
        $sms_log->sms_content = $content; 
        $sms_log->content = json_encode( $re , JSON_UNESCAPED_UNICODE );
        $sms_log->ctime = time();
        $re_sms = $sms_log->save();
        Yii::app()->session['sms_code'] = $sms_code;
        Yii::app()->session['sms_code_time'] = time();
        if( !$re_sms ){
            Yii::log( '写入SmSLog fail '.json_encode( $re , JSON_UNESCAPED_UNICODE ) , CLogger::LEVEL_ERROR , 'system_error'); 
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
        
        if( !isset($p['code']) || $p['code'] != $_SESSION['code'] ){
            $this->renderError(Yii::t('common','img_code_err'), ErrorCode::PARAM_ERROR);  
        }
        
        $country_code = trim($p['country_code']);
        $mobile = trim($p['mobile']);
        $mobile = trim($country_code.$mobile , '+');
        $sms = new HeySkyApi();
        $content = Yii::t('common','sms_uppass_code');
        $content = str_replace('{{{sms_expire}}}' , SMS_EXPIRE , $content );
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
        $sms_log->phone = $mobile;
        $sms_log->sms_content = $content; 
        $sms_log->content = json_encode( $re , JSON_UNESCAPED_UNICODE );
        $sms_log->ctime = time();
        $re_sms = $sms_log->save();
        Yii::app()->session['sms_code'] = $sms_code;
        Yii::app()->session['sms_code_time'] = time();
        unset($_SESSION['code']);
        if( !$re_sms ){
            Yii::log( '写入SmSLog fail '.json_encode( $re , JSON_UNESCAPED_UNICODE ) , CLogger::LEVEL_ERROR , 'system_error'); 
        }
        $this->renderJson(Yii::t('common','success'));

    }
}
    
