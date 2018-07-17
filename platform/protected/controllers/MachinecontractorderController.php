<?php
class MachineContractOrderController extends AjaxController{
    const CANCEL = 5;
    public function actionGetUserList(){
        $p = $this->getParams('REQUEST');
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
        //$uid =1;
        $uid = Yii::app()->session['id']; 
        if( isset($p['status']) && is_numeric($p['status'])){
            $status = $p['status'];
        }
        else{
            $status = '';
        }
        $where = ' where uid=:uid';
        $arr = array(':uid'=>$uid);
        if( $status !== '' ){
            $where .= ' and status=:status';
            $arr[':status'] = $status;          
        }
        if( isset($p['coin_id']) && is_numeric($p['coin_id']) && $p['coin_id']>=0 ){
            $where .=' and coin_id=:coin_id';
            $arr[':coin_id'] = $p['coin_id'];
        }
        $s = 'select * from '.MachineContractOrderModel::model()->tableName().$where.' limit '.($page-1)*$size.','.$size;
        $r = MachineContractOrderModel::model()->findAllBySql( $s , $arr );
        $data = array();
        if( $r ){ 
            foreach( $r as $v ){
                $data[] = $v->attributes;
            }
        }
        $this->renderJson(Yii::t('common','success') , $data);
    }
    public function actionOrder(){
        $p = $this->getParams('POST');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id']<=0 ){
            $this->renderError(Yii::t('common','param_error') , ErrorCode::PARAM_ERROR);
        }
        if( !isset($p['count']) || !preg_match('/^[0-9]+$/', $p['count']) || $p['count']<=0 ){
            $this->renderError(Yii::t('common','param_error') , ErrorCode::PARAM_ERROR);
        }
        $count = $p['count'];
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $mc = MachineContractModel::model()->findBySql( 'select * from '.MachineContractModel::model()->tableName().' where id=:id for update '  , array( ':id' => $p['id'] ) );
            $user_coin = UserLegalCoinModel::model()->findBySql('select * from '.UserLegalCoinModel::model()->tableName().' where uid=:uid for update ' , array(':uid' => Yii::app()->session['id'] ));
            if( empty($mc) ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','system_error2'), ErrorCode::SYSTEM_ERROR); 
            }
            if( $mc->status != 0 ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','contract_status_error'), ErrorCode::SYSTEM_ERROR); 
            }
            if( $mc->total <= $mc->deal_total + $count ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','contract_not_enough'), ErrorCode::SYSTEM_ERROR); 
            }
            $m = MiningMachineModel::model()->find('id=:id', array(':id'=>$mc['machine_id']));
            if(empty($m)){
                $transaction->rollback();
                $this->renderError(Yii::t('common','system_error2'), ErrorCode::SYSTEM_ERROR); 

            }
            $uc = UserCoinModel::model()->find('uid=:uid and coin_id=:coin_id' , array(':uid'=> Yii::app()->session['id'] ,':coin_id'=>$mc->coin_id));
            if(empty($uc)){
                $xx = new UserCoinModel();
                $xx->uid = Yii::app()->session['id'];
                $xx->coin_id = $mc->coin_id;
                $uc_re = $xx->save();
            }
            $uc = UserCoinModel::model()->findBySql('select * from '.UserCoinModel::model()->tableName()." where uid = :uid and coin_id=:coin_id for update",array(':uid'=> Yii::app()->session['id'] ,':coin_id'=>$mc->coin_id));    
            $t = time();
            $total = round($mc->price*$p['count'],8);
            $order = new MachineContractOrderModel();
            $order->mo_id = $mc->id;
            $order->uid = Yii::app()->session['id'];
            $order->machine_id = $mc->machine_id;
            $order->coin_id = $mc->coin_id;
            $order->price = $mc->price;
            $order->order_price = $total;
            $order->power = $m->power;
            $order->total_power = $p['count']* $m->power;
            $order->count = $p['count'];
            $order->ctime = $t;
            $order->uptime = $t;
            $re = $order->save();            
            $re2 = MachineContractModel::model()->updateCounters(array('deal_total'=>$count),'id=:id',array(':id'=>$p['id']));
            $re3 = UserLegalCoinModel::model()->updateCounters(array('usd'=>-$total) , 'uid=:uid',array('uid'=>Yii::app()->session['id']));
            $re4 = UserCoinModel::model()->updateCounters( array('total_machine'=>$count ,'machine_total_investment' => $total ,'total_investment' => $total) , 'uid=:uid and coin_id=:coin_id' , array('uid'=>Yii::app()->session['id'], ':coin_id' => $mc->coin_id ));

            if( !$re || !$re2 || !$re3 || !$re4 ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','order_fail'), ErrorCode::PARAM_EMPTY); 
            }
            $olog = new UserLegalCoinLogModel();
            $olog->name = 'machine_buy';
            $olog->coin_id = $mc->coin_id;
            $olog->o_id = $order->id;
            $olog->machine_id = $order->machine_id;
            $olog->uid = Yii::app()->session['id'];
            $olog->type = 1;
            $olog->mining_type = 1;
            $olog->vol = $total;
            $olog->ctime= $t;
            $re5 = $olog->save();
            if( !$re5 ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','order_fail2'), ErrorCode::PARAM_EMPTY); 
            }
            $transaction->commit(); 
            $this->renderJson(Yii::t('common','success'));

        }catch(Exception $e){
            $transaction->rollback();
            $this->renderError(Yii::t('common','system_error'), ErrorCode::SYSTEM_ERROR); 
        }


    }
}
