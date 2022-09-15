<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * @return View
     */
    public function showLogin()
    {
        return view('login.login_form');
    }

    /** 
     * @param App\Http\Requests\LoginFormRequest $request
     * 
     */
    public function login(LoginFormRequest $request)
    {
        $input = $request->only('email', 'password');

        $user = $this->user->getUserByEmail($input['email']);

        if (!is_null($user)) {
            if ($this->user->isAccountLocked($user)) {
                return back()->withErrors(['login_error' => 'アカウントがロックされています。']);
            }
            if (Auth::attempt($input)) {
                $request->session()->regenerate();
                $this->user->resetErrorCount($user);
                
                return redirect('home')->with('login_success', 'ログインが成功しました！');
            }

            $user->error_count = $this->user->countError($user->error_count);

            if ($this->user->lockAccount($user)) {
                return back()->withErrors([
                    'login_error' => 'アカウントがロックされました。しばらくしてから再度ログインしてください。',
                ]);
            }
            $user->save();
        }
        
        return back()->withErrors([
            'login_error' => 'メールアドレスかパスワードが間違っています。',
        ]);

    }

    /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        // セッション再生成（2重ログイン防止）
        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('logout', 'ログアウトしました。');
    }
}
