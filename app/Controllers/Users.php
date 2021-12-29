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
            "email" => "required|valid_email|is_unique[users.email]|min_length[6]",
        ];

        $messages = [
            "username" => [
                "required" => "UserName is required"
            ],
            "email" => [
                "required" => "Email required",
                "valid_email" => "Email address is not in format"
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
                "email" => $this->request->getVar("email"),
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
            "email" => "required|valid_email|min_length[6]",
            "password" => "required",
        ];

        $messages = [
            "email" => [
                "required" => "Email required",
                "valid_email" => "Email address is not in format"
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

            $userData = $usersModel->where("email", $this->request->getVar("email"))->first();

            if (!empty($userData)) {
                if (password_verify($this->request->getVar("password"), $userData['password'])) {

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
        $key = $this->getKey();
        $authHeader = $this->request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();
        $token = $authHeader;

        try {
            $decode = JWT::decode($token, $key, array('HS256'));

            if ($decode) {
                $response = [
                    'status' => 200,
                    'error' => false,
                    'messages' => 'User Details',
                    'data' => [
                        'profile' => $decode
                    ]
                ];
                return $this->respondCreated($response);
            }
        } catch (Exception $e) {
            $response = [
                'status' => 401,
                'error' => true,
                'messages' => 'Access Dilarang',
                'data' => []
            ];
            return $this->respondCreated($response);
        }
    }

}
