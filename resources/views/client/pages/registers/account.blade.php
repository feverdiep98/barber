<link rel="stylesheet" href="{{ asset('client/css/login.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        <h2>Become a member at HairCut Barber</h2>
        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="{{ route('client.registers.saveUser')}}" method="POST">
                    @csrf
                    <h1>Create Account</h1>
                    <div class="social-container">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <span>or use your email for registration</span>
                    <input type="text" name="name" placeholder="Name" value="{{ old('name')}}"/>
                    @error('name')
                        <div class="alert-danger">{{$message}}</div>
                    @enderror
                    <input type="email" name="email" placeholder="Email" value="{{ old('email')}}" />
                    @error('email')
                        <div class="alert-danger">{{$message}}</div>
                    @enderror
                    <input type="password" name="password" placeholder="Password"  value="{{ old('password')}}"/>
                    @error('password')
                        <div class="alert-danger">{{$message}}</div>
                    @enderror
                    <button type="submit">Sign Up</button>
                </form>
            </div>
            <div class="form-container sign-in-container">
                <form action="{{ route('client.registers.signIn')}}" method="POST">
                    @csrf
                    <h1>Sign in</h1>
                    <div class="social-container">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <span>or use your account</span>
                    <input type="email" placeholder="Email" name="email"/>
                    @error('email')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="password" placeholder="Password" name="password"/>
                    <a href="#">Forgot your password?</a>
                    <button type="submit">Sign In</button>
                    @error('password')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    @if ($message = Session::get('error'))
                        <div class="alert-danger">{{ $message }}</div>
                    @endif
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <button class="ghost" id="signIn" type="submit">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal details and start journey with us</p>
                        <button class="ghost" id="signUp" type="submit">Sign Up</button>
                    </div>
                </div>
            </div>
            <script>
            const signUpButton = document.getElementById('signUp');
                const signInButton = document.getElementById('signIn');
                const container = document.getElementById('container');

                signUpButton.addEventListener('click', () => {
                    container.classList.add("right-panel-active");
                });

                signInButton.addEventListener('click', () => {
                    container.classList.remove("right-panel-active");
                });
            </script>
        </div>
</body>
</html>

