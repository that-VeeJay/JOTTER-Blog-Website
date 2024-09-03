<?php
require __DIR__ . '/../../config/constants.php';
require __DIR__ . '/../models/Register.model.php';

class RegisterController
{
    private $registerModel;
    private static $errors = [];

    const PASSWORD_LENGTH = 8;

    public function __construct()
    {
        $this->registerModel = new RegisterModel();
    }

    private function sanitizeInputs(): array
    {
        return [
            'first_name' => filter_var(trim($_POST['first_name']), FILTER_SANITIZE_SPECIAL_CHARS),
            'last_name' => filter_var(trim($_POST['last_name']), FILTER_SANITIZE_SPECIAL_CHARS),
            'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
        ];
    }

    private function validateInputs(array $userInputs): void
    {

        self::$errors = [];

        if (empty($userInputs['first_name'])) {
            self::$errors[] = 'First name should not be empty.';
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $userInputs['first_name'])) {
            self::$errors[] = 'First name should only contain letters and spaces.';
        }

        if (empty($userInputs['last_name'])) {
            self::$errors[] = 'Last name should not be empty.';
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $userInputs['last_name'])) {
            self::$errors[] = 'Last name should only contain letters and spaces.';
        }

        if (empty($userInputs['email'])) {
            self::$errors[] = 'Email should not be empty.';
        }

        if (!filter_var($userInputs['email'], FILTER_VALIDATE_EMAIL)) {
            self::$errors[] = 'Invalid email format.';
        }

        if ($this->registerModel->getEmail($userInputs['email'])) {
            self::$errors[] = 'Email already exists.';
        }

        if (empty($userInputs['password'])) {
            self::$errors[] = 'Password should not be empty.';
        }

        if (strlen($userInputs['password']) < self::PASSWORD_LENGTH) {
            self::$errors[] = 'Password must be at least ' . self::PASSWORD_LENGTH . ' characters.';
        }

        if (empty($userInputs['confirm_password'])) {
            self::$errors[] = 'Confirm password should not be empty.';
        }

        if ($userInputs['password'] != $userInputs['confirm_password']) {
            self::$errors[] = 'Password does not match.';
        }
    }

    private function prepareResponse(array $userInputs): string
    {
        if (empty(self::$errors)) {
            $this->registerModel->insertUserToDb($userInputs);
            unset($_SESSION['user_inputs']);
            return 'Registration successful!';
        }

        $_SESSION['user_inputs'] = $userInputs;
        return self::$errors[0];
    }

    public function register()
    {
        $userInputs = $this->sanitizeInputs();
        $this->validateInputs($userInputs);

        $response = $this->prepareResponse($userInputs);
        echo $response;
        exit();
    }
}

$init = new RegisterController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $init->register();
} else {
    return;
}
