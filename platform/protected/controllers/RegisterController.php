<?php
class RegisterController extends CommonController{
    
    public function actionRegister(){
        if( isset($_SESSION['id']) && !empty( $_SESSION['id'] ) ){
            $this->redirect(Yii::app()->getBaseUrl().'/site/index');
        }    
        $p = $this->getParams('REQUEST');
        $arr = array();
        if( isset($p['invite']) && !empty($p['invite']) ){
            $arr['invite'] = $p['invite'];
        }
        else{
            $arr['invite'] = '';
        } 
        $this->render('register',$arr);
    }

	public function actionDoRegister(){
        $p = $this->getParams('POST');
        if( !isset($p['country_code']) || empty($p['country_code']) ){
            $this->renderError(Yii::t('common','country_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['img_code']) || empty($p['img_code']) ){
            $this->renderError(Yii::t('common','img_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( $p['img_code'] != $_SESSION['code'] ){
            $this->renderError(Yii::t('common','img_code_err'), ErrorCode::PARAM_ERROR); 
        }
        if( $_SESSION['code_timeout'] < time() ){
            unset(Yii::app()->session['code']);
            unset(Yii::app()->session['code_timeout']);
            $this->renderError(Yii::t('common','img_code_timeout'), ErrorCode::PARAM_ERROR); 
        }
        if( !isset($p['sms_code']) || empty($p['sms_code']) ){
            $this->renderError(Yii::t('common','sms_code_empty'), ErrorCode::PARAM_EMPTY); 
        }
        if( $p['sms_code'] != $_SESSION['sms_register_code'] ){
            $this->renderError(Yii::t('common','sms_code_err'), ErrorCode::PARAM_ERROR); 
        }
        if( $_SESSION['sms_register_code_expire'] < time() ){
            unset(Yii::app()->session['sms_register_code']);
            unset(Yii::app()->session['sms_register_code_expire']);
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

        $re = UserModel::model()->getUserByPhone( $p['country_code'] , $p['mobile']) ;
        if( !empty($re) ){
            $this->renderError(Yii::t('common','account_exists'), ErrorCode::USERS_ERROR);
        }
        
        $user = new UserModel();
        $user->phone = $p['mobile'];
        $user->country_code = $p['country_code'];
        $t = time();
        $user->password = md5($p['password']);
        $user->ctime = $t;
        $user->uptime = $t;
        if( isset($p['invite']) && !empty($p['invite']) ){
            $invite_info = UserInviteModel::model()->find('invite_code=:invite_code' , array(':invite_code' => $p['invite'] ));
            if( $invite_info ){
                $user->invite_uid = $invite_info['uid'];
            }
        }
        $re = $user->save();
        if( $re ){
            unset(Yii::app()->session['code']);
            unset(Yii::app()->session['code_timeout']);
            unset(Yii::app()->session['sms_register_code']);
            unset(Yii::app()->session['sms_register_code_expire']);
            if( $user->invite_uid ){
                UserInviteModel::model()->updateCounters(array('sum'=>1),'uid=:uid',array(':uid'=>$user->invite_uid));
            }
            $invit_code = $this->getInvite( $user->primaryKey);
            if( $invit_code ){
                $in = new UserInviteModel();
                $in->uid =  $user->primaryKey;
                $in->invite_code = $invit_code;
                $re_in = $in->save();
                if( !$re_in ){
                    Yii::error('用户id'.$user->primaryKey.'写入邀请码失败');
                }
            }
            else{
                Yii::error('用户id'.$user->primaryKey.'生成邀请码失败');
            }
            $this->renderJson(Yii::t('common','success'));
        }
        else{
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
    }

}
