<?php
class PowerContractOrderController extends AjaxController{
    const CANCEL = 5;
    public function actiongetUserList(){
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
        if( isset($p['coin_id']) && is_numeric($p['coin_id']) && $p['coin_id']>0 ){
            $where .=' and coin_id=:coin_id';
            $arr[':coin_id'] = $p['coin_id'];
        }
        $s = 'select * from '.PowerContractOrderModel::model()->tableName().$where.' limit '.($page-1)*$size.','.$size;
        $r = PowerContractOrderModel::model()->findAllBySql( $s , $arr );
        $data = $c = $c_k = $u = $u_k = array();
        $c = CoinModel::model()->findAll();
        if( $c ){
            foreach($c as $v ){
                $c_k[$v['id']] = $v->attributes;
            }
        }
        $u = UnitModel::model()->findAll();
        if( $u ){
            foreach($u as $v ){
                $u_k[$v['id']] = $v->attributes;
            }
        }
        if( $r ){ 
            foreach( $r as $v ){
                $row = array();
                $row = $v->attributes;
                $row['coin_name'] = isset($c_k[$v['coin_id']])?$c_k[$v['coin_id']]['name']:'';
                $row['electricity_fee'] = isset($c_k[$v['coin_id']])?$c_k[$v['coin_id']]['electricity_fee']:'';
                $row['manage_fee'] = isset($c_k[$v['coin_id']])?$c_k[$v['coin_id']]['manage_fee']:'';
                $row['unit_name'] = isset($u_k[$c_k[$v['coin_id']]['unit_id']])?$u_k[$c_k[$v['coin_id']]['unit_id']]['name']:'';
                $row['price'] = sprintf("%.4f",$row['price']);
                $row['order_price'] = sprintf("%.4f",$row['order_price']);
                $row['electricity_fee'] = sprintf("%.6f",$row['electricity_fee']);
                $row['manage_fee'] = sprintf("%.4f",$row['manage_fee']);
                $row['ctime'] = date("Y-m-d",$row['ctime']);
                $data[] = $row;
            }
        }
        $this->renderJson(Yii::t('common','success') , $data);
    }
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
        //$uid =1;
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
            }
            $coins = CoinModel::model()->getCoinsByIds($coin_id );
            $coins_key = $this->RowsToArr($coins);
            $machine = MiningMachineModel::model()->getMachinesByIds($machine_id );
            $machine_key = $this->RowsToArr($machine);
            
            $unit = ComputingPowerUnitModel::model()->findAll();
            $unit_key = $this->RowsToArr($unit);

            foreach( $list['list'] as &$v ){
                $v['contract_name'] = $contract_key[$v['cid']]['name'];
                $v['manage_fee']  = $contract_key[$v['cid']]['manage_fee'];
                $v['electricity_fee']  = $contract_key[$v['cid']]['electricity_fee'];
                $v['coin_id'] = $contract_key[$v['cid']]['coin_id'];
                $v['coin_name'] = $coins_key[$contract_key[$v['cid']]['coin_id']]['name'];
                $v['unit_id'] = $coins_key[$v['coin_id']]['unit_id'];
                $v['unit_name'] = $unit_key[$coins_key[$v['coin_id']]['unit_id']]['name'];
                $v['ctime'] = date('Y-m-d H:i:s' , $v['ctime']);
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
        $count = $p['count'];
        $cid = $p['id'];
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $c_sql = "select * from ".PowerContractModel::model()->tableName().' where  id = :id limit 1 for update';
            $c_info = PowerContractModel::model()->findBySql( $c_sql , array( ':id' => $p['id'] ) );
            $u_sql = "select * from ".UserLegalCoinModel::model()->tableName()." where uid = :uid for update";
            $user_coin = UserLegalCoinModel::model()->findBySql($u_sql , array(':uid' => Yii::app()->session['id'] ));
            $total = round( $c_info['price'] * $count , 8 );
            $uc = UserCoinModel::model()->find('uid=:uid and coin_id=:coin_id' , array(':uid'=> Yii::app()->session['id'] ,':coin_id'=>$c_info->coin_id));
            if(empty($uc)){
                $xx = new UserCoinModel();
                $xx->uid = Yii::app()->session['id'];
                $xx->coin_id = $c_info->coin_id;
                $uc_re = $xx->save();
            }
            $uc = UserCoinModel::model()->findBySql('select * from '.UserCoinModel::model()->tableName()." where uid = :uid and coin_id=:coin_id for update",array(':uid'=> Yii::app()->session['id'] ,':coin_id'=>$c_info->coin_id));    
            if( $total > $user_coin->usd ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','account_not_enough'), ErrorCode::PARAM_EMPTY); 
            }
            if( $c_info ){
                if( $c_info['status'] == 1  ){
                    $transaction->rollback();
                    $this->renderError(Yii::t('common','contract_forbid'), ErrorCode::PARAM_EMPTY); 
                }
                if( $c_info['status'] == 2  ){
                    $transaction->rollback();
                    $this->renderError(Yii::t('common','contract_stop'), ErrorCode::PARAM_EMPTY); 
                }
                if( $c_info['status'] != 0 || $c_info['total'] <= $c_info['deal_total']+$p['count'] ){
                    $transaction->rollback();
                    $this->renderError(Yii::t('common','contract_not_enough'), ErrorCode::PARAM_EMPTY); 
                }
                else{
                    $t = time();
                    $order = new PowerContractOrderModel();
                    $order->cid = $cid;
                    $order->uid = Yii::app()->session['id'];
                    $order->price = $c_info['price'];
                    $order->ctime = $t;
                    $order->order_price = $total;
                    $order->count = $count;
                    $re1 = $order->save();
                    $re2 = PowerContractModel::model()->updateCounters(array('deal_total'=>$count),'id=:id',array(':id'=>$cid));
                    $re3 = UserLegalCoinModel::model()->updateCounters(array('usd'=>-$total) , 'uid=:uid',array('uid'=>Yii::app()->session['id']));
                    $re4 = UserCoinModel::model()->updateCounters( array('total_power'=>$count , 'power_total_investment' => $total , 'total_investment' => $total ) , 'uid=:uid and coin_id=:coin_id' , array('uid'=>Yii::app()->session['id'], ':coin_id' => $c_info->coin_id ));

                    if( !$re1 || !$re2 || !$re3 || !$re4 ){
                        $transaction->rollback();
                        $this->renderError(Yii::t('common','order_fail'), ErrorCode::PARAM_EMPTY); 
                    }
                    $olog = new UserLegalCoinLogModel();
                    $olog->name = Yii::t('common','power_buy');
                    $olog->coin_id = $c_info->coin_id;
                    $olog->o_id = $order->id;
                    $olog->uid = Yii::app()->session['id'];
                    $olog->type = 1;
                    $olog->mining_type = 0;
                    $olog->vol = $total;
                    $olog->ctime= $t;
                    $re5 = $olog->save();
                    if( !$re5 ){
                        $transaction->rollback();
                        $this->renderError(Yii::t('common','order_fail2'), ErrorCode::PARAM_EMPTY); 
                    }
                }
                $transaction->commit(); 
                $this->renderJson(Yii::t('common','success'));
            }
            else{
                $transaction->rollback();
                $this->renderError(Yii::t('common','contract_unusual'), ErrorCode::PARAM_EMPTY); 
            }

        }catch(Exception $e){
            $transaction->rollback();
            $this->renderError(Yii::t('common','system_error'), ErrorCode::SYSTEM_ERROR); 
        }

    }
}
