<?php

/**
 * Created by ChengLi.
 * User: GatorRentor
 * Date: 2016/11/16
 * Time: 19:56
 */
class Login extends Controller
{
    /*
     * for REST request on login
     * This method handles what happens when frontend issue REST request  to http://yourproject/apt/login/
     */

    public function index()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        header('Content-Type: application/json;charset=UTR-8');
        $email = $_GET["loginname"];
        $password = $_GET["password"];
        $user_info = $this->model->getUserInfo($email);
        if ($user_info == false) {
            echo json_encode(array('valid_username' => false, 'valid_password' => false, 'authentic_user' => false));
            return;
        }


        if ($user_info->password == $password) {
            $_SESSION['user_name'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['authentic_user'] = true;
            echo json_encode(array('valid_username' => true, 'valid_password' => true, 'authentic_user' => true));
//            echo json_encode($_SESSION);
        } else {
            echo json_encode(array('valid_username' => true, 'valid_password' => false, 'authentic_user' => false));
        }
    }
}