<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>CodePen - Glassmorphism Login</title>
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">

</head>
<body>
<!-- partial:index.partial.html -->
<body>
<section class="container">
    <div class="login-container">
        <div class="circle circle-one"></div>
        <div class="form-container">
            <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
            <h1 class="opacity">Giriş</h1>
            <form action="{{route('login')}}" method="POST">
                @csrf
                <input type="text" id="user_name" placeholder="Kullanıcı adı" name="user_name" />
                <input type="password" id="passowrd" name="password" placeholder="Şifre" />
                <button type="submit" class="opacity">Giriş</button>
                @if($errors->any())
                    <div style="border-radius:4px;margin-top:1rem;background-color: #E37163;color: #fff;display: flex;justify-content: center;align-items: center;padding: 13px">  {{ $errors->first()  }}</div>
                @endif
            </form>

            <div class="copy-right opacity">
                <span href="">Copyright © 2024 </span>
            </div>
        </div>
        <div class="circle circle-two"></div>
    </div>
    <div class="theme-btn-container"></div>
</section>
</body>

<script src="{{asset('assets/js/login.js')}}"></script>
</body>
</html>
