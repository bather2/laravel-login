<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locked_flag',
        'error_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * Emailがマッチしたユーザを返す
     * @param object $email
     * @return string
     */
    public function getUserByEmail($email)
    {
        return User::where('email', '=', $email)->first();
    }

    /**
     * アカウントがロックされているか
     * @param object $user
     * @return bool
     */
    public function isAccountLocked($user)
    {
        if ($user->locked_flag === 1) {
            return true;
        }
        return false;
    }

    /**
     *  エラーカウントをリセット
     * @param object $user
     */
    public function resetErrorCount($user)
    {
        if ($user->error_count > 0) {
            $user->error_count = 0;
            $user->save();
        }
    }

    /**
     * ログイン失敗したらエラーカウントを1増やす
     * @param $error_count
     * @return int
     */
    public function countError($error_count)
    {
        return $error_count += 1;
    }

    /**
     * エラーカウントが6以上でアカウントロック
     * @param $user
     * @return 
     */
    public function lockAccount($user)
    {
        if ($user->error_count > 5) {
            $user->locked_flag = 1;
            return $user->save();
        }
        return false;
    }
}
