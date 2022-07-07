<?php

namespace Constellation\Authentication;

use Celestial\Models\User;
use Ramsey\Uuid\Uuid;

class Auth
{
    public static function isSignedIn()
    {
        return isset($_SESSION["user"]);
    }

    public static function user()
    {
        $user_id = intval($_SESSION["user"]);
        return self::isSignedIn() ? User::find([$user_id]) : null;
    }

    public static function checkPassword(User $user, string $password)
    {
        return password_verify($password, $user->password);
    }

    public static function hashPassword(string $password)
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }

    public static function signIn(User $user): void
    {
        $_SESSION["user"] = $user->id;
    }

    public static function signOut(): void
    {
        if (!empty($_SESSION)) {
            $_SESSION = [];
            session_destroy();
        }
    }

    public static function register(array $attributes)
    {
        $attributes["uuid"] = Uuid::uuid4()->toString();
        $attributes["password"] = self::hashPassword($attributes["password"]);
        return User::create($attributes);
    }
}
