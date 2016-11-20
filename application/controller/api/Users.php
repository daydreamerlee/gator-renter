<?php

require_once 'AbstractAPI.php';
/**
 * Created by Intesar Haider.
 * This class will strictly be used for USER specific CRUD
 * Date: 11/20/2016
 * Time: 2:57 AM
 */
class Users extends AbstractAPI  {


    public function index() {

        AbstractAPI::processRequest($_REQUEST);

        switch($this->method) {
            case 'POST':
                $this->addNewUser();
                break;
            case 'PUT':
                $this->updateUser();
                break;
            case 'GET':
                $this->getUserDetail();
                break;
            case 'DELETE':
                $this->deleteUser();
                break;
            default:
                _response("No Endpoint: $this->endpoint", 404);
        }
    }

    /**
     * METHOD : POST
     */
    public function addNewUser() {

        $requestPayload = $this->requestData;

        $userInfo = $this->model->getUserInfo($requestPayload['email']);
        if (isset($userInfo) && $userInfo != false) {
            AbstractApi::_response('User with same email already exist', 500);
            return;
        }

        // password encryption logic
        $requestPayload['password'] = Helper::encryptPassword($requestPayload['password']);
        $status = $this->model->saveNewUser($requestPayload);
        unset($requestPayload['password']);

        if($status==true) {
            AbstractApi::_response($requestPayload);
        } else {
            AbstractApi::_response("Something unexpected happened", 500);
        }
    }

    /**
     * METHOD : PUT
     */
    public function updateUser() {

        //$this->requestData['userID']   ---   this user needs to be updated and all the data will be in requestData array

        echo "Hello from updateUser";

    }

    /**
     * METHOD : GET
     */
    public function getUserDetail() {

        if(is_null($this->requestData)) { //get all the users
            echo "Hello from getUserDetail (get all the users)";
        } else {
            echo "Hello from getUserDetail (get specific user)";
        }

    }

    /**
     * METHOD : DELETE
     */
    public function deleteUser() {

        //if user id, that's need to be deleted is missing, show error
        if(is_null($this->requestData)) $this->_response('Invalid Request! User ID to delete is missing', 400);

    }
}