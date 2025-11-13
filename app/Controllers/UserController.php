<?php
namespace App\Controllers;

use App\Core\Request;
use App\Models\User;
use App\Core\Database;

class UserController {
    protected $userModel;

    public function __construct(Database $db) {
        // $this->userModel = new User($db);
    }

    public function index(Request $request) {
        $users = $this->userModel->all(); 

        return [
            'status_code' => 200,
            'data' => [
                'status' => 'success',
                'count' => count($users),
                'users' => $users
            ]
        ];
    }

    public function store(Request $request) {
        $data = $request->json();

        if (empty($data['name']) || empty($data['email'])) {
            return [
                'status_code' => 400, // Bad Request
                'data' => ['error' => 'Validation failed: Name and email required.']
            ];
        }

        $newUser = $this->userModel->create($data);

        return [
            'status_code' => 201, // Created
            'data' => [
                'status' => 'success',
                'user_id' => $newUser['id'],
                'message' => 'User created.'
            ]
        ];
    }
}