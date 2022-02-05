<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailLog;
use App\Models\User;

class EmailController extends Controller
{
    
    /**
    *  Send Invite Email 
    **/
    public function SendInvite(Request $req)
    {
        
        $req->validate([
            
            'email' => ['required', 'email'],  
            'name'  => 'required'
        ]);
        
        $body = '<html lang="en"><head>
                      </head>
                      <body>
                       <div class="container">
                            <div class="row">
                                <div class="" style=" ">
                                    <div class="" style="
                                                                                padding-left: 12px;
                                                                                padding-top: 17px;
                                                                                padding-bottom: 20px;
                                                                                background-repeat: repeat-x;
                                                                                background-color: #003771;
                                                                                color: white;
                                                                                border-radius: 2px;
                                                                                ">Invitaton for SignUp
                                    </div>
                                    <div class="" id="" style="padding: 15px;  background-color: #FFFFFF;">
                                    Hi '.$req->name.',<br>'.env("MAIL_FROM_NAME").' Send you Invitaton for signup at at his demo site.
                                    <br><br><a href="http://127.0.0.1:8000/register">Click Here</a> for SignUp.
                                    <br><br><br>
                                    Thanks,<br> 
                                    Regards,<br>
                                    '.env("MAIL_FROM_NAME").'
                ';

        $body .= '  </div></div></div></div></body>
                    </html>';

       
        
        
        $to = $req->email;
        if($this->SendEmail($to, $body))
        {
             return redirect('/home')->with('status', 'Email Sent!');
        }
        else
        {
            echo "Email not sent";
        }
                
       
    }


    public function SendPinCodeEmailAfterSignUp($toAddress, $username)
    {
        $pincode = random_int(100000, 999999);
        $body = 'Hi '.$username.'<br>'. 'This is you verification code. '. $pincode.' <br><br>Thanks,<br> 
                                    Regards,<br>
                                    '.env("MAIL_FROM_NAME");
        return $this->SendEmail($toAddress, $body, $pincode);

    }
    

    public function email_verification(Request $req)
    {

        $req->validate([
            'pincode' => ['required', 'min:6', 'max:6']
        ]);

        $email = auth()->user()->email;
        $id = auth()->user()->id;
        $email_log = EmailLog::where ('email_address',  $email)
        ->orderby('id', 'desc')
        ->take(5)->get();
 
        $log_pincode = '';
        foreach( $email_log as $log)
        {
         $log_pincode = $log->pin_code;
        }

        if($log_pincode == $req->pincode)
        {
            $user = User::find($id);
           
            $user->registered_at = date('Y-m-d H:i:s');
            $user->save();

            return redirect('/home')->with('status', 'Registerd successfuly!');

        }

        
        

    }

    public function SendEmail($to, $body, $pincode = '')
    {
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME')); 
        $email->setSubject("Invite for SignUp");
        $email->addTo($to);
        $email->addContent("text/html", $body);
        
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        
        if($sendgrid->send($email))
        {
            $EmailLog = new EmailLog();
            $EmailLog->email_address = $to;
            $EmailLog->body = $body;

            if(trim($pincode) !='')
            $EmailLog->pin_code = $pincode;

            $EmailLog->save();

            return true;
            
        }
        else
        {
            return false;
           
        }

    }
}
