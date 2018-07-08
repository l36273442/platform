<?php
class UserViewController extends Controller{
    //交易密码
    public function actionUpTpass(){
        $this->render('uptpass');
    }
    //登录密码 
    public function actionUpPass(){

        $this->render('uppass');
    }
    public function actionPanel(){
        //$id=1;
        $id = Yii::app()->session['id']; 
        $uc = UserCoinModel::model()->findAll('uid=:uid' ,array(':uid'=>$id));
        $c = CoinModel::model()->findAll();
        $uc_k = $c_k =  $m_k = $u_k = $coins = array();
        $u = UnitModel::model()->findAll();
        if($u){
            foreach( $u as $v ){
                $u_k[$v->id] = $v->attributes;
            }
        }
        if($uc){
            foreach( $uc as $v ){
                $uc_k[$v['coin_id']] = $v->attributes;
            }
        }
        if( $c ){
            foreach( $c as $v ){
                $c_k[$v->id] = $v->attributes;
                $row=array();
                $row = $v->attributes;
                if(isset($uc_k[$v->id])){
                    $row['current_total'] = $uc_k[$v->id]['current_total'];
                    $row['power_total_income'] = $uc_k[$v->id]['power_total_income'];
                    $row['power_total_investment'] = $uc_k[$v->id]['power_total_investment'];
                    $row['total_power'] = $uc_k[$v->id]['total_power'];
                    $row['total_investment'] = $uc_k[$v->id]['total_investment'];
                    $row['total_income'] = $uc_k[$v->id]['total_income'];
                }
                else{
                    $row['current_total'] = 0;
                    $row['power_total_income'] = 0;
                    $row['power_total_investment'] = 0;
                    $row['total_power'] = 0;
                    $row['total_investment'] = 0;
                    $row['total_income'] = 0;
                }
                $row['coin_name'] = $v->name;
                $row['unit_id'] = $v->unit_id;
                $row['unit_name'] = isset($u_k[$v->unit_id])?$u_k[$v->unit_id]['name']:'';
                $this->data['coins'][] = $row;
            }
        }
        $m = MiningMachineModel::model()->findAll();
        if( $m ){
            foreach( $m as $v ){
                $row = array();
                $row = $v->attributes;
                $row['coin_name'] = isset($c_k[$v->coin_id])?$c_k[$v->coin_id]['name']:'';
                $row['unit_name'] = isset($u_k[$c_k[$v->coin_id]['unit_id']])?$u_k[$c_k[$v->coin_id]['unit_id']]['name']:'';
                $row['unit_it'] = isset($c_k[$v->coin_id]['unit_id'])?$c_k[$v->coin_id]['unit_id']:'';
                if(isset($uc_k[$v->coin_id])){
                    $row['current_total'] = $uc_k[$v->coin_id]['current_total'];
                    $row['total_machine'] = $uc_k[$v->coin_id]['total_machine'];
                    $row['machine_total_investment'] = $uc_k[$v->coin_id]['machine_total_investment'];
                    $row['machine_total_income'] = $uc_k[$v->coin_id]['machine_total_income'];
                    $row['total_investment'] = $uc_k[$v->coin_id]['total_investment'];
                    $row['total_income'] = $uc_k[$v->coin_id]['total_income'];
                }
                else{
                    $row['current_total'] = 0;
                    $row['total_machine'] = 0;
                    $row['machine_total_investment'] = 0;
                    $row['machine_total_income'] = 0;
                    $row['total_investment'] = 0;
                    $row['total_income'] = 0;
                }
                $this->data['machines'][] = $row;
            }
        }
        $legal = UserLegalCoinModel::model()->find('uid=:uid' , array(':uid'=>$id));
        if($legal ){
            $this->data['legal'] = $legal->attributes;   
        }
        else{
            $this->data['legal']['usd'] = '';
            $this->data['legal']['usd_recharge_total'] = '';

        }
       print_r($this->data); 
    }
    public function actionUserAssets(){
        //$id=1;
        $id = Yii::app()->session['id']; 
        $uc = UserCoinModel::model()->findAll('uid=:uid' ,array(':uid'=>$id));
        $c = CoinModel::model()->findAll();
        $uc_k = $c_k =  $m_k = $u_k = $coins = array();
        $u = UnitModel::model()->findAll();
        if($u){
            foreach( $u as $v ){
                $u_k[$v->id] = $v->attributes;
            }
        }
        if($uc){
            foreach( $uc as $v ){
                $uc_k[$v['coin_id']] = $v->attributes;
            }
        }
        if( $c ){
            foreach( $c as $v ){
                $c_k[$v->id] = $v->attributes;
                $row=array();
                $row = $v->attributes;
                if(isset($uc_k[$v->id])){
                    $row['current_total'] = $uc_k[$v->id]['current_total'];
                    $row['power_total_income'] = $uc_k[$v->id]['power_total_income'];
                    $row['power_total_investment'] = $uc_k[$v->id]['power_total_investment'];
                    $row['total_power'] = $uc_k[$v->id]['total_power'];
                    $row['total_investment'] = $uc_k[$v->id]['total_investment'];
                    $row['total_income'] = $uc_k[$v->id]['total_income'];
                }
                else{
                    $row['current_total'] = 0;
                    $row['power_total_income'] = 0;
                    $row['power_total_investment'] = 0;
                    $row['total_power'] = 0;
                    $row['total_investment'] = 0;
                    $row['total_income'] = 0;
                }
                $row['coin_name'] = $v->name;
                $row['unit_id'] = $v->unit_id;
                $row['unit_name'] = isset($u_k[$v->unit_id])?$u_k[$v->unit_id]['name']:'';
                $this->data['coins'][] = $row;
            }
        }
        $m = MiningMachineModel::model()->findAll();
        if( $m ){
            foreach( $m as $v ){
                $row = array();
                $row = $v->attributes;
                $row['coin_name'] = isset($c_k[$v->coin_id])?$c_k[$v->coin_id]['name']:'';
                $row['unit_name'] = isset($u_k[$c_k[$v->coin_id]['unit_id']])?$u_k[$c_k[$v->coin_id]['unit_id']]['name']:'';
                $row['unit_it'] = isset($c_k[$v->coin_id]['unit_id'])?$c_k[$v->coin_id]['unit_id']:'';
                if(isset($uc_k[$v->coin_id])){
                    $row['current_total'] = $uc_k[$v->coin_id]['current_total'];
                    $row['total_machine'] = $uc_k[$v->coin_id]['total_machine'];
                    $row['machine_total_investment'] = $uc_k[$v->coin_id]['machine_total_investment'];
                    $row['machine_total_income'] = $uc_k[$v->coin_id]['machine_total_income'];
                    $row['total_investment'] = $uc_k[$v->coin_id]['total_investment'];
                    $row['total_income'] = $uc_k[$v->coin_id]['total_income'];
                }
                else{
                    $row['current_total'] = 0;
                    $row['total_machine'] = 0;
                    $row['machine_total_investment'] = 0;
                    $row['machine_total_income'] = 0;
                    $row['total_investment'] = 0;
                    $row['total_income'] = 0;
                }
                $this->data['machines'][] = $row;
            }
        }
        print_r($this->data); 

    }

}
