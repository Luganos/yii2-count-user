<?php

namespace lugano\userCounter\models;
use Yii;

/**
 * This is the model class for table "tbl_visits".
 *
 * @property integer $visit_id
 * @property string $data
 * @property integer $hosts
 * @property integer $views
 */
class VisitsTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_visits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
            [['hosts', 'views'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'visit_id' => 'Visit ID',
            'data' => 'Data',
            'hosts' => 'Hosts',
            'views' => 'Views',
        ];
    }
    
    /**
     * @string current time
     * @return boolean 0 - was not visit today, 1 - was visit today
     */
     public function getVisit($data){
	
          $query = VisitsTable::find();
          $data = $query->select('visit_id') 
                  ->where(array('data' => $data))
                  ->one();
          
          if($data->visit_id){
              return true;
          } else{
              
             return false;
          }
	
    }
    
    /**
     * Get records for certain time interval
     * @string limit of records
     * @return int $out users and views for certain time
     */
    public function getVisitWeek($limit){
        
        
           $query = VisitsTable::find()->orderBy("data DESC")->limit($limit)->all();
		 
           return $query;
	
    }
    
    
   /**
     * Get records for certain day
     * @string records for certain day
     * @return int $out users and views for certain time or 0 if does not exist
   */ 
   public function getVisitDay($data){
	      
          $query = VisitsTable::find();
          $data = $query->select('*') 
                  ->where(array('data' => $data))
                  ->one();
          
          if($data->visit_id){
              return array('views' => $data->views, 'hosts' => $data->hosts);
          } else{
              
             return array('views' => 0, 'hosts' => 0);
          }

	
    }
    
    
   /**
     * Insert new record for current day
     * @string $data records for certain day
   */
    public function setVisitDate($data){
        
            $query = new  VisitsTable;
            $query->data = $data;
            $query->hosts = 1;
            $query->views = 1;
            $query->save();

	
    }
    
    
   /**
     * Increase amount views for day
     * @string $data for certain day
   */
    public function setVisitViews($data){
	
	      $post = VisitsTable::find()->select("*")->where(array('data' => $data))->one();
              if($post->views){
                  
                  $post->views += 1;
	          $post->save(); 
              }
	      return;   
	
    }
    
    
   /**
     * Increase both amount views for day and hosts for day
     * @string $data for certain day
   */
    public function setVisitViewsHosts($data){
	
            	
	      $post = VisitsTable::find()->select("*")->where(array('data' => $data))->one();
              if($post->views && $post->hosts){
                  
                  $post->views += 1;
                  $post->hosts += 1;
	          $post->save(); 
              }
	      return;
       
	
    }

    /**
     * @inheritdoc
     * @return TblVisitsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TblVisitsQuery(get_called_class());
    }
}
