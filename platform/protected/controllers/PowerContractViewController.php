<?php
class PowerContractViewController extends CommonController{

    public $info;
    public function actionHashShop(){
        $this->render('hashshop',$this->data);
    }
    public function actionDetail(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0){
            header('Location: '.Yii::app()->request->hostInfo);
            exit;
        }
        
        $detail = PowerContractModel::model()->find( 'id=:id' , array(':id'=>$p['id']) );
        $coin = coinModel::model()->find( 'id=:id' , array(':id'=>$detail['coin_id']) );
        $unit = UnitModel::model()->find( 'id=:id' , array(':id'=>$coin['unit_id']) );
        $this->data['detail'] = empty($detail)?array():$detail->attributes;
        $this->data['coin'] = empty($coin)?array():$coin->attributes;
        $this->data['unit'] = empty($unit)?array():$unit->attributes;
        
        $this->render('detail',$this->data);
         
    }
}
