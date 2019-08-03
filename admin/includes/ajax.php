<?php

ob_start();

require_once("init.php");

if(!$session->is_signed_in()){ echo "You are cheating :)"; exit;}

if($_POST['action'] == 'reSendCode'){

    return reSendCode();

}elseif ($_POST['action'] == 'accountVerify'){

    return accountVerify();
}

function accountVerify()
{
    $url = 'https://api.paystack.co/bank/resolve?account_number=' . $_POST['account_number'] . '&bank_code=' . $_POST['bank_code'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $headers = [
        AUTH,
        'Content-Type: application/json',
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $request = curl_exec($ch);

    curl_close($ch);

    if ($request) {

        $response = json_decode($request);

        if ($response->status == 'true') {
            //echo json_encode(['code' => 200, 'msg' => $account_name->data->account_name]);
            echo json_encode(['code' => 200, 'msg' => $response->data->account_name]);
            exit;
        } elseif ($response->status == 'false') {

            echo json_encode(['code' => 404, 'msg' => $response->message]);
        }

    }
    echo json_encode(['code' => 404, 'msg' => 'fails']);

}

 function reSendCode(){

     //Set other parameters as keys in the $postdata array
         $postdata =  array(
             'transfer_code' => $_POST['transfer_ref'],
             'reason' => 'transfer'
         );
        $url = 'https://api.paystack.co/transfer/resend_otp';

     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            AUTH,
            'Content-Type: application/json',

        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec ($ch);

     curl_close($ch);

     if ($request) {

         $response = json_decode($request);

         if ($response->status == 'true') {

             echo json_encode(['code' => 200, 'msg' => $response->message]);

         } else{

             echo json_encode(['code' => 404, 'msg' => $response->message]);
         }

     }else {

         echo json_encode(['code' => 404, 'msg' => 'Fails']);
     }


 }


?>