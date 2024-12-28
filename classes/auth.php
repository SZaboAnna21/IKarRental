<?php
require_once "user.php";
class Auth
{
    private $userRepository;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } 
        $this->userRepository = new UserRepository();
    }
    public function register($user)
    {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        return $this->userRepository->add((object) $user);
    }
    public function user_exists($username)
    {
        $users = $this->userRepository->findMany(function ($user) use ($username) {
            return $user->username === $username; 
        });
        return count($users) >= 1;
    }
    public function login($user)
    {
        $_SESSION["user"] = $user['username'];
    }
    public function check_credentials($username, $password)
    {
        $users = $this->userRepository->findMany(function ($user) use ($username) {
            return $user->username === $username;
        });
        if (count($users) === 1) {
            $user = (array) array_values($users)[0];
            return password_verify($password, $user->password) ? $user : false;
        }
        return false;
    }
    public function is_authenticated()
    {
        return isset($_SESSION["user"]);
    }
    public function logout()
    {
        unset($_SESSION["user"]);
    }
}