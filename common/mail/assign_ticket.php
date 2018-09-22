
 <?php
   $value = json_decode($model['email_body']);
 ?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
     <meta name="viewport" content="width=device-width" />
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <title>User</title>
     <link href="styles.css" media="all" rel="stylesheet" type="text/css" />
 </head>

 <body>

 <table style="background-color: #f6f6f6;
 width: 100%;">
     <tr>
         <td></td>
         <td style="display: block !important; max-width: 600px !important; margin: 0 auto !important;
           clear: both !important; width: 100% !important;" width="600">
             <div style="max-width: 600px; margin: 0 auto; display: block; padding: 20px;">
                 <table  style="background: #fff; border: 1px solid #e9e9e9; border-radius: 3px;" width="100%" cellpadding="0" cellspacing="0">
                     <tr>
                         <td style="padding:60px 30px 30px 30px  !important; background:url(<?= Yii::$app->params['baseUrl'] ?>img/td_mailler_logo.png) no-repeat 20px 20px;">
                             <table  cellpadding="0" cellspacing="0" style="border-top: 1px solid rgb(221, 221, 221);
padding: 10px 0px 0px;">

                                 <tr>
                                     <td style="padding: 0 0 20px;">
                                         <div style=" font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;
                                         color: #000;
                                         margin:0;
                                         line-height: 1.2;
                                         font-weight:nornal; font-size:22px;">Ticket Assigned To <?= $value->assigned_to_name;?> By <?= $value->assigned_by_name;?></div>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td style="padding: 0 0 20px; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; color:#747474; font-size:16px;">
                                       A New tickets have been assigned to you. Please click <a href="<?= $value->ticket_url ?>"> here </a> to get started.
                                     </td>

                                 </tr>
                               </table>
                         </td>
                     </tr>
                 </table>
                 <div style="  width: 100%;
                   clear: both;
                   color: #999;
                   padding: 20px;">
                     <table width="100%">
                         <tr>
                             <td style="padding: 0 0 20px;"><a  href="<?= Yii::$app->params['baseUrl'] ?>"><img width="150" src="<?= Yii::$app->params['baseUrl'] ?>img/flogo.png"></a></td>
                         </tr>
                     </table>
                 </div></div>
         </td>
         <td></td>
     </tr>
 </table>

 </body>
 </html>