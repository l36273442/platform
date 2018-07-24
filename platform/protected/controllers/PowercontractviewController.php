<?php
class PowerContractViewController extends WebController{

    public $info;
    public function actionHashShop(){
        $this->render('hashshop',$this->data);
    }
    public function actionHashDetail(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0){
            header('Location: '.Yii::app()->request->hostInfo);
            exit;
        }
        
        $detail = PowerContractModel::model()->find( 'id=:id' , array(':id'=>$p['id']) );
        $coin = CoinModel::model()->find( 'id=:id' , array(':id'=>$detail['coin_id']) );
        $unit = UnitModel::model()->find( 'id=:id' , array(':id'=>$coin['unit_id']) );
        $faqs = FaqModel::model()->findAll('coin_id=:coin_id and type=:type', array(':coin_id'=>$coin['id'],':type'=>0) );
        $this->data['detail'] = empty($detail)?array():$detail->attributes;
        $this->data['coin'] = empty($coin)?array():$coin->attributes;
        $this->data['unit'] = empty($unit)?array():$unit->attributes;
        if($faqs){
            foreach( $faqs as $v ){
                $this->data['faqs'][] = $v->attributes;
            }    
        }
        else{
            $this->data['faqs'] = array();
        }
        $this->render('hashdetail',$this->data);
         
    }
}
