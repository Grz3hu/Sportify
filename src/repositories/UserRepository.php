<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users u JOIN users_info ui ON u.user_id = ui.user_info_id WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['phone_number'],
            $user['profile_picture']
        );
    }

    public function getAllUsers(){
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users u JOIN users_info ui ON u.user_id = ui.user_info_id
        ');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$users) {
            return null;
        }

        $result = [];
        foreach ($users as $user) {
            $result[] = new User(
                $user['email'],
                $user['password'],
                $user['name'],
                $user['phone_number'],
                $user['profile_picture']
            );
        }

        return $result;
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, password)
            VALUES (?, ?)
        ');

        $stmt->execute([
            $user->getEmail(),
            $user->getPassword()
        ]);

        $userId = $this->getUserIdByEmail($user->getEmail());

        $stmt = $this->database->connect()->prepare('
            INSERT INTO users_info (user_info_id, name, phone_number, profile_picture)
            VALUES (?, ?, ?, ?)
        ');

        $stmt->execute([
            $userId,
            $user->getName(),
            $user->getPhoneNumber(),
            $user->getProfilePic()
        ]);
    }

    public function getUserDetailsId(User $user): int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users_info WHERE name = :name AND phone_number = :phone_number
        ');
        $name = $user->getName();
        $phoneNumber = $user->getPhoneNumber();
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['user_info_id'];
    }
    public function getUserIdByEmail(string $email): ?int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT user_id FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return $data['user_id'];
    }

    public function isUserAdmin(string $email): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM admins WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return false;
        }
        return true;
    }

    public function userLogin(int $userId)
    {
        $current_date = new DateTime();
        $_SESSION['created_at']= $current_date->format('Y-m-d H:i:s');
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users_sessions (session_id, user_id, created_at, destoryed_at)
            VALUES (DEFAULT, ?, ?, null);
        ');
        $stmt->execute([
            $userId,
            $_SESSION['created_at']
        ]);
    }

    public function userLogout(int $userId){
        $stmt = $this->database->connect()->prepare('
            UPDATE users_sessions
            SET destoryed_at = now()
            WHERE user_id = :user_id
              AND created_at = :created_at
        ');
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':created_at', $_SESSION['created_at'], PDO::PARAM_STR);
        $stmt->execute();
    }
}
