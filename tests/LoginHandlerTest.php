<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ .'/../classes/CRUD.php';
require_once __DIR__ . '/../classes/LoginHandler.php';

class LoginHandlerTest extends TestCase
{
    public function testValidateLogin()
    {
        $crudMock = $this->createMock(CRUD::class); // Mocking the Crud class
        $loginHandler = new LoginHandler($crudMock);

        // Test for missing email
        $errors = $loginHandler->validateLogin('', 'password123');
        $this->assertContains('Email is required!', $errors);

        // Test for missing password
        $errors = $loginHandler->validateLogin('test@example.com', '');
        $this->assertContains('Password is required!', $errors);

        // Test for valid email and password
        $errors = $loginHandler->validateLogin('test@example.com', 'password123');
        $this->assertEmpty($errors); // No errors
    }

    public function testAuthenticateUserSuccess()
    {
        $crudMock = $this->createMock(CRUD::class);
        $crudMock->method('read')->willReturn([['id' => 1, 'email' => 'test@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'name' => 'John', 'surname' => 'Doe', 'role' => 'user']]);
        
        $loginHandler = new LoginHandler($crudMock);
        $user = $loginHandler->authenticateUser('test@example.com', 'password123');
        
        $this->assertNotNull($user); // Should return a user object
        $this->assertEquals('test@example.com', $user['email']);
    }

    public function testAuthenticateUserFailure()
    {
        $crudMock = $this->createMock(CRUD::class);
        $crudMock->method('read')->willReturn([]);
        
        $loginHandler = new LoginHandler($crudMock);
        $user = $loginHandler->authenticateUser('test@example.com', 'wrongpassword');
        
        $this->assertNull($user); // Should return null for invalid credentials
    }
}
?>