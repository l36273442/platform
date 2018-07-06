<?php
class UserController extends AjaxController{
    
    public function actionDoTradePass(){
        $p = $this->getParams('POST');
        if( !isset($p['trade_password']) || empty($p['trade_password']) ){
            $this->renderError(Yii::t('common','trade_password_err'), ErrorCode::PARAM_EMPTY); 
        }
        if( strlen($p['trade_password']) < 6 || strlen($p['trade_password']) > 16 ){
            $this->renderError(Yii::t('common','password_len'), ErrorCode::PARAM_EMPTY); 
        } 
        if( !isset($p['sms_code']) || empty($p['sms_code']) ){
            $this->renderError(Yii::t('common','sms_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( $p['sms_code'] != $_SESSION['sms_uptpass_code'] ){
            $this->renderError(Yii::t('common','sms_code_err'), ErrorCode::PARAM_EMPTY);  
        }
        if( $_SESSION['sms_uptpass_code_expire'] < time()){
            unset(Yii::app()->session['sms_uptpass_code']);
            unset(Yii::app()->session['sms_uptpass_code_expire']);
            $this->renderError(Yii::t('common','sms_code_timeout'), ErrorCode::PARAM_EMPTY);  
        }
        $user = UserModel::model()->findByPk($_SESSION['id']);
        if( empty($user) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::USERS_EMPTY);  
        }

        $tp = md5( $p['trade_password'] ); 
        if( $tp == $user['tpassword'] ){
            $this->renderError(Yii::t('common','password_same'), ErrorCode::PARAM_EMPTY);  
        }
        $re = UserModel::model()->updateByPk($user['id'] , array('tpassword' => $tp));
        if( $re ){
            unset(Yii::app()->session['sms_uptpass_code']);
            unset(Yii::app()->session['sms_uptpass_code_expire']);
            $this->renderJson(Yii::t('common','success'));
        }
        else{
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);

        }
    }
    public function actionDoUpPass(){
        $p = $this->getParams('POST');
        if( !isset($p['old_password']) || empty($p['old_password']) ){
            $this->renderError(Yii::t('common','password_err'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['password']) || empty($p['password']) ){
            $this->renderError(Yii::t('common','password_err'), ErrorCode::PARAM_EMPTY); 
        }
        if( strlen($p['password']) < 6 || strlen($p['password']) > 16 ){
            $this->renderError(Yii::t('common','password_len'), ErrorCode::PARAM_EMPTY); 
        } 
        if( !$this->check_password($p['password']) ){
            $this->renderError(Yii::t('common','password_type'), ErrorCode::PARAM_ERROR); 
        }
        if( !isset($p['sms_code']) || empty($p['sms_code']) ){
            $this->renderError(Yii::t('common','sms_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( $p['sms_code'] != $_SESSION['sms_uppass_code'] ){
            $this->renderError(Yii::t('common','sms_code_err'), ErrorCode::PARAM_EMPTY);  
        }
        if( $_SESSION['sms_uppass_code_time'] + SMS_UPPASS_EXPIRE * 60  < time()){
            unset(Yii::app()->session['sms_uppass_code']);
            unset(Yii::app()->session['sms_uppass_code_time']);
            $this->renderError(Yii::t('common','sms_code_timeout'), ErrorCode::PARAM_EMPTY);  
        }
        $user = UserModel::model()->findByPk($_SESSION['id']);
        if( empty($user) ){
            $this->renderError(Yii::t('common','account_empty'), ErrorCode::USERS_EMPTY);  
        }

        if( md5( $p['old_password']) != $user['password'] ){
            $this->renderError(Yii::t('common','old_password_err'), ErrorCode::PARAM_EMPTY);  
        }
        $pass = md5( $p['password'] ); 
        if( $pass == $user['password'] ){
            $this->renderError(Yii::t('common','password_same'), ErrorCode::PARAM_EMPTY);  
        }
        $re = UserModel::model()->updateByPk($user['id'] , array('password' => $pass , 'uptime' => time()));
        if( $re ){
            unset(Yii::app()->session['sms_uppass_code']);
            unset(Yii::app()->session['sms_uppass_code_time']);
            $this->renderJson(Yii::t('common','success'));
        }
        else{
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);

        }

    }
    public function actionGetPowerRecord(){
        $p = $this->getParams('REQUEST');
        //$uid = 1;
        $uid = Yii::app()->session['id']; 
        if( !isset($p['size']) || !is_numeric($p['size']) || $p['size'] <= 0 ){
            $size = $this->size;
        }
        else{
            $size = $p['size'];
        }
        if( $size > $this->maxSize ){
            $size = $this->maxSize;
        }     
        if( !isset($p['page']) || !is_numeric($p['page']) || $p['page'] <= 0 ){
            $page = 1;
        }
        else{
            $page = $p['page'];
        }
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_ERROR);  
        }
        $s = 'select * from '.UserCoinLogModel::model()->tableName().' where type=:type and coin_id=:coin_id and mining_type=:mining_type and uid=:uid limit '.($page-1)*$size.','.$size;
        $l = UserCoinLogModel::model()->findAllBySql($s , array(':uid'=>$uid,':type'=>0,':mining_type'=>0,':coin_id'=>$p['id']));
        $data = array();
        if($l){
            foreach( $l as $v ){
                $data[] = $v->attributes;
            }
        }
        $this->renderJson(Yii::t('common','success') , $data);

    }
    public function actionGetMachineRecord(){
        $p = $this->getParams('REQUEST');
        //$uid = 1;
        $uid = Yii::app()->session['id']; 
        if( !isset($p['size']) || !is_numeric($p['size']) || $p['size'] <= 0 ){
            $size = $this->size;
        }
        else{
            $size = $p['size'];
        }
        if( $size > $this->maxSize ){
            $size = $this->maxSize;
        }     
        if( !isset($p['page']) || !is_numeric($p['page']) || $p['page'] <= 0 ){
            $page = 1;
        }
        else{
            $page = $p['page'];
        }
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_ERROR);  
        }
        $s = 'select * from '.UserCoinLogModel::model()->tableName().' where type=:type and coin_id=:coin_id and mining_type=:mining_type and uid=:uid limit '.($page-1)*$size.','.$size;
        $l = UserCoinLogModel::model()->findAllBySql($s , array(':uid'=>$uid,':type'=>0,':mining_type'=>1,':coin_id'=>$p['id']));
        $data = array();
        if($l){
            foreach( $l as $v ){
                $data[] = $v->attributes;
            }
        }
        $this->renderJson(Yii::t('common','success') , $data);

    }

}
