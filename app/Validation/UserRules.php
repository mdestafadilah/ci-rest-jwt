<?php

namespace App\Validation;

use App\Models\UsersModel;
use Exception;

class UserRules 
{
    public function validateUser(string $str, string $fields, array $data): bool
    {
        try {
            $model = new UsersModel();
            $user = $model->findUserByEmailAddress($data['email']);
            return password_verify($data['password'], $user['password']);
        } catch (Exception $e) {
            return false;
        }
    }
}