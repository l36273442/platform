<?php
class MachineContractController extends CommonController{
    public function actionGetList(){
        $re =  MachineContractModel::model()->findAllBySql('select * from '.MachineContractModel::model()->tableName().' where status = 0 order by id desc ');
        if( $re === false ){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
        if( empty($re) ){
            $this->renderJson(Yii::t('common','success') , array());
        }
        $u = $u_k = $a = $m = $c = $m_k = $c_k = $data = array();
        $u = UnitModel::model()->findAll();
        if($u){
            foreach($u as $v){
                $u_k[$v['id']] = $v->attributes;
            }
        }

        foreach( $re as $v ){
            $r = array();
            $r = $v->attributes;
            $r['start_time'] = date('Y-m-d H:i:s' , $r['start_time']);
            $r['end_time']  = date('Y-m-d H:i:s' , $r['end_time']);
            $m[]= $r['machine_id'];
            $data[] = $r;
        }

        $x = new CDbCriteria();
        $x->addInCondition('id',$m);
        $l = MiningMachineModel::model()->findAll($x);
        if( $l ){
            foreach( $l as $v ){
                $m_k[$v['id']] = $v->attributes;
                $c[] = $v['coin_id'];
            }
        }
        if( $c ){
            $x = new CDbCriteria();
            $x->addInCondition('id',$c);
            $d = CoinModel::model()->findAll($x);
            if($d){
                foreach( $d as $v ){
                    $c_k[$v['id']] = $v->attributes;
                }
            }
        } 
        foreach ( $data as &$v ){
            $v['coin_name'] = $c_k[$m_k[$v['machine_id']]['coin_id']]['name'];
            $v['machine_name'] = $m_k[$v['machine_id']]['name'];
            $v['unit_name'] = $u_k[$c_k[$m_k[$v['machine_id']]['coin_id']]['unit_id']]['name'];
        }
        $this->renderJson(Yii::t('common','success') , $data);
    }
    public function actionOrder(){
        $p = $this->getParams('POST');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id']<=0 ){
            $this->renderError(Yii::t('common','param_error') , ErrorCode::PARAM_ERROR);
        }
        if( !isset($p['count']) || !is_int($p['count']) || $p['count']<=0 ){
            $this->renderError(Yii::t('common','param_error') , ErrorCode::PARAM_ERROR);
        }
        $transaction = Yii::app()->db->beginTransaction();
        try{
            $mc = MachineContractModel::model()->findBySql( 'select * from '.MachineContractModel::model()->tableName().' where id=:id for update '  , array( ':id' => $p['id'] ) );
            $user_coin = UserLegalCoinModel::model()->findBySql('select * from '.UserLegalCoinModel::model()->tableName().' where uid=:uid for update ' , array(':uid' => Yii::app()->session['id'] ));
            if( empty($mc) ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','system_error2'), ErrorCode::SYSTEM_ERROR); 
            }
            if( $mc->status != 0 ){
                $this->renderError(Yii::t('common','contract_status_error'), ErrorCode::SYSTEM_ERROR); 
            }
            if( $mc->total <= $mc->deal_total + $count ){
                $this->renderError(Yii::t('common','contract_not_enough'), ErrorCode::SYSTEM_ERROR); 
            }
            $t = time();
            $total = round($mc->price*$p['count'],8);
            $order = new MachineContractOrderModel();
            $order->mo_id = $mc->id;
            $order->uid = Yii::app()->session['id'];
            $order->machine_id = $mc->machine_id;
            $order->coin_id = $mc->coin_id;
            $order->price = $mc->price;
            $order->order_price = $total;
            $order->count = $p['count'];
            $order->electricity_fee = $mc->electricity_fee;
            $order->manage_fee = $mc->manage_fee;
            $order->ctime = $t;
            $order->uptime = $t;
            $re = $order->save();            
            $re2 = MachineContractModel::model()->updateCounters(array('deal_total'=>$count),'id=:id',array(':id'=>$p['id']));
            $re3 = UserLegalCoinModel::model()->updateCounters(array('usd'=>-$total) , 'uid=:uid',array('uid'=>Yii::app()->session['id']));
            $re4 = UserCoinModel::model()->updateCounters( array('total_machine'=>$count ,'machine_total_investment' => $total ,'total_investment' => $total) , 'uid=:uid and coin_id=:coin_id' , array('uid'=>Yii::app()->session['id'], ':coin_id' => $c_info->coin_id ));

            if( !$re1 || !$re2 || !$re3 || !$re4 ){
                $transaction->rollback();
                $this->renderError(Yii::t('common','order_fail'), ErrorCode::PARAM_EMPTY); 
            }
            $olog = new UserLegalCoinModel();
            $olog->name = Yii::t('common','machine_buy');
            $olog->coin_id = $mc->coin_id;
            $olog->o_id = $order->id;
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
    public function actionGetDetail(){
        $p = $this->getParams('REQUEST');
        if(!isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error') , ErrorCode::PARAM_ERROR);
        }
        $re = MachineContractModel::model()->find('id=:id', array(':id'=>$p['id']));
        if( empty($re) ){
            $this->renderError(Yii::t('common','param_error') , ErrorCode::PARAM_ERROR);
        }
         
    }

}

