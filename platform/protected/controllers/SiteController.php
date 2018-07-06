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
        $data['block'] = $b->attributes;
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
        print_r($this->data);   
        //$this->render('index',$data);
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
        print_r($this->data);

    }
    public function actionError(){
        echo 'error';
    }
    public function actionHello(){
    
        echo 34343;
    }
}
