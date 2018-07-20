<?php
class RegisterController extends CommonController{
    
    public function actionSignup(){
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
        $this->render('signup',$arr);
    }

	public function actionDoRegister(){
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

        $re = UserModel::model()->getUserByPhone( $p['country_code'] , $p['mobile']) ;
        if( !empty($re) ){
            $this->renderError(Yii::t('common','account_exists'), ErrorCode::USERS_ERROR);
        }
        $transaction = Yii::app()->db->beginTransaction();
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
            $uc = new UserLegalCoinModel();
            $uc->uid = $user->id;
            $uc->ctime = $t;
            $re4 = $uc->save();
            if( !$re4 ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
            }
            unset(Yii::app()->session['sms_code']);
            unset(Yii::app()->session['sms_code_time']);
            if( $user->invite_uid ){
                UserInviteModel::model()->updateCounters(array('sum'=>1),'uid=:uid',array(':uid'=>$user->invite_uid));
                $invite_config = InviteConfigModel::model()->find();
                if( $invite_config && $invite_config->coin_id > 0 && $invite_config->reward_count > 0 ){
                    $iuc = UserCoinModel::model()->find('coin_id=:coin_id and uid=:uid' , array(':coin_id' => $invite_config->coin_id,':uid'=> $user->invite_uid ));
                    if( $iuc ){
                        $re8 = UserCoinModel::model()->findBySql('select * from platform_user_coin_log where coin_id='.$invite_config->coin_id.' and uid ='.$user->invite_uid.' for update');
                        if( !$re8 ){
                            $transaction->rollback();
                            $this->renderError(Yii::t('common','error2') , ErrorCode::SYSTEM_ERROR);

                        }
                        $re7 = UserCoinModel::model()->updateCounters(array('total_power'=>$invite_config['reward_count'],'total_invite_power' => $invite_config['reward_count']),'uid=:uid and coin_id=:coin_id' , array(':uid'=>$user->invite_uid,':coin_id' => $invite_config->coin_id));
                        if( !$re7 ){
                            $transaction->rollback();
                            $this->renderError(Yii::t('common','error3') , ErrorCode::SYSTEM_ERROR);
                        }
                        
                    }
                    else{
                        $inu = new UserCoinModel();
                        $inu->uid=$user->invite_uid;
                        $inu->coin_id = $invite_config->coin_id;
                        $inu->total_invite_power = $invite_config['reward_count'];
                        $inu->total_power = $invite_config['reward_count'];
                        $re10 = $inu->save();
                        if( !$re10 ){
                            $transaction->rollback();
                            $this->renderError(Yii::t('common','error4') , ErrorCode::SYSTEM_ERROR);
                        }
                    }
                    $iu =  new PowerLogModel();
                    $iu->coin_id = $invite_config->coin_id;
                    $iu->uid = $user->invite_uid;
                    $iu->type = 2;
                    $iu->name = 'power_invite_reward';
                    $iu->count = $invite_config['reward_count'];
                    $in->relation_uid =  $user->primaryKey;
                    $iu->ctime = $t;
                    $re9 = $iu->save();
                    if( !$re9 ){
                        $transaction->rollback();
                        $this->renderError(Yii::t('common','error5') , ErrorCode::SYSTEM_ERROR);
                    }
                }
            }
            $invit_code = $this->getInvite( $user->primaryKey);
            if( $invit_code ){
                $in = new UserInviteModel();
                $in->uid =  $user->primaryKey;
                $in->invite_code = $invit_code;
                $re_in = $in->save();
                if( !$re_in ){
                    $transaction->rollback();
                    $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
                }
            }
            else{
                $transaction->rollback();
                $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
            }
        }
        else{
            $transaction->rollback();
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
        $transaction->commit(); 
        $this->renderJson(Yii::t('common','success'));
    }

}
