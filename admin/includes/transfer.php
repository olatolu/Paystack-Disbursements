<?php 

class Transfer{

    public function check_balance(){

        $url = "https://api.paystack.co/balance";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            AUTH,
            'Content-Type: application/json',

        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec ($ch);

        curl_close ($ch);

        if ($request) {

            $response =json_decode($request);

            return ($response->status == 'true') ? $response->data : false;

        }else{

            return false;
        }

    }


    public static function balance($e = 0){

        $details = self::check_balance();

        foreach ($details as $detail){

            if($e != 1) {

                return $detail->currency . " " . number_format($detail->balance / 100, 2);

            }

            return $detail->balance;
        }

    }

    public static function make_transfer($amount, $recipient, $reason=''){

        //Set other parameters as keys in the $postdata array
            $postdata =  array(
                'source' => 'balance', //$name,
                'reason' => $reason, //$reason,
                'amount' => $amount,
                'recipient' => $recipient,

            );
        $url = 'https://api.paystack.co/transfer';

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

        curl_close ($ch);

        if ($request) {

            $response =json_decode($request);

            if($response->status == 'true' && ($response->message == "Transfer requires OTP to continue")) {

                return $response->data;

            }else{

                return false;

            }

        }else{

            return false;
        }

    }

    public static function fetch_transfer($id){ // will be use for update

        //Set other parameters as keys in the $postdata array
        $url = "https://api.paystack.co/transfer/".$id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            AUTH,
            'Content-Type: application/json',

        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec ($ch);

        curl_close ($ch);

        if ($request) {

            $response =json_decode($request);

            return ($response->status == 'true') ? $response->data : false;

        }else{

            return false;
        }


    }

    public static function finalize_transfer($transfer_code, $otp){

        //Set other parameters as keys in the $postdata array
        $postdata =  array(
            'transfer_code' => $transfer_code,
            'otp' => $otp,

        );
        $url = 'https://api.paystack.co/transfer/finalize_transfer';

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

        curl_close ($ch);

        if ($request) {

            $response =json_decode($request);

            if($response->status == 'true') {

                return $response;

            }else{

                return false;

            }

        }else{

            return false;
        }

    }




} // END OF CLASS









?>