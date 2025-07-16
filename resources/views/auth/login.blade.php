<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - SIRUANG</title>
  <link rel="shortcut icon" href="{{ asset('assets/backend/img/logo.png') }}" type="image/png" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #6fb1fc, #4364f7, #3f51b5);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-box {
      background-color: #fff;
      padding: 2.5rem 2rem;
      border-radius: 16px;
      box-shadow: 0 12px 24px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
      animation: slideUp 0.7s ease-out;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(50px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-title {
      font-size: 28px;
      font-weight: 700;
      color: #333;
      text-align: center;
      margin-bottom: 0.5rem;
    }

    .login-subtitle {
      text-align: center;
      font-size: 14px;
      color: #666;
      margin-bottom: 2rem;
    }

    label {
      font-weight: 600;
      margin-bottom: 0.5rem;
      display: block;
      color: #333;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 10px;
      transition: 0.3s ease;
      font-size: 14px;
      margin-bottom: 1rem;
    }

    input:focus {
      border-color: #3f51b5;
      box-shadow: 0 0 8px rgba(63, 81, 181, 0.3);
      outline: none;
    }

    .btn-login {
      width: 100%;
      padding: 0.75rem;
      background: linear-gradient(to right, #3f51b5, #6a11cb);
      color: white;
      border: none;
      border-radius: 12px;
      font-weight: bold;
      font-size: 16px;
      transition: transform 0.2s ease, background 0.3s ease;
      cursor: pointer;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      background: linear-gradient(to right, #5f72be, #9b23ea);
    }

    .invalid-feedback {
      color: red;
      font-size: 13px;
      margin-top: -0.5rem;
      margin-bottom: 0.5rem;
    }

    @media (max-width: 500px) {
      .login-box {
        padding: 2rem 1.5rem;
        border-radius: 12px;
      }

      .login-title {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2 class="login-title">Wilujeng Sumping</h2>
    <p class="login-subtitle">Sok Login Hela, Meh Bisa Asup</p>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label for="email">Email</label>
        <input id="email" type="email"
               class="@error('email') is-invalid @enderror"
               name="email" value="{{ old('email') }}" required autofocus> 
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="password">Password</label>
        <input id="password" type="password"
               class="@error('password') is-invalid @enderror"
               name="password" required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn-login">Login</button>
    </form>
  </div>
</body>
</html>
