<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ログインフォーム</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
      <div class="mb-4">
        @if ($errors->any())
        <div class="alert text-red-600">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
        </div>
        @endif
        <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
          Email address
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="username" name="email" type="text" placeholder="Email address">
      </div>
      <div class="mb-6">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-grey-700 mb-3" id="password" name="password" type="password" placeholder="Password">
      </div>
      <div class="flex items-center justify-between">
        <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit" value="ログイン">
      </div>
    </div>
  </form>
</body>
</html>