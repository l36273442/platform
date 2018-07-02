<?php
class CoinModel extends CActiveRecord{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return "platform_coin";
    }
    public function getCoinsByIds( $ids = array()){
        if(empty($ids)){
            return false;
        }   
        $c = new CDbCriteria;
        $c->addInCondition('id', $ids ); 
        $list = $this->findAll($c);
        if( empty($list) ){
            return array();
        }
        $data = array();
        foreach( $list as $v ){
            $data[] = $v->attributes;
        }
        return $data;
    }
}
