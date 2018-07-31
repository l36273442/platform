<?php
class CoinController extends Controller{
    public function actionAddAddress(){
        $p = $this->getparams('POST');
        $uid = Yii::app()->session['id'];
        if( !isset($p['address']) || empty($p['address']) ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        if( !isset($p['coin_id']) || !is_numeric($p['coin_id']) || $p['coin_id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        if( !isset($p['remark']) || empty($p['remark']) ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        if( !isset($p['tpassword']) || empty($p['tpassword']) ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        $user = UserModel::model()->find('id=:id', array(':id'=>$uid));
        if(empty($user)){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
        /*
        if( md5($p['tpassword']) != $user->tpassword ){
            $this->renderError(Yii::t('common','user_password_err'), ErrorCode::PARAM_EMPTY);  
        }
         */
        $t = time();
        $a = new CoinAddressModel();
        $a->coin_id = $p['coin_id'];
        $a->address = $p['address'];
        $a->remark  = $p['remark'];
        $a->uid = $uid;
        $a->ctime = $t;
        $a->uptime = $t;
        $re = $a->save();
        if($re ){
            $this->renderJson(Yii::t('common','success'));
        }
        $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
    }
    public function actionGetUserCoinAddress(){
        $p = $this->getparams('REQUEST');
        $uid = Yii::app()->session['id'];
        if( !isset($p['coin_id']) || !is_numeric($p['coin_id']) || $p['coin_id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        $a = CoinAddressModel::model()->findAll('uid=:uid and coin_id=:coin_id and status=:status' , array(':uid'=>$uid , ':coin_id' => $p['coin_id'],':status' =>0));
        $arr = array();
        if( $a ){
            foreach( $a as $v ){
                $r = array();
                $r = $v->attributes;
                $r['ctime_text'] = date('Y-m-d H:i:s' , $r['ctime']);
                $arr[] = $r;
            }
    
        }
        $this->renderJson(Yii::t('common','success'),$arr);


    }
    public function actionWithdraw(){
        $p = $this->getparams('POST');
        $uid = Yii::app()->session['id'];
        if( !isset($p['coin_id']) || !is_numeric($p['coin_id']) || $p['coin_id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        if( !isset($p['count']) || !is_numeric($p['count']) || $p['count'] <= 0 ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        if( !isset($p['address_id']) || !is_numeric($p['address_id']) || $p['address_id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        $a = CoinAddressModel::model()->find('id=:id' , array(':id'=>$p['address_id']));
        if(empty($a)){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
        if($a->coin_id != $p['coin_id']){
            echo 434343;
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        $c = CoinModel::model()->find('id=:id',array(':id'=>$p['coin_id']));
        if(empty($c)){
            $this->renderError(Yii::t('common','system_error2') , ErrorCode::SYSTEM_ERROR);
        }
        if( !isset($p['tpassword']) || empty($p['tpassword']) ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
        $uc = UserCoinModel::model()->find('uid=:uid and coin_id=:coin_id' ,array(':uid'=>$uid, ':coin_id'=>$p['coin_id']));
        if( empty($uc) ){
            $w = new UserCoinModel();
            $w->uid = $uid;
            $w->coin_id = $p['coin_id'];
            $re = $w->save();
            if(!$re){
                $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
            }
            $this->renderError(Yii::t('common','account_not_enough') , ErrorCode::SYSTEM_ERROR);
        }
        if($uc->current_total < $p['count'] ){
            $this->renderError(Yii::t('common','account_not_enough') , ErrorCode::SYSTEM_ERROR);
        }
        $user = UserModel::model()->find('id=:id', array(':id'=>$uid));
        if(empty($user)){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
        /*
        if( md5($p['tpassword']) != $user->tpassword ){
            $this->renderError(Yii::t('common','user_password_err'), ErrorCode::PARAM_EMPTY);  
        }
         */
        $transaction = Yii::app()->db->beginTransaction();
        try{ 
            $real_count = $p['count'] - $c->extract_fee;
            $t = time();
            $x = new CoinOrderModel();
            $x->coin_id = $p['coin_id'];
            $x->uid = $uid;
            $x->count = $p['count'];
            $x->extract_fee = $c->extract_fee;
            $x->real_count = $real_count;
            $x->address_id = $p['address_id'];
            $x->address = $a->address;
            $x->ctime = $t;
            $x->uptime = $t;
            if( $c->large_amount_withdraw !=0 && $p['count'] >= $c->large_amount_withdraw ){
                $x->status = 1;
            }
            $re = $x->save();
            if( !$re ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','order_fail2'), ErrorCode::PARAM_EMPTY); 
            }
            $arr = array(':uid'=>$uid , ':coin_id' => $p['coin_id']);
            $s = 'select * from '.UserCoinModel::model()->tableName().' where uid=:uid and coin_id=:coin_id for update';
            $uc = UserCoinModel::model()->findBySql($s , $arr );
            if(!$uc){
                $transaction->rollback();
                $this->renderError(Yii::t('common','order_fail3'), ErrorCode::PARAM_EMPTY); 
            }
            $re3 = UserCoinModel::model()->updateCounters(array('current_total'=>-$p['count']),'uid=:uid and coin_id=:coin_id',array(':uid'=>$uid,':coin_id'=>$p['coin_id']));
            if(!$re3){
                $transaction->rollback();
                $this->renderError(Yii::t('common','order_fail3'), ErrorCode::PARAM_EMPTY); 
            }
            
            $ucl = new UserCoinLogModel();
            $ucl->uid = $uid;
            $ucl->coin_id = $p['coin_id'];
            $ucl->name = 'coin_withdraw'; 
            $ucl->type = 3;
            $ucl->total = $uc->current_total;
            $ucl->count = $p['count'];
            $ucl->real_count = $real_count;
            $ucl->manage_fee = $c->extract_fee;
            $ucl->ctime = $t;
            $ucl->oid = $x->id;
            $re4 = $ucl->save();
            if( !$re4 ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','order_fail4'), ErrorCode::PARAM_EMPTY); 
            }
            $transaction->commit(); 
            $this->renderJson(Yii::t('common','success'));
        }catch(Exception $e){
            $transaction->rollback();
            $this->renderError(Yii::t('common','system_error'), ErrorCode::SYSTEM_ERROR); 
        }
    }
    public function actionGetWithdrawList(){
        $uid = Yii::app()->session['id'];
        $p = $this->getparams('REQUEST');
        
        if( !isset($p['coin_id']) || !is_numeric($p['coin_id']) || $p['coin_id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);  
        }
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
        $where = ' where uid=:uid and coin_id=:coin_id';
        $arr = array(':uid'=>$uid,':coin_id'=>$p['coin_id']);

        $s = 'select * from '.CoinOrderModel::model()->tableName().$where.' limit '.($page-1)*$size.','.$size;
        $r = CoinOrderModel::model()->findAllBySql( $s , $arr );
        $arr = array();
        if( $r ){
            foreach( $r as $v ){
                $r = array();
                $r = $v->attributes;
                $r['ctime_text'] = date('Y-m-d H:i:s' , $r['ctime']);
                $r['uptime_text'] = date('Y-m-d H:i:s' , $r['uptime']);
                $r['co_status_text'] = Yii::t('common','co_status_text'.$r['status']); 
                $arr[] = $r;
            }
        }
        $this->renderJson(Yii::t('common','success'),$arr);
    }

}
