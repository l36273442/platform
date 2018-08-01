<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class SiteController extends WebController
{
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
    {
        $data = $c = $c_id = array();
        $b = CoinBlockModel::model()->find('coin_id=:coin_id' ,array(':coin_id'=>1));
        $this->data['block'] = $b->attributes;
        $p = PowerContractModel::model()->findAll('is_index=:is_index' , array(':is_index' => 1));
        if( empty($p) ){
            $this->data['power'] = array();
        }else{
            foreach( $p as $v ){
                $c_id[] = $v->coin_id;
                $this->data['power'][] = $v->attributes;
            }
        }
        if( $c_id ){
            $r = CoinModel::model()->getCoinsByIds($c_id);
            if($r){
                foreach( $r as $v ){
                    $c[$v['id']] = $v;
                }
            }
        }
        $u =  ComputingPowerUnitModel::model()->findAll();
        $u_k = array();
        if( $u ){
            foreach ( $u as $v ){
                $u_k[$v->id] = $v->attributes;
            }
        }
        if( $this->data['power']){
            foreach( $this->data['power'] as &$v ){
                $v['unit_id'] = $c[$v['coin_id']]['unit_id'];
                $v['unit_name'] = $u_k[$c[$v['coin_id']]['unit_id']]['name'];
            }
        }
        $c = MiningMachineModel::model()->find('is_index=:is_index' , array(':is_index'=>1));
        if( empty($c) ){
            $this->data['machine'] = array();
        }else{
            $this->data['machine'] = $c->attributes;
               
        }
        //print_r($this->data);   
        $this->render('index',$this->data);
    }
    public function actionPowerContractDetail(){
        $p = $this->getParams('GET');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0 ){
            $this->renderErrorPage('error');
        }
        $d = PowerContractModel::model()->find('id=:id', array(':id'=>$p['id']));
        if(empty($d)){
            $this->renderErrorPage('error');
        }
        $this->data['detail'] = $d->attributes;
        $coin = CoinModel::model()->find('id=:id', array(':id'=> $d->coin_id));
        if($coin){
            $unit = UnitModel::model()->find('id=:id' , array(':id'=>$coin->unit_id));
            $this->data['detail']['coin_name'] = $coin->name;
            if($unit){
                $this->data['detail']['unit_id'] = $unit->id;
                $this->data['detail']['unit_name'] = $unit->name;
            }
            else{
                $this->data['detail']['unit_id'] = '';
                $this->data['detail']['unit_name'] = '';
            }
        }
        else{
            $this->data['detail']['coin_name'] = $coin->name;
        
        }
        $f = FaqModel::model()->findAll('coin_id=:coin_id and machine_id=:machine_id and type=:type' , array( ':type'=> 0,':coin_id' => $d->coin_id , ':machine_id' => $d->machine_id));
        if($f){
            foreach( $f as $v ){
                $this->data['faq'][] = $v->attributes;
            }
        }
        print_r($this->data);

    }
    public function actionMachineContractDetail(){
        $p = $this->getParams('GET');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0 ){
            $this->renderErrorPage('error');
        }
        $d = MachineContractModel::model()->find('id=:id', array(':id'=>$p['id']));
        if(empty($d)){
            $this->renderErrorPage('error');
        }
        $m = MiningMachineModel::model()->find('id=:id', array(':id' => $d->machine_id));
        if( empty($m) ){
            $this->renderErrorPage('error');
        }
        $this->data['machine'] = $m->attributes;
        $this->data['detail'] = $d->attributes;
        $coin = CoinModel::model()->find('id=:id', array(':id'=> $d->coin_id));
        if($coin){
            $unit = UnitModel::model()->find('id=:id' , array(':id'=>$coin->unit_id));
            $this->data['detail']['coin_name'] = $coin->name;
            if($unit){
                $this->data['detail']['unit_id'] = $unit->id;
                $this->data['detail']['unit_name'] = $unit->name;
            }
            else{
                $this->data['detail']['unit_id'] = '';
                $this->data['detail']['unit_name'] = '';
            }
        }
        else{
            $this->data['detail']['coin_name'] = '';
        
        }
        $f = FaqModel::model()->findAll('coin_id=:coin_id and machine_id=:machine_id and type=:type' , array( ':type'=> 1 , ':coin_id' => $d->coin_id , ':machine_id' => $d->machine_id));
        if($f){
            foreach( $f as $v ){
                $this->data['faq'][] = $v->attributes;
            }
        }
        print_r($this->data);

    }
    public function actionHelp(){
        $h = HelpModel::model()->findAll('status=:status' ,array(':status'=>0));

        if($h){
            foreach($h as $v ){
                $this->data['help'][$v->type][] = $v->attributes;
            }
        }
        else{
            $this->data['help'] = array();
        }
        $this->render('help',$this->data);
    }
    public function actionAbout(){
        $a = InfoModel::model()->find();
        $e = EmployeeModel::model()->findAll('status=:status' ,array(':status'=>0));
        
        if($a){
            $this->data['about'] = $a->attributes;
        }
        else{
            $this->data['about'] = array();
        }
        if($e){
            foreach($e as $v){
                $this->data['employee'][] = $v->attributes;
            }
        }
        $this->render('about',$this->data);
    }
    public function actionUserProtocol(){
        //$p = $this->getParams('GET');
        $pc = UserProtocolModel::model()->find();
        if( $pc ){
            $this->data['protocol']= $pc->attributes;
        }else{
            $this->data['protocol']= array();;
        } 
    }
    public function actionError(){
        $this->render('error',$this->data);
    }
}
