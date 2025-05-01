<?php
// LoginHandler.php
class LoginHandler
{
    private $crud;

    // Constructor expects a Crud object
    public function __construct($crud)
    {
        $this->crud = $crud;
    }

    // Validate the input fields (email and password)
    public function validateLogin($email, $password)
    {
        $errors = [];

        if (empty($email)) {
            $errors[] = 'Email is required!';
        }

        if (empty($password)) {
            $errors[] = 'Password is required!';
        }

        return $errors;
    }

    // Authenticate user with email and password
    public function authenticateUser($email, $password)
    {
        // Find the user by email
        $user = $this->crud->read('users', ['column' => 'email', 'value' => $email], 1);

        if (count($user)) {
            $user = $user[0];
            if (password_verify($password, $user['password'])) {
                return $user; // Return user data if authenticated
            }
        }
        return null; // Return null if authentication fails
    }
}
?>