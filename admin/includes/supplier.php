<?php

class Supplier
{

    /*--------------------------------------------------------------*/
    /* Method Find All Supplier
     *
     * @success: Return list of all supplier
     */
    public static function find_all()
    {

        $url = "https://api.paystack.co/transferrecipient";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Authorization: Bearer sk_test_3323644da3a719b70c0e54e7da4b877e9e644d9b',
            'Content-Type: application/json',

        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec($ch);

        curl_close($ch);

        if ($request) {
            return $result = json_decode($request);
        }


    }

    /*--------------------------------------------------------------*/
    /* Method Create Supplier
     *
     * @use: To create a new supplier
     */


    public static function create($account_name, $account_number, $bank_code, $email = '', $name = '')
    {

        //Set other parameters as keys in the $postdata array
        $postdata = array(
            'type' => TYPE,
            'account_name' => $account_name,
            'email' => $email,
            'name' => $name,
            'account_number' => $account_number,
            'bank_code' => $bank_code,
            'currency' => CURRENCY,

        );
        $url = "https://api.paystack.co/transferrecipient";

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

                return true;
            }
            return false;
        } else {

            return false;
        }

    }

    /*--------------------------------------------------------------*/
    /* Method Update All Supplier
     *
     * @success: Update the calling supplier
     */

    public static function update($account_name, $account_number, $bank_code, $email = '', $name = '')
    {

        //Set other parameters as keys in the $postdata array
        $postdata = array(
            'account_number' => $account_number,
            'account_name' => $account_name,
            'type' => TYPE,
            'name' => $name,
            'email' => $email,
            'bank_code' => $bank_code

        );
        $url = "https://api.paystack.co/transferrecipient/";

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

            return ($response->status == 'true') ? true : false;

        } else {

            return false;
        }

    }

    /*--------------------------------------------------------------*/
    /* Method Account Verify
     *
     * @success: Return true if account number resolve
     */

    public static function account_verify($account_num, $account_name, $bank_code)
    {

        $url = 'https://api.paystack.co/bank/resolve?account_number=' . $account_num . '&bank_code=' . $bank_code;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Authorization: Bearer sk_test_3323644da3a719b70c0e54e7da4b877e9e644d9b',
            'Content-Type: application/json',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $request = curl_exec($ch);

        curl_close($ch);

        if ($request) {

            $response = json_decode($request);

            if ($response->status == 'true' && ($response->data->account_name == $account_name)) {

                return true;

            } else {

                return false;

            }

        } else {

            return false;
        }

    }

    /*--------------------------------------------------------------*/
    /* Method Delete Supplier
     *
     * @success: Set a Supplier to inactive
     */

    public static function delete($id)
    {


        $url = "https://api.paystack.co/transferrecipient/" . $id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
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

            return ($response->status == 'true') ? true : false;

        } else {

            return false;
        }

    }

    /*--------------------------------------------------------------*/
    /* Method List All Transfer
     *
     * @success: Return all the list of Transfer
     */


    public static function listTransfers($perPage = '', $page = '')
    {

        $url = "https://api.paystack.co/transfer?perPage=" . $perPage . "&page=" . $page;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
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


// END OF CLASS USER

}
?>