<?php

//namespace app\models;

namespace lugano\userCounter\models;
use Yii;

/**
 * This is the model class for table "tbl_data".
 *
 * @property integer $id
 * @property double $YMD
 */
class DataTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['YMD'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'YMD' => 'Ymd',
        ];
    }
       
     /**
     * 
     * @return float current time.
     */ 
    public function getTime(){
	
          $query = DataTable::find();
          $data = $query->select('YMD') 
                  ->where(array('id' => 1))
                  ->one();
	       
          return  $data->YMD;
	}
	
    /**
     * @sting $date time for record in DB
     */   
    public function setTime($date){
	
           $query = DataTable::findOne(1);
           $query->YMD = $date;
           $query->update();
          
           //$write = self::model()->findByPk(1);
           //$write->YMD = $date;
           //$write->save();
		 
    }

    /**
     * @inheritdoc
     * @return TblDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TblDataQuery(get_called_class());
    }
}
