<?php

class Session
{
    /*--------------------------------------------------------------*/
    /* Declaring session properties
     *
     */
    private $signed_in = false;

    public $user_id;

    public $message;

    /*--------------------------------------------------------------*/
    /* Instantiating constructor
     *
     */

    function __construct()
    {

        session_start();

        $this->check_the_login();

        $this->check_message();


    }

    /*--------------------------------------------------------------*/
    /* Method message
     * Use to pass message across the app
     */

    public function message($msg = "")
    {

        if (!empty($msg)) {

            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    /*--------------------------------------------------------------*/
    /* Method Check Message
     * Use to check when message is available and set it
     */

    public function check_message()
    {

        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
        } else {

            $this->message = "";
        }
    }

    /*--------------------------------------------------------------*/
    /* Use to unset message
     *
     * Use to unset message
     */

    public function unset_message()
    {

        unset($_SESSION['message']);
    }

    /*--------------------------------------------------------------*/
    /* Method Is SignedIn
     *
     * Use to check Auth user
     */

    public function is_signed_in()
    {

        return $this->signed_in;
    }

    /*--------------------------------------------------------------*/
    /* Method Login
     *
     * Help login user
     */
    public function login($user)
    {

        if ($user) {

            $this->user_id = $_SESSION['user_id'] = $user;
            $this->signed_in = true;

        }
    }

    /*--------------------------------------------------------------*/
    /* Method Logout
     *
     * Help log user out
     */
    public function logout()
    {

        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    /*--------------------------------------------------------------*/
    /* Method Check The Login
     *
     * Double check login user
     */

    private function check_the_login()
    {

        if (isset($_SESSION['user_id'])) {

            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else {


            unset($this->user_id);
            $this->signed_in = false;
        }

    }


    //END OF CLASS SESSION
}

/*--------------------------------------------------------------*/
/* Creating and instance of the class
 *
 */
$session = new Session();
?>