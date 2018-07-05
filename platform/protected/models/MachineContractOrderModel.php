<?php
class MachineContractOrderModel extends CActiveRecord{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return "platform_machine_contract_order";
    }

}
