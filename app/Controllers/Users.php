<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use \Firebase\JWT\JWT;

class Users extends ResourceController
{
    public function register()
    {
        $rules = [
            "username" => "required",
            "password" => "required",
        ];

        $messages = [
            "username" => [
                "required" => "UserName is required"
            ],
            "password" => [
                "required" => "password is required"
            ],
        ];

        if (!$this->validate($rules,$messages)) {
            $res = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
        }else{
            $usersModel = new UsersModel();

            $data = [
                "username" => $this->request->getVar("username"),
                "password" => $this->request->getVar("password")
            ];

            if ($usersModel->insert($data)) {
                $res = [
                    'status' => 200,
                    'error' => false,
                    'messages' => 'Berhasil, User ditambahkan',
                    'data' => []
                ];
            } else {
                $res = [
                    'status' => 500,
                    'error' => true,
                    'messages' => 'Gagal menambahkan user',
                    'data' => []
                ];
            }
        }
        return $this->respondCreated($res);
    }

    private function getKey()
    {
        return "my_secreet_codeigniter_4";
    }

    public function login()
    {
        $rules = [
            "username" => "required",
            "password" => "required",
        ];

        $messages = [
            "username" => [
                "required" => "Username required",
            ],
            "password" => [
                "required" => "password is required"
            ],
        ];

        if(!$this->validate($rules, $messages)) {
            $res = [
                'status' => 500,
                'error' => true,
                'messages' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respondCreated($res);

        } else {
            $usersModel = new UsersModel();

            $userData = $usersModel->where("username", $this->request->getVar("username"))->first();

            if (!empty($userData)) {
                if (password_verify($this->request->getVar("password"), $userdata['password'])) {

                    $key = $this->getKey();

                    $iat = time();
                    $nbf = $iat + 10;
                    $exp = $iat + 3600;

                    $payLoad = [
                        'iss' => 'the_claim',
                        'aud' => 'the_aud',
                        'iat' => $iat,
                        'nbf' => $nbf,
                        'exp' => $exp,
                        'data' => $userData
                    ];

                    $token = JWT::encode($payLoad, $key);

                    $res = [
                        'status' => 200,
                        'error' => false,
                        'messages' => 'Berhasil Masuk',
                        'data' => [
                            'token' => $token
                        ]
                    ];

                    return $this->respondCreated($res);

                } else {
                    $res = [
                        'status' => 500,
                        'error' => true,
                        'messages' => 'Kesalahan details',
                        'data' => []
                    ];

                    return $this->respondCreated($res);
                }
            } else {
                $res = [
                    'status' => 500,
                    'error' => true,
                    'messages' => 'User tidak ditemukan',
                    'data' => []
                ];
                return $this->respondCreated($res);
            }

        }

    }

    public function details()
    {
        #TODO:
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
