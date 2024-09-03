<?php

require __DIR__ . '/../../config/constants.php';
require __DIR__ . '/../models/Login.model.php';

class LoginController
{
    private $loginModel;

    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }

    private function sanitizeInputs(): array
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return [
            'email' => filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL),
            'password' => trim($data['password'] ?? ''),
        ];
    }

    private function verifyPassword(string $password, ?string $hashedPassword): bool
    {
        return $hashedPassword && password_verify($password, $hashedPassword);
    }

    private function handleSuccessfulLogin(string $userType, $email): void
    {
        unset($_SESSION['email']);

        $userRedirects = [
            'user' => 'user/homepage.php',
            'admin' => 'admin/homepage.php',
        ];

        if (isset($userRedirects[$userType])) {
            $_SESSION["loggedIn-$userType"] = true;
            $_SESSION['user-id'] = $this->loginModel->getUserId($email);
            $response = [
                'success' => true,
                'redirect' => ROOT_URL . ($userType === 'admin' ? 'admin/homepage.php' : 'user/homepage.php')
            ];
            echo json_encode($response);
        }
    }

    private function handleInvalidLogin(string $email): void
    {
        $_SESSION['email'] = $email;
        $response = [
            'success' => false,
            'msg' => 'Invalid email or password'
        ];
        echo json_encode($response);
    }

    public function login(): void
    {
        $userInputs = $this->sanitizeInputs();
        $hashedPassword = $this->loginModel->getHashedPassword($userInputs['email']);
        $userType = $this->loginModel->getUserType($userInputs['email']);

        if ($this->verifyPassword($userInputs['password'], $hashedPassword)) {
            $this->handleSuccessfulLogin($userType, $userInputs['email']);
            $_SESSION['user-id'] = $this->loginModel->getUserId($userInputs['email']);
        } else {
            $this->handleInvalidLogin($userInputs['email']);
        }
    }
}

$init = new LoginController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $init->login();
} else {
    return;
}
