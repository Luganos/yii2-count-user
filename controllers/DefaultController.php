<?php

namespace lugano\userCounter\controllers;

use lugano\userCounter\models\DataTable;
use lugano\userCounter\models\VisitsTable;
use lugano\userCounter\models\IpsTable;
use Yii;



/* Default controller */

class DefaultController
{
   
    /**
   * @var string contains email address 
   */
   private $posmail;
   
   /**
   * @var string contains description about sender
   */
   private $posname;
   
   /**
   * @var int contains frequent of send report
   */
   private $sendTime;
   
   
    /**
     * @string $posmail contains email
     * @string $posname contains name of sender
     * @int $sendTime contains interval between reports
   */
   function __construct($settings = array())
   {
      $this->posmail = $settings['posmail']; 
      $this->posname = $settings['posname'];
      
      if(((int)$settings['period'] >= 1) && ((int)$settings['period'] <= 366)){
          
         $this->sendTime = (int)$settings['period'] * 86400; 
      } else{
          
          if((int)$settings['period'] < 1){
              
              $this->sendTime = 1 * 86400;
          }
          
          if((int)$settings['period'] > 366){
              
              $this->sendTime = 366 * 86400;
          }
          
          
      }
      
   }
   
/**
 * Sends a message about users and views.
 * 
 * return array
*/
 public function counter()
 {
      //Load models
      $dataDb = new DataTable();
      $visitDb = new VisitsTable();
      $IpsDb = new IpsTable();
		

        //Mail's settings
        $charset = "windows-1251";
        $subject = "";
        $content = "text/html";
        $message = "";


        // Get IP-address and keep current date
        $visitorIp = Yii::$app->request->getUserIP();
        $date = date("Y-m-d");
		
        //Does anybody been today?
        $res = $visitDb->getVisit($date);

        //Get number of days from counter
        $predateShow = $dataDb->getTime();
        $thisDate = time();
        
        //If today not yet been visitors
        if ($res == 0){
		
           //Send report about guests for last 7 days
           if (($thisDate - $predateShow) > $this->sendTime){
		   
              //Get data for 7 days
              $visit = $visitDb->getVisitWeek(7);
	 
              //Record current time to DB
              $dataDb->setTime($thisDate);
	 
	      $summaHosts = 0;
              $summaViews = 0;
	
              foreach ($visit as $summa){
	
	                $summaViews =  $summaViews + $summa->views;
	                $summaHosts = $summaHosts + $summa->hosts;
	          }
	 
	      //Content of report
	      $message = 'Views for 7 days <br> Views: '.$summaViews.'<br> Users: '.$summaHosts.'';
	 
	      //Theme of letter
	      $subject = 'Report for 7 work site days';
	 
	      //Header
	      $headers  = "MIME-Version: 1.0\r\n";
              $headers .= "Content-Type: $content  charset=$charset\r\n";
              $headers .= "Date: ".date("Y-m-d (H:i:s)",time())."\r\n";
              $headers .= "From: \"".$this->posname."\" <".$this->posmail.">\r\n";
              $headers .= "X-Mailer: My Send E-mail\r\n";
	
	      //Send letter
	      mail("$this->posmail","$subject","$message","$headers");
            }
   
         // Clear table ips
         $IpsDb->deleteIps();

         // Record to DB IP current guest		  
         $IpsDb->InsertIps($visitorIp);

         // Write into DB date of visit, and set both quantity of views and hosts into 1
         $visitDb->setVisitDate($date);
		  
        } else{
             
             //Is there in DB a current IP?
             $currentIp = $IpsDb->getIps($visitorIp);

             //IP is existing(i.e not unique IP)
             if ($currentIp == 1){
			 
                 //Add for current date one view
                 $visitDb->setVisitViews($date);
				 
             } else{
                 // Write into DB the IP of current visitor
                 $IpsDb->InsertIps($visitorIp);
        
                 // Add into DB +1 unique host and +1 view
                 $visitDb->setVisitViewsHosts($date);
             }
        }
		
        
        return $visitDb->getVisitDay($date);
     }

}
