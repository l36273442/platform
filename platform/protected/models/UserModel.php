<?php
class UserModel extends CActiveRecord{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return "platform_user";
    }
    public function getUserByPhone( $country_code , $phone ){
        if( empty($country_code) || empty($phone) ) {
            return false;
        }
        $re = $this->find('country_code=:country_code and phone=:phone' , array(':country_code' => $country_code , ':phone' => $phone ));
        return $re;
    }
}
