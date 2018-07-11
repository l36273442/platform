<?php
class LoginController extends CommonController{
    
	public function actionSignin(){
        if( isset(Yii::app()->session['id']) && !empty( Yii::app()->session['id'] ) && Yii::app()->session['expire'] > time() ){
            $this->redirect(Yii::app()->getBaseUrl().'/site/index');
        }    
        $this->render('signin');
    }
    public function actionLogout(){
        if( isset(Yii::app()->session['id'] )){
            unset(Yii::app()->session['id']);
        }
        if( isset(Yii::app()->session['phone'] )){
            unset(Yii::app()->session['phone']);
        }
        if( isset(Yii::app()->session['expire'] )){
            unset(Yii::app()->session['expire']);
        }
        $this->renderJson(Yii::t('common','success'));

    }
    public function actionResetPassword(){
        if( isset(Yii::app()->session['id']) && !empty( Yii::app()->session['id'] ) && Yii::app()->session['expire'] > time() ){
            $this->redirect(Yii::app()->getBaseUrl().'/site/index');
        }    
        $this->render('resetpassword');
    }
    public function actionDoForgetPassword(){
        $p = $this->getParams('POST');
        if( !isset($p['country_code']) || empty($p['country_code']) ){
            $this->renderError(Yii::t('common','country_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['sms_code']) || empty($p['sms_code']) ){
            $this->renderError(Yii::t('common','sms_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( $p['sms_code'] != $_SESSION['sms_code'] ){
            $this->renderError(Yii::t('common','sms_code_err'), ErrorCode::PARAM_ERROR); 
        }
        if( !isset($_SESSION['sms_code_time']) || $_SESSION['sms_code_time'] + SMS_EXPIRE*60 < time() ){
            if(isset($_SESSION['sms_code_time']) ){
                unset(Yii::app()->session['sms_code_time']);
            }
            if(isset($_SESSION['sms_code'])){
                unset(Yii::app()->session['sms_code']);
            }
            $this->renderError(Yii::t('common','sms_code_timeout'), ErrorCode::PARAM_ERROR); 
        }
        if( !isset($p['mobile']) || empty($p['mobile']) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['password']) || empty($p['password']) ){
            $this->renderError(Yii::t('common','user_password_err'), ErrorCode::PARAM_EMPTY); 
        }
        if( strlen($p['password']) < 6 || strlen($p['password']) > 16 ){
            $this->renderError(Yii::t('common','password_len'), ErrorCode::PARAM_ERROR); 
        }
        if( !$this->check_password($p['password']) ){
            $this->renderError(Yii::t('common','password_type'), ErrorCode::PARAM_ERROR); 
        }
        $p['country_code'] = trim($p['country_code']);
        $p['mobile'] = trim($p['mobile']);

        $user = UserModel::model()->getUserByPhone( $p['country_code'] , $p['mobile']) ;
        if( !$user ){
            $this->renderError(Yii::t('common','account_not_exists'), ErrorCode::USERS_ERROR);
        }
        $pass = md5( $p['password'] ); 
        if( $pass == $user['password'] ){
            $this->renderError(Yii::t('common','password_same'), ErrorCode::PARAM_EMPTY);  
        }
        $re = UserModel::model()->updateByPk($user['id'] , array('password' => $pass , 'uptime' => time()));
        if( $re ){
            unset(Yii::app()->session['code']);
            unset(Yii::app()->session['code_timeout']);
            unset(Yii::app()->session['sms_code']);
            unset(Yii::app()->session['sms_code_time']);
            $this->renderJson(Yii::t('common','success'));
        }
        else{
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);

        }


    }
    public function actionDoLogin(){
        $p = $this->getParams('POST');
        if( !isset($p['country_code']) || empty($p['country_code']) ){
            $this->renderError(Yii::t('common','country_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['mobile']) || empty($p['mobile']) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['password']) || empty($p['password']) ){
            $this->renderError(Yii::t('common','user_password_err'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['sms_code']) || empty($p['sms_code']) ){
            $this->renderError(Yii::t('common','sms_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( $p['sms_code'] != $_SESSION['sms_code'] ){
            $this->renderError(Yii::t('common','sms_code_err'), ErrorCode::PARAM_ERROR); 
        }
        if( !isset($_SESSION['sms_code_time']) || $_SESSION['sms_code_time'] + SMS_EXPIRE*60 < time() ){
            if(isset($_SESSION['sms_code_time']) ){
                unset(Yii::app()->session['sms_code_time']);
            }
            if(isset($_SESSION['sms_code'])){
                unset(Yii::app()->session['sms_code']);
            }
            $this->renderError(Yii::t('common','sms_code_timeout'), ErrorCode::PARAM_ERROR); 
        }

        $re = UserModel::model()->getUserByPhone( $p['country_code'] , $p['mobile']) ;
        if( md5($p['password']) != $re['password']){
            $this->renderError( Yii::t('common','user_password_err'), ErrorCode::USERS_PASSWORD_ERR );
        }
        if( empty($re) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::USERS_ERROR);
        }
        unset(Yii::app()->session['sms_code']);
        unset(Yii::app()->session['sms_code_time']);
        if( $re['status'] != 0 ){
            $this->renderError(Yii::t('common','user_deny'), ErrorCode::USERS_DENY);
        }
        setcookie("id", $re['id'], time()+86400);
        Yii::app()->session['phone'] = $re['phone'];
        Yii::app()->session['id'] = $re['id'];
        $this->user = $re;

        $this->renderJson(Yii::t('common','success'));
    }
}
