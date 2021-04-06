<?php

namespace Megha\UserForm\Model\Api;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Webapi\Rest\Request;
use Megha\UserForm\Api\UserFormManagementInterface;
use Megha\UserForm\Model\UserFormFactory;

class UserFormManagement implements UserFormManagementInterface
{
    /**
     * @var UserFormFactory
     */
    private $userFormFactory;
    /**
     * @var Request
     */
    private $request;

    /**
     * UserFormManagement constructor.
     * @param UserFormFactory $userFormFactory
     * @param Request $request
     */
    public function __construct(
        UserFormFactory $userFormFactory,
        Request $request
    ) {
        $this->userFormFactory = $userFormFactory;
        $this->request = $request;
    }

    /**
     * @return \Megha\UserForm\Api\Data\UserFormInterface|void
     * @throws \Exception
     */
    public function saveUser()
    {
        $response   = [];
        $data       = $this->request->getRequestData();
        $model      = $this->userFormFactory->create();
        $passdata   = [
            "first_name" => $data['first_name'],
            "last_name"  => $data['last_name'],
            "email"      => $data['email'],
            "mobile"     => $data['mobile'],
            "dob"        => $data['dob']
        ];
        $model->addData($passdata);
        try {
            $saveData                           = $model->save();
            if ($saveData) {
                $response['error'] 			    = "";
                $response['status'] 			= 1;
                $response['id'] 				= $model->getData('id');
            } else {
                $response['error'] 			    = "Something went wronng, pleasee try again..!";
                $response['status'] 			= 0;
                $response['id'] 				= 0;
            }
        } catch (LocalizedException $e) {
            $response['error'] 			        = $e->getMessage();
            $response['status'] 			    = 0;
            $response['id'] 				    = 0;
        }
        echo json_encode($response);
        exit();
    }
}
