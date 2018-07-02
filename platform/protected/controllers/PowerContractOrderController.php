<?php
class PowerContractOrderController extends AjaxController{
    public $pay_time_out = 1800;//订单支付默认超时时间
    const CANCEL = 5;
    public function actiongetUserOrderList(){
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
        $uid = Yii::app()->session['id']; 
        if( isset($p['status']) && is_numeric($p['status'])){
            $status = $p['status'];
        }
        else{
            $status = '';
        }
        $list = PowerContractOrderModel::model()->getList( $uid , $status  , $page , $size );
        if( empty($list) ){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
        if($list['total'] > 0 ){
            $coin_id = $machine_id = $unit_id = $c_id = array();
            foreach( $list['list'] as $v ){
                $c_id[] = $v['cid'];
            }
            $contract  = PowerContractModel::model()->getContractsByIds($c_id );
            $contract_key = $this->RowsToArr($contract);

            foreach( $contract as $v ){
                if( !in_array( $v['coin_id'] , $coin_id ) ){
                    $coin_id[] = $v['coin_id'];
                }
                if( !in_array( $v['unit_id'] , $unit_id ) ){
                    $unit_id[] = $v['unit_id'];
                }
                if( !in_array( $v['machine_id'] , $machine_id ) ){
                    $machine_id[] = $v['machine_id'];
                }   
            }
            $coins = CoinModel::model()->getCoinsByIds($coin_id );
            $coins_key = $this->RowsToArr($coins);
            $machine = MiningMachineModel::model()->getMachinesByIds($machine_id );
            $machine_key = $this->RowsToArr($machine);
            $unit = ComputingPowerUnitModel::model()->getUnitsByIds($unit_id );
            $unit_key = $this->RowsToArr($unit);

            foreach( $list['list'] as &$v ){
                $v['pay_time'] = ($v['pay_time']-time() > 0 )? ($v['pay_time']-time()):0;
                $v['contract_name'] = $contract_key[$v['cid']]['name'];
                $v['start_time']  = $contract_key[$v['cid']]['start_time'];
                $v['manage_fee']  = $contract_key[$v['cid']]['manage_fee'];
                $v['electricity_fee']  = $contract_key[$v['cid']]['electricity_fee'];
                $v['coin_id'] = $contract_key[$v['cid']]['coin_id'];
                $v['coin_name'] = $coins_key[$contract_key[$v['cid']]['coin_id']]['name'];
                $v['machine_id'] = $contract_key[$v['cid']]['machine_id'];
                $v['machine_name'] = $machine_key[$contract_key[$v['cid']]['machine_id']]['name'];
                $v['unit_id'] = $contract_key[$v['cid']]['unit_id'];
                $v['unit_name'] = $unit_key[$contract_key[$v['cid']]['unit_id']]['name'];
            }
        }
        $this->renderJson(Yii::t('common','success'), $list);
        
    }
    public function actionOrder(){
        $p = $this->getParams('POST');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['count']) || !is_numeric($p['count']) ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY); 
        }
        if( !preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $p['count']) ){
            $this->renderError(Yii::t('common','count_point_two'), ErrorCode::PARAM_EMPTY); 
        } 
        $contract_info = PowerContractModel::model()->getById($p['id']);
        if( $contract_info['status'] == 1  ){
            $this->renderError(Yii::t('common','contract_forbid'), ErrorCode::PARAM_EMPTY); 
        }
        if( $contract_info['status'] == 2  ){
            $this->renderError(Yii::t('common','contract_stop'), ErrorCode::PARAM_EMPTY); 
        }
        if(  $contract_info['total'] <= $contract_info['deal_total'] ){
            $this->renderError(Yii::t('common','contract_sold_out'), ErrorCode::PARAM_EMPTY); 
        }
        if( $contract_info['status'] == 0 ){
            $re = $this->createOrder($p['id'] , $p['count']); 
            if( !$re ){
                $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
            }
            $this->renderJson(Yii::t('common','success'));
        }
        else{
            $this->renderError(Yii::t('common','contract_unusual'), ErrorCode::PARAM_EMPTY); 
        }

    }
    public function createOrder( $cid , $count ){
        if( !$cid || !$count ){
            return false;
        }
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $c_sql = "select * from ".PowerContractModel::model()->tableName().' where  id = :id limit 1 for update';
            $c_info = PowerContractModel::model()->findBySql( $c_sql , array( ':id' => $cid ) );
            if( $c_info ){
                if( $c_info['status'] != 0 || $c_info['total'] <= $c_info['deal_total'] ){
                    $transaction->rollback();
                    return false;
                }
                else{
                    $t = time();
                    $order = new PowerContractOrderModel();
                    $order->cid = $cid;
                    $order->uid = Yii::app()->session['id'];
                    $order->price = $c_info['price'];
                    $order->ctime = $t;
                    $order->pay_time = $t + $this->pay_time_out;
                    $order->order_price = round( $c_info['price'] * $count , 2 );
                    $order->random_code = rand(100000,999999);
                    $order->count = $count;
                    $re1 = $order->save();
                    $re2 = PowerContractModel::model()->updateCounters(array('deal_total'=>$count),'id=:id',array(':id'=>$cid));
                    $l = new PowerContractOrderLogModel();
                    $l->oid = $cid;
                    $l->type = self::ADD;
                    $l->uid = Yii::app()->session['id'];
                    $l->name = PowerContractOrderModel::model()->tableName();
                    $l->ctime = $t;
                    $l->content = json_encode( $order->attributes , JSON_UNESCAPED_UNICODE );
                    $re3 = $l->save(); 
                    if( !$re1 || !$re2 || !$re3){
                        $transaction->rollback();
                        return false;
                    }
                    $transaction->commit(); 
                    return true;
                }
            }
            else{
                $transaction->rollback();
                return false;
            }
            
        }catch(Exception $e){
            $transaction->rollback();
            return false;
        }
    }
    public function cancelOrder( $id ){
        if(empty($id)){
            return false;
        }
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $o_sql = "select * from ".PowerContractOrderModel::model()->tableName().' where  id = :id limit 1 for update ';
            $o_info = PowerContractOrderModel::model()->findBySql( $o_sql , array( ':id' => $id ) );
            if( !$o_info ){
                $transaction->rollback();
                return false;
            }
            $cid = $o_info->cid;
            $c_sql = "select * from ".PowerContractModel::model()->tableName().' where  id = :id limit 1 for update';
            $c_info = PowerContractModel::model()->findBySql( $c_sql , array( ':id' => $cid ) );
            if( $c_info ){
                $t = time();
                
                $re1 = PowerContractOrderModel::model()->updateByPk( $id , array('status'=>self::CANCEL , 'uptime' => $t , 'uuid' => Yii::app()->session['id'] ));
                $re2 = PowerContractModel::model()->updateCounters(array('deal_total'=>-$o_info['count']),'id=:id',array(':id'=>$cid));
                $l = new PowerContractOrderLogModel();
                $l->oid = $id;
                $l->type = self::DEL;
                $l->uid = Yii::app()->session['id'];
                $l->name = PowerContractOrderModel::model()->tableName();
                $l->ctime = $t;
                $l->content = json_encode( $o_info->attributes , JSON_UNESCAPED_UNICODE );
                $re3 = $l->save(); 
                if( !$re1 || !$re2 || !$re3 ){
                    $transaction->rollback();
                    return false;
                }
                $transaction->commit(); 
                return true;
            }
            else{
                $transaction->rollback();
                return false;
            }
            
        }catch(Exception $e){
            $re['operate'] = 'PowerContractOrder cancel ';
            $re['id'] = $id;
            $re['uid'] = Yii::app()->session['id'];
            $re['operator'] = 'self';
            $re['message'] = $e->getMessage();
            $log = json_encode( $re , JSON_UNESCAPED_UNICODE );


            Yii::log($log, CLogger::LEVEL_ERROR , 'system_error');
            $transaction->rollback();
            return false;
        }


    }   
    public function actionOrderCancel(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY); 
        }
        $id = $p['id'];
        $uid  =  Yii::app()->session['id'];
        $info = PowerContractOrderModel::model()->find( 'id=:id' , array( ':id' => $id ) );
        if( !$info ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY);
        }
        $order_info  = $info->attributes;
        if( $order_info['uid'] != $uid ){
            $this->renderError(Yii::t('common','not_your_order'), ErrorCode::PARAM_EMPTY);
        }
        if( $order_info['status'] != 0 ){
            $this->renderError(Yii::t('common','no_cancel'), ErrorCode::PARAM_EMPTY);
        }
        $re = $this->cancelOrder( $id , $order_info['cid']);
        if( !$re ){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
        $this->renderJson(Yii::t('common','success'));
    } 
}
