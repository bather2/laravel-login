<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
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

        if (Auth::attempt($input)) {
            $request->session()->regenerate();

            return redirect('home')->with('login_success', 'ログインが成功しました！');
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
