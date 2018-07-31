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
    public function actionLogout(){
        if( isset(Yii::app()->session['id'] )){
            unset(Yii::app()->session['id']);
        }
        if( isset(Yii::app()->session['phone'] )){
            unset(Yii::app()->session['phone']);
        }
        if( isset(Yii::app()->session['expire'] )){
            unset(Yii::app()->session['expire']);
        }
        $this->redirect(Yii::app()->getBaseUrl().'/site/index');
    }
    public function actionWithdraw(){

        $id = Yii::app()->session['id']; 
        $p = $this->getparams('REQUEST');
        
        if( !isset($p['coin_id']) || !is_numeric($p['coin_id']) || $p['coin_id'] <= 0 ){
            $this->redirect(Yii::app()->getBaseUrl().'/site/error');
        }
        $c = CoinModel::model()->find('id=:id',array(':id'=>$p['coin_id']));
        if(empty($c)){
            $this->redirect(Yii::app()->getBaseUrl().'/site/error');
        }
        $uc = UserCoinModel::model()->find('uid=:uid and coin_id=:coin_id' ,array(':uid'=>$id , ':coin_id'=>$p['coin_id']));
        $this->data['uc'] = empty($uc)?array():$uc->attributes;
        $this->data['coin'] = $c->attributes;
        $this->render('withdraw',$this->data);

    }
    public function actionAddress(){

        $id = Yii::app()->session['id']; 
        $p = $this->getparams('REQUEST');
        
        $c = CoinModel::model()->findAll();
        if(empty($c)){
            $this->redirect(Yii::app()->getBaseUrl().'/site/error');
        }
        $this->data['uc'] = empty($uc)?array():$uc->attributes;
        foreach( $c as $v ){
            $this->data['coin'][] = $v->attributes;
        }    
        $this->render('address',$this->data);

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
        $b = CoinModel::model()->findBySql("select id,name,latest_price from platform_coin where name = 'btc' ");
        if($b ){
            $this->data['btc'] = $v->attributes;
        }
        else{
            $this->data['btc'] = array();
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
    public function actionPowerAssets(){
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
        $b = CoinModel::model()->findBySql("select id,name,latest_price from platform_coin where name = 'btc' ");
        if($b ){
            $this->data['btc']['id'] = $b->id;
            $this->data['btc']['name'] = $b->name;
            $this->data['btc']['latest_price'] = $b->latest_price;
        }
        else{
            $this->data['btc'] = array();
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
        $this->render('powerassets',$this->data);

    }
    public function actionInvite(){
        $id = Yii::app()->session['id'];
        $config = InviteConfigModel::model()->find();
        $invite = UserInviteModel::model()->find('uid=:uid', array(':uid'=> $id));
        if($config ){
            $this->data['config'] = $config->attributes;
        }
        else{
            $this->data['config'] = array();;
        }
        if( $invite ){
            $this->data['invite'] = $invite->attributes;
        }else{
            $this->data['invite'] = array();;
        }
        $coins = $u_k = $c_k = array();
        $f = UserModel::model()->findAllBySql('select id,name,phone,ctime from platform_user where invite_uid='.$id.' order by id desc limit 5' );
        if($f){
            foreach( $f as $v ){
                $row = array();
                $row['id'] = $v['id'];
                $row['name'] = $v['name'];
                $row['phone'] = substr($v['phone'],0,3).'****'.substr($v['phone'],7);
                $row['ctime'] = $v['ctime'];
                $row['ctime'] = $v['ctime'];
                $row['ctime_text'] = date('Y-m-d H:i' ,$v['ctime']);
                $this->data['friends'][] = $row;
            }
        }
        else{
             $this->data['friends'] = array();
        }
        $u = UnitModel::model()->findAll();
        if( $u ){
            foreach( $u as $v ){
                $u_k[$v['id']] = $v->attributes;
            }
        }
        $uc = UserCoinModel::model()->findAllBySql('select coin_id ,total_invite_power from platform_user_coin where uid='.$id.' and total_invite_power >0');
        if( $uc  ){
            foreach( $uc as $v){
                $cids[] = $v['coin_id'];
                $coins[] = $v->attributes; 
            }
            $cs = CoinModel::model()->findAll();
            if($cs){
                foreach($cs as $v){
                    $c_k[$v['id']] = $v;
                }
            }
        }
        $reward = PowerLogModel::model()->findAllBySql('select * from platform_power_log where uid ='.$id.' and type = 2 order by id desc limit 5');
        if( $reward ){
            foreach( $reward as $v ){
                $row = array();
                $row['id'] = $v['id'];
                $row['coin_id'] = $v['coin_id'];
                $row['name'] = $v['name'];
                $row['count'] = sprintf("%.8f",$v['count']);
                $row['ctime_text'] = date('Y-m-d H:i:s' ,$v['ctime']);
                $row['ctime'] = $v['ctime'];
                $row['coin_name'] = isset($c_k[$v['coin_id']])?$c_k[$v['coin_id']]['name']:'';
                $this->data['reward'][] = $row;
            }
        }
        else{
            $this->data['reward'] = array();
        }
    
        foreach( $coins as &$v){
            $v['coin_name'] = isset($c_k[$v['coin_id']])?$c_k[$v['coin_id']]['name']:'';
            $v['unit_name'] = isset($u_k[$c_k[$v['coin_id']]['unit_id']])?$u_k[$c_k[$v['coin_id']]['unit_id']]['name']:'';
            $v['total_invite_power'] = sprintf("%.4f" , $v['total_invite_power']);
        }
        $this->data['coins'] = $coins;
        $this->data['invite_url'] = Yii::app()->request->getHostInfo().'/signup?invitecode='.$this->data['invite']['invite_code'];
        $this->render('invite',$this->data);
    }
}
