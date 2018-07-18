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
                    $row['current_total'] = sprintf("%.4f" ,$uc_k[$v->id]['current_total']);
                    $row['freeze_total'] = sprintf("%.4f" ,$uc_k[$v->id]['freeze_total']);
                    $row['power_total_income'] = sprintf("%.4f",$uc_k[$v->id]['power_total_income']);
                    $row['power_total_investment'] = sprintf("%.4f",$uc_k[$v->id]['power_total_investment']);
                    $row['total_power'] = sprintf("%.4f",$uc_k[$v->id]['total_power']);
                    $row['total_machine'] = $uc_k[$v->id]['total_machine'];
                    $row['total_investment'] = sprintf("%.4f",$uc_k[$v->id]['total_investment']);
                    $row['total_income'] = sprintf("%.4f",$uc_k[$v->id]['total_income']);
                    $row['machine_total_investment'] = sprintf("%.4f",$uc_k[$v->id]['machine_total_investment']);
                    $row['machine_total_income'] = sprintf("%.4f",$uc_k[$v->id]['machine_total_income']);
                }
                else{
                    $row['current_total'] = 0;
                    $row['power_total_income'] = 0;
                    $row['power_total_investment'] = 0;
                    $row['total_power'] = 0;
                    $row['freeze_total'] = 0;
                    $row['total_machine'] = 0;
                    $row['total_investment'] = 0;
                    $row['total_income'] = 0;
                    $row['machine_total_income'] = 0;
                    $row['machine_total_income'] = 0;
                }
                $row['coin_name'] = $v->name;
                $row['unit_id'] = $v->unit_id;
                $row['unit_name'] = isset($u_k[$v->unit_id])?$u_k[$v->unit_id]['name']:'';
                $this->data['coins'][] = $row;
            }
        }
        $legal = UserLegalCoinModel::model()->find('uid=:uid' , array(':uid'=>$id));
        if($legal ){
            $this->data['legal'] = $legal->attributes;   
            $this->data['legal']['usd'] = sprintf("%.4f", $this->data['legal']['usd']);
            $this->data['legal']['usd_freeze'] = sprintf("%.4f", $this->data['legal']['usd_freeze']);
            $this->data['legal']['usd_recharge_total'] = sprintf("%.4f", $this->data['legal']['usd_recharge_total']);
        }
        else{
            $this->data['legal']['usd'] = 0;
            $this->data['legal']['usd_freeze'] = 0;
            $this->data['legal']['usd_recharge_total'] = 0;

        }
        $this->render('panel',$this->data);
    }
    public function actionMachineAssets(){
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
                    $row['current_total'] = sprintf("%.4f" ,$uc_k[$v->id]['current_total']);
                    $row['power_total_income'] = sprintf("%.4f",$uc_k[$v->id]['power_total_income']);
                    $row['power_total_investment'] = sprintf("%.4f",$uc_k[$v->id]['power_total_investment']);
                    $row['total_power'] = sprintf("%.4f",$uc_k[$v->id]['total_power']);
                    $row['freeze_total'] = sprintf("%.4f",$uc_k[$v->id]['freeze_total']);
                    $row['total_machine'] = $uc_k[$v->id]['total_machine'];
                    $row['total_investment'] = sprintf("%.4f",$uc_k[$v->id]['total_investment']);
                    $row['total_income'] = sprintf("%.4f",$uc_k[$v->id]['total_income']);
                    $row['machine_total_investment'] = sprintf("%.4f",$uc_k[$v->id]['machine_total_investment']);
                    $row['machine_total_income'] = sprintf("%.4f",$uc_k[$v->id]['machine_total_income']);
                }
                else{
                    $row['current_total'] = 0;
                    $row['power_total_income'] = 0;
                    $row['power_total_investment'] = 0;
                    $row['total_power'] = 0;
                    $row['freeze_total'] = 0;
                    $row['total_machine'] = 0;
                    $row['total_investment'] = 0;
                    $row['total_income'] = 0;
                    $row['machine_total_investment'] = 0;
                    $row['machine_total_income'] = 0;
                }
                $row['coin_name'] = $v->name;
                $row['unit_id'] = $v->unit_id;
                $row['unit_name'] = isset($u_k[$v->unit_id])?$u_k[$v->unit_id]['name']:'';
                $this->data['coins'][] = $row;
            }
        }
        $this->render('millassets',$this->data);

    }
    public function actionHashAssets(){
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
                    $row['current_total'] = sprintf("%.4f" ,$uc_k[$v->id]['current_total']);
                    $row['power_total_income'] = sprintf("%.4f",$uc_k[$v->id]['power_total_income']);
                    $row['power_total_investment'] = sprintf("%.4f",$uc_k[$v->id]['power_total_investment']);
                    $row['total_power'] = sprintf("%.4f",$uc_k[$v->id]['total_power']);
                    $row['freeze_total'] = sprintf("%.4f",$uc_k[$v->id]['freeze_total']);
                    $row['total_machine'] = $uc_k[$v->id]['total_machine'];
                    $row['total_investment'] = sprintf("%.4f",$uc_k[$v->id]['total_investment']);
                    $row['total_income'] = sprintf("%.4f",$uc_k[$v->id]['total_income']);
                    $row['machine_total_investment'] = sprintf("%.4f",$uc_k[$v->id]['machine_total_investment']);
                    $row['machine_total_income'] = sprintf("%.4f",$uc_k[$v->id]['machine_total_income']);
                }
                else{
                    $row['current_total'] = 0;
                    $row['power_total_income'] = 0;
                    $row['power_total_investment'] = 0;
                    $row['total_power'] = 0;
                    $row['freeze_total'] = 0;
                    $row['total_machine'] = 0;
                    $row['total_investment'] = 0;
                    $row['total_income'] = 0;
                    $row['machine_total_income'] = 0;
                    $row['machine_total_income'] = 0;
                }
                $row['coin_name'] = $v->name;
                $row['unit_id'] = $v->unit_id;
                $row['unit_name'] = isset($u_k[$v->unit_id])?$u_k[$v->unit_id]['name']:'';
                $this->data['coins'][] = $row;
            }
        }
        print_r($this->data); 

    }

}
