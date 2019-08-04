<?php

class Transfer
{

    /*--------------------------------------------------------------*/
    /* Method Check Balance
     *
     * @Use: To check the account balance
     */
    public function check_balance()
    {

        $url = "https://api.paystack.co/balance";

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

            return ($response->status == 'true') ? $response->data : false;

        } else {

            return false;
        }

    }

    /*--------------------------------------------------------------*/
    /* Method Balance
     *
     * @use: Return the Balance in a required format NGN money-format
     */


    public static function balance($e = 0)
    {

        $details = self::check_balance();

        foreach ($details as $detail) {

            if ($e != 1) {

                return $detail->currency . " " . number_format($detail->balance / 100, 2);

            }

            return $detail->balance;
        }

    }

    /*--------------------------------------------------------------*/
    /* Method Make Transfer
     *
     * @Use: To make fund transfer
     */

    public static function make_transfer($amount, $recipient, $reason = '')
    {

        //Set other parameters as keys in the $postdata array
        $postdata = array(
            'source' => 'balance',
            'reason' => $reason,
            'amount' => $amount,
            'recipient' => $recipient,

        );
        $url = 'https://api.paystack.co/transfer';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));  //Post Fields
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

            if ($response->status == 'true' && ($response->message == "Transfer requires OTP to continue")) {

                return $response->data;

            } else {

                return false;

            }

        } else {

            return false;
        }

    }

    /*--------------------------------------------------------------*/
    /* Method Fetch Transfer
     *
     * @Use: To get the details of a transfer
     */

    public static function fetch_transfer($id)
    {

        //Set other parameters as keys in the $postdata array
        $url = "https://api.paystack.co/transfer/" . $id;

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

            return ($response->status == 'true') ? $response->data : false;

        } else {

            return false;
        }


    }

    /*--------------------------------------------------------------*/
    /* Method Finalize Transfer
     *
     * @Use: To complete Transfer
     */

    public static function finalize_transfer($transfer_code, $otp)
    {

        //Set other parameters as keys in the $postdata array
        $postdata = array(
            'transfer_code' => $transfer_code,
            'otp' => $otp,

        );
        $url = 'https://api.paystack.co/transfer/finalize_transfer';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));  //Post Fields
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

                return $response;

            } else {

                return false;

            }

        } else {

            return false;
        }

    }


} // END OF CLASS


?>