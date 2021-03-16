<?php
namespace App\Http\Controllers\API;
use App\Interfaces\Statuscodes;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use Mail;

use App\Http\Controllers\Controller as Controller;
class BaseController extends Controller
{



    public function push_notification($device_id,$message){
        //API URL of FCM
        $url = env('FIREBASE_URL', 'https://fcm.googleapis.com/fcm/send');
        $api_key = env('FIREBASE_API_KEY');
        $fields = array (
            'registration_ids' => array (
                    $device_id
            ),
            'data' => array (
                    "message" => $message
            )
        );

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }



 public function send_sms($mobileNumber=null,$message=null){
    if($mobileNumber==null ){
       return response()->json(['status'=> Statuscodes::InvalidRequestFormat,'message'=>'Invalid mobile number']);
     }
     if($message==null){
       return response()->json(['status'=> Statuscodes::InvalidRequestFormat,'message'=>'Invalid message formate']);
     }

     $postData = array(
       'authkey' => env('SMS_API_KEY'),
       'mobiles' => '91'.$mobileNumber,
       'message' => urlencode($message),
       'sender' => env('SMSAPI_SENDER'),
       'route' => env('SMSAPI_ROUTE')
   );
   $url=env('SMSAPI_URL');
     $ch = curl_init();
     curl_setopt_array($ch, array(
         CURLOPT_URL => $url,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_POST => true,
         CURLOPT_POSTFIELDS => $postData
         //,CURLOPT_FOLLOWLOCATION => true
     ));
     //Ignore SSL certificate verification
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     //get response
     $output = curl_exec($ch);
     //Print error if any
     if(curl_errno($ch))
     {
         return response()->json(['status'=> Statuscodes::InvalidRequestFormat,'message'=>curl_error($ch)]);
     }
     curl_close($ch);
     //return response()->json(['status'=> Statuscodes::InvalidRequestFormat,'message'=>$output]);
   }

   /* Send mail */
  
   public function send_mail($name, $email)
  {
    $data = array('name' => $name, 'email' => $email);
    $mail = Mail::send('maillayout/register_mail', $data, function ($message) use ($email) {
      $message->to($email)->subject('Welcome to The Cardalog !');
      $message->from('adityashivhare@younggeeks.in', 'Cardalog');
    });

    return $mail;
  }

  public function send_mail_otp($email,$otp)
  {
    $data = array('email' => $email,'otp'=>$otp);
    $mail = Mail::send('maillayout/otp_mail', $data, function ($message) use ($email) {
      $message->to($email)->subject('Cardalog otp verification!');
      $message->from('adityashivhare@younggeeks.in', 'Cardalog');
    });

    return $mail;
  }

  
  public function twillo_send_mobile_sms($mobile,$message)
  {
      /*$accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
      $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];*/
      $accountSid = 'AC1c7d922db5a77da7dfb9609926a9a8f3';
      $authToken  = '877a055ffae52255a72c3920305d35a9';
      
      $appSid     = '';
      $client = new Client($accountSid, $authToken);
      try
      {
        
       $twilio_number = "+19713184296";
     /*  $client->messages->create('+'.$mobile, // Where to send a text message (your cell phone?)
          array(
              'from' => $twilio_number,
              'body' => $message,
          )
      );*/
      $client->messages->create(
        // Where to send a text message (your cell phone?)
        '+91'.$mobile,
        array(
            'from' => $twilio_number,
            'body' => $message
        )
    );
    
 }
      catch (Exception $e)
      {
        return response()->json(['status'=> Statuscodes::InvalidRequestFormat,'message'=> $e->getMessage()]);
        
      }
  }

  

}
