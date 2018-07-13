<?php
class PowerContractOrderModel extends CActiveRecord{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return "platform_power_contract_order";
    }
    public function getList( $uid = '' , $status = '' , $page = 1 ,$size = 20  ){
        $c = $criteria = new CDbCriteria();
        $c->order = 'id ASC';
        if( $status !== '' ){
            $c->addCondition('status='.$status);
        }
        if( $uid !== '' ){
            $c->addCondition('uid='.$uid);
        }
        $count = $this->count($c);
        $p = new CPagination($count);
        $p->pageSize=$size;
        $p->currentPage = $page;
        $p->applyLimit($c);
        if( $count > 0 ){
            $list = $this->findAll($c);  
            $pages = ceil($count/$size);
            $data =array();
            if( $list ){
                foreach( $list as $v ){
                    $data[] = $v->attributes;
                }    
                return array('size' => $size , 'page' => $page , 'total' => $count , 'pages' => $pages , 'list' => $data );

            }
        }
        else{
            return array('size' => $size , 'page' => $page , 'total' => $count , 'pages' => 0 , 'list' => array() );
        }
    }
    public function getContractsByIds( $ids = array()){
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
