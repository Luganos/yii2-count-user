# yii2-count-user
#Module of count of users for YII2 with report by email

Installation
 
Extension may be installed by taking the following simple steps:

 1. add "lugano/yii2-count-user": "*" to the require section of your composer.json file.
 2. run composer install to install the specified extensions.
 3. execute yii migrate --migrationPath=vendor/lugano/yii2-count-user/migrations
 
Usage

Suppose, You have site with 4 pages. These pages has been displaying user using 
SiteController. This SiteController extends Controller from YII2, and has methods , called
actionIndex, actionAdverbs, actionVerbs, actionDictionary.

Code below shows default YII2 controller for site.

SiteController extends Controller
{
   public $hosts;
   public $views;
   
   public function actionIndex(){
      
      self::countUser();
      return $this->render('index');
   }
   
   public function actionAdverbs(){
   
      self::countUser();
      return $this->render('adverbs');
   }
   
   public function actionVerbs(){
   
     self::countUser();
     return $this->render('verbs');
   }
   
   public function actionDictionary(){
   
      self::countUser();
      return $this->render('dictionary');
   }
}
 
In order to count users and views your site you must do several action:

1) Add use lugano\userCounter\controllers\DefaultController; in header file with your SiteController;

2) Add method in you SiteController(your default controller);
   
    public function countUser()
    {
	        $settings = array(
			                   'posmail' => 'xxxx@ukr.net',
			                   'posname' => 'my-site.com',
					   'period' => '1...365'
			                   );
            $temp = new DefaultController($settings);
            $report = $temp->counter();
            $this->views = $report['views'];
	    $this->hosts = $report['hosts'];
        
    }

3) Add two public properties $host and $views to your SiteController;

4) Call self::countUser() in each your method actionIndex, actionAdverbs, actionVerbs, actionDictionary
   
5) Add to your main.php file string like 
<?php echo 'Users:&nbsp; ' .$this->context->hosts .' &nbsp; '.'Views:&nbsp;'. $this->context->views; ?> 

Describing for variable $setting of class "DefaultController"

'posmail' - email will be receiving report from site;
'posname' - name for sender(your site);
'period' - period between reports from you site(not less than 1 and not more than 365 days);
