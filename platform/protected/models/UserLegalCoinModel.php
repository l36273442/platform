<?php
class UserLegalCoinModel extends CActiveRecord{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return "platform_user_Legal_coin";
    }
}
