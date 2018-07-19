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
        if( isset($p['id']) && is_numeric($p['id']) && $p['id'] > 0 ){
            $s = 'select * from '.UserCoinLogModel::model()->tableName().' where type=:type and coin_id=:coin_id and mining_type=:mining_type and uid=:uid  order by id desc limit '.($page-1)*$size.','.$size;
            $pa = array(':uid'=>$uid,':type'=>0,':mining_type'=>0,':coin_id'=>$p['id']);
        
        }else{
            $s = 'select * from '.UserCoinLogModel::model()->tableName().' where type=:type and mining_type=:mining_type and uid=:uid  order by id desc limit '.($page-1)*$size.','.$size;
            $pa = array(':uid'=>$uid,':type'=>0,':mining_type'=>0);
        }
        $b = CoinModel::model()->findBySql("select id,name,latest_price from platform_coin where name = 'btc' ");
        if($b ){
            $btc['id'] = $b->id;
            $btc['name'] = $b->name;
            $btc['latest_price'] = $b->latest_price;
        }
        else{
            $btc = array();
        }
        $l = UserCoinLogModel::model()->findAllBySql($s , $pa );
        $data = $cids = $c_k = array();
        if($l){
            foreach( $l as $v ){
                $r = $v->attributes;
                $r['count'] = sprintf("%.4f" ,$v['count']);
                $r['real_count'] = sprintf("%.4f" ,$v['real_count']);
                $r['electricity_fee'] = sprintf("%.4f" ,$v['electricity_fee']);
                $r['manage_fee'] = sprintf("%.4f" ,$v['manage_fee']);
                $r['release_time_text'] = date('Y-m-d' ,$v['release_time']);
                $cids[] = $v['coin_id'];
                $data[] = $r;
            }
            $coins = CoinModel::model()->getCoinsByIds($cids);
            if( $coins ){
                foreach( $coins as $v ){
                    $c_k[$v['id']] = $v;
                }
            }
            foreach( $data as &$v ){
                $v['coin_name'] = isset($c_k[$v['coin_id']])?$c_k[$v['coin_id']]['name']:'';
                $v['btc_price'] = isset($c_k[$v['coin_id']])?($v['real_count']*$c_k[$v['coin_id']]['latset_btc_price']):'';
                $v['btc_price'] = sprintf("%.8f",$v['btc_price']);
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
        if( isset($p['id']) && is_numeric($p['id']) && $p['id'] > 0 ){
            $s = 'select * from '.UserCoinLogModel::model()->tableName().' where type=:type and coin_id=:coin_id and mining_type=:mining_type and uid=:uid  order by id desc limit '.($page-1)*$size.','.$size;
            $pa = array(':uid'=>$uid,':type'=>0,':mining_type'=>1,':coin_id'=>$p['id']);
        
        }else{
            $s = 'select * from '.UserCoinLogModel::model()->tableName().' where type=:type and mining_type=:mining_type and uid=:uid  order by id desc limit '.($page-1)*$size.','.$size;
            $pa = array(':uid'=>$uid,':type'=>0,':mining_type'=>1);
        }
        $l = UserCoinLogModel::model()->findAllBySql($s , $pa );
        $data = $cids = $c_k = array();
        if($l){
            foreach( $l as $v ){
                $r = $v->attributes;
                $r['count'] = sprintf("%.4f" ,$v['count']);
                $r['release_time_text'] = date('Y-m-d' ,$v['release_time']);
                $r['real_count'] = sprintf("%.4f" ,$v['real_count']);
                $r['electricity_fee'] = sprintf("%.4f" ,$v['electricity_fee']);
                $r['manage_fee'] = sprintf("%.4f" ,$v['manage_fee']);
                $cids[] = $v['coin_id'];
                $data[] = $r;
            }
            $coins = CoinModel::model()->getCoinsByIds($cids);
            if( $coins ){
                foreach( $coins as $v ){
                    $c_k[$v['id']] = $v;
                }
            }
            foreach( $data as &$v ){
                $v['coin_name'] = isset($c_k[$v['coin_id']])?$c_k[$v['coin_id']]['name']:'';
                $v['btc_price'] = isset($c_k[$v['coin_id']])?($v['real_count']*$c_k[$v['coin_id']]['latset_btc_price']):'';
                $v['btc_price'] = sprintf("%.8f",$v['btc_price']);
            }
        }
        $this->renderJson(Yii::t('common','success') , $data);

    }
    public function actionGetPowerBuyRecord(){
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
        if( isset($p['id']) && is_numeric($p['id']) && $p['id'] > 0 ){
            $s = 'select * from '.UserLegalCoinLogModel::model()->tableName().' where type=:type and coin_id=:coin_id and mining_type=:mining_type and uid=:uid  order by id desc limit '.($page-1)*$size.','.$size;
            $pa = array(':uid'=>$uid,':type'=>1,':mining_type'=>0,':coin_id'=>$p['id']);
        
        }else{
            $s = 'select * from '.UserLegalCoinLogModel::model()->tableName().' where type=:type and mining_type=:mining_type and uid=:uid  order by id desc limit '.($page-1)*$size.','.$size;
            $pa = array(':uid'=>$uid,':type'=>1,':mining_type'=>0);
        }
        $l = UserLegalCoinLogModel::model()->findAllBySql($s , $pa );
        $data = array();
        $cids = $c_k = array();
        if($l){
            foreach( $l as $v ){
                $r = array();
                $r = $v->attributes;
                $r['vol'] = sprintf("%.4f" , $r['vol']);
                $cids[] = $v['coin_id'];
                $data[] = $r;
            }
            $coins = CoinModel::model()->getCoinsByIds($cids);
            if( $coins ){
                foreach( $coins as $v ){
                    $c_k[$v['id']] = $v;
                }
            }
            foreach ($data as &$v ){
                $v['coin_name'] = isset($c_k[$v['coin_id']])?$c_k[$v['coin_id']]['name']:'';
            }
        }
        $this->renderJson(Yii::t('common','success') , $data);
    }
    public function actionGetMachineBuyRecord(){
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
        if( isset($p['id']) && is_numeric($p['id']) && $p['id'] > 0 ){
            $s = 'select * from '.UserLegalCoinLogModel::model()->tableName().' where type=:type and coin_id=:coin_id and mining_type=:mining_type and uid=:uid  order by id desc limit '.($page-1)*$size.','.$size;
            $pa = array(':uid'=>$uid,':type'=>1,':mining_type'=>1,':coin_id'=>$p['id']);
        
        }else{
            $s = 'select * from '.UserLegalCoinLogModel::model()->tableName().' where type=:type and mining_type=:mining_type and uid=:uid  order by id desc limit '.($page-1)*$size.','.$size;
            $pa = array(':uid'=>$uid,':type'=>1,':mining_type'=>1);
        }
        $l = UserLegalCoinLogModel::model()->findAllBySql($s , $pa );
        $data = array();
        $cids = $c_k = $ms = $m_k = array();
        if($l){
            foreach( $l as $v ){
                $r = array();
                $r = $v->attributes;
                $r['vol'] = sprintf("%.4f" , $r['vol']);
                $cids[] = $v['coin_id'];
                $ms[] = $v['machine_id'];
                $data[] = $r;
            }
            $coins = CoinModel::model()->getCoinsByIds($cids);
            if( $coins ){
                foreach( $coins as $v ){
                    $c_k[$v['id']] = $v;
                }
            }
            $mac = MiningMachineModel::model()->getMachinesByIds($ms);
            if($mac ){
                foreach( $mac as $v ){
                    $m_k[$v['id']] = $v;
                }
            }
            foreach ($data as &$v ){
                $v['coin_name'] = isset($c_k[$v['coin_id']])?$c_k[$v['coin_id']]['name']:'';
                $v['machine_name'] = isset($c_k[$v['machine_id']])?$c_k[$v['machine_id']]['name']:'';
            }
        }
        $this->renderJson(Yii::t('common','success') , $data);
    }

}
