<?php

namespace lugano\userCounter\models;
use Yii;

/**
 * This is the model class for table "tbl_ips".
 *
 * @property integer $id
 * @property string $user_id
 */
class IpsTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_ips';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip_address'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip_address' => 'IP adress',
        ];
    }
    
    /**
     * Delete all records from table
    */
    public function deleteIps(){
	
	$query = IpsTable::deleteAll();
    }
    
    /**
     * Insert record about current visitor
     * @string $visitorIp - ip of current visitor
    */
    public function insertIps($visitorIp){
        
        
        $query = new IpsTable;
        $query->ip_address = $visitorIp;
        $query->insert();
		
    }
    
    /**
     * Get record about current visitor
     * @string $visitorIp - ip of current visitor
     * @return boolean 0 - visitor does not exist, 1 - visitor exists
    */
    public function getIps($visitorIp){
	
	  $query = IpsTable::find();
          $data = $query->select('id') 
                  ->where(array('ip_address' => $visitorIp))
                  ->one();
          
          if($data->id){
              return true;
          } else{
              
             return false;
          }
          
    }

    /**
     * @inheritdoc
     * @return TblIpsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TblIpsQuery(get_called_class());
    }
}
