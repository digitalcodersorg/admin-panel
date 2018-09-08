<?php

use common\models\Utility;

use yii\helpers\Url;
 
$this->title = "Error";
?>

<div class="middle-box text-center animated fadeInDown">
	    <div><img class="img-responsive" src="<?= Url::toRoute('img/404.gif') ?>"/></div>
	<?php if($exception->statusCode == '403') { ?>
<br>

    <h3 class="font-bold">Access Denied</h3>

    <div class="error-desc">
       You are not authorized to access this page.
     
    </div>
    <br>

    <div> <a href="/" class="btn btn-primary">Home Page</a></div>
	
	<?php } else{ ?>
    

<br>
   

	    <h3 class="font-bold">Page Not Found</h3>

    <div class="error-desc">
        Sorry, but the page you are looking for does not exist. Try checking the URL for errors, then hit the refresh button on your browser.
         
           <br>
<br>

           <div> <a href="/" class="btn btn-primary">Home Page</a></div>
      
    </div>
		<?php } ?>
</div>



