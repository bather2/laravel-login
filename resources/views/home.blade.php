<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ホーム画面</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <div class="container">
    <div class="mt-5">
      @if (session('login_success'))
        <div class="bg-green-400 text-center py-4 lg:px-4">
          <div class="p-2 bg-green-600 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
            <span class="font-semibold mr-2 text-left flex-auto">
              {{ session('login_success') }}
            </span>
          </div>
        </div>
      @endif
      <h3>プロフィール</h3>
      <ul>
        <li>名前: {{ Auth::user()->name }}</li>
        <li>メールアドレス: {{ Auth::user()->email }}</li>
      </ul>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" value="ログアウト">
      </form>
    </div>
  </div>
</body>
</html>