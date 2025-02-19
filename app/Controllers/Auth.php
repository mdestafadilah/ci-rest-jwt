<?php

namespace App\Controllers;

use App\Models\UsersModel;
use Codeigniter\HTTP\Response;
use Codeigniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Auth extends BaseController
{
    /**
     * Register a new user
     * @return Response
     * @throws ReflectionException
     */
    public function register()
    {
        $rules = [
            'username' => 'required',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]'
        ];

        $input = $this->getRequestInput($this->request);
        if(!$this->validateRequest($input, $rules)) {
            return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $userModel = new UsersModel();
        $userModel->save($input);

        return $this
                ->getJWTForUser(
                    $input['email'],
                    ResponseInterface::HTTP_CREATED
                );
    }

    /**
     * Authenticate Existing User
     * @return Response
     */
    public function login()
    {
        $rules = [
            'email' => 'required|min_length[6]|max_length[50]|valid_email',
            'password' => 'required|min_length[8]|max_length[255]|validateUser[email, password]'
        ];

        $errors = [
            'password' => [
                'validateUser' => 'Invalid login credentials provided'
            ]
        ];

        $input = $this->getRequestInput($this->request);

        if(!$this->validateRequest($input, $rules, $errors)) {
            return $this
                        ->getResponse(
                            $this->validator->getErrors(),
                            ResponseInterface::HTTP_BAD_REQUEST
                        );
        }
        return $this->getJWTForUser($input['email']);
    }

    private function getJWTForUser(
        string $emailAddress,
        int $responseCode = ResponseInterface::HTTP_OK
    ){
        try {
            $model = new UsersModel();
            $user = $model->findUserByEmailAddress($emailAddress);
            unset($user['password']);

            helper('jwt');

            return $this
                        ->getResponse(
                            [
                                'message' => 'Authentikasi user Berhasil!',
                                'users' => $user,
                                'access_token' => getSignedJWTForUser($emailAddress)
                            ]
                        );

        } catch (Exception $exception) {
            return $this
                    ->getResponse(
                        [
                            'error' => $exception->getMessage(),
                        ],
                        $responseCode
                    );
        }
    }
    
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
