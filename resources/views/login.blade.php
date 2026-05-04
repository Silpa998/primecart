<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <title>Login & Register</title>
    <style>
        :root {
            --primary-color: #4EA685;
            --secondary-color: #57B894;
            --black: #000000;
            --white: #ffffff;
            --gray: #efefef;
            --gray-2: #757575;
        }

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100vh;
            overflow: hidden;
            background-color: var(--gray);
        }

        .container {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            height: 100vh;
        }

        .col {
            width: 50%;
        }

        .align-items-center {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .form-wrapper {
            width: 100%;
            max-width: 28rem;
            transition: .5s ease-in-out;
        }

        .form {
            padding: 2rem;
            background-color: var(--white);
            border-radius: 1.5rem;
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            transform: scale(0);
            transition: .5s ease-in-out;
            transition-delay: .5s;
        }

        /* Logic for showing/hiding forms */
        .container.sign-in .sign-in .form,
        .container.sign-up .sign-up .form {
            transform: scale(1);
        }

        .input-group {
            position: relative;
            width: 100%;
            margin: 1rem 0;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            font-size: 1.4rem;
            color: var(--gray-2);
        }

        .input-group input {
            width: 100%;
            padding: 1rem 3rem;
            font-size: 1rem;
            background-color: var(--gray);
            border-radius: .5rem;
            border: 2px solid transparent;
            outline: none;
            transition: .3s ease;
        }

        .input-group input:focus {
            border: 2px solid var(--primary-color);
        }

        button {
            cursor: pointer;
            width: 100%;
            padding: .8rem 0;
            border-radius: .5rem;
            border: none;
            background-color: var(--primary-color);
            color: var(--white);
            font-size: 1.2rem;
            font-weight: 600;
            transition: .3s ease;
        }

        button:hover {
            background-color: var(--secondary-color);
        }

        .form p {
            margin: 1rem 0;
            font-size: .9rem;
        }

        .pointer {
            cursor: pointer;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Background Animation */
        .container::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            height: 100vh;
            width: 300vw;
            transform: translate(35%, 0);
            background-image: linear-gradient(-45deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            transition: 1.5s ease-in-out;
            z-index: 6;
            border-bottom-right-radius: max(50vw, 50vh);
            border-top-left-radius: max(50vw, 50vh);
        }

        .container.sign-in::before { transform: translate(0, 0); right: 50%; }
        .container.sign-up::before { transform: translate(100%, 0); right: 50%; }

        .content-row {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 7;
            width: 100%;
        }

        .text {
            color: var(--white);
            transition: 1s ease-in-out;
        }

        .text h2 {
            font-size: 3.5rem;
            font-weight: 800;
            margin: 1rem 0;
        }

        .text.sign-in { transform: translateX(-250%); }
        .container.sign-in .text.sign-in { transform: translateX(0); }

        .text.sign-up { transform: translateX(250%); }
        .container.sign-up .text.sign-up { transform: translateX(0); }

        @media only screen and (max-width: 768px) {
            .col { width: 100%; }
            .container::before { display: none; }
            .row { align-items: flex-end; }
            .content-row { display: none; }
            .form { border-radius: 2rem 2rem 0 0; }
        }
        .text-danger {
            color: #ff4d4d;
            font-size: 0.75rem;
            display: block;
            margin-top: -10px; 
            margin-bottom: 10px;
            text-align: left;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div id="container" class="container">
        <div class="row">
            <div class="col align-items-center flex-col sign-up">
                <div class="form-wrapper align-items-center">
                    <form action=" {{ route('register') }}" method="POST" class="form sign-up">                      
                        @csrf
                        <h2>Create Account</h2>
                        
                        {{-- @if ($errors->any())
                            <p style="color: #ff4d4d; font-size: 0.8rem;">{{ $errors->first() }}</p>
                        @endif --}}

                        @if (session('success'))
                            <p style="color: #4EA685; font-size: 0.8rem;">{{ session('success') }}</p>
                        @endif

                        <div class="input-group">
                            <i class='bx bxs-user'></i>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Username">
                        </div>   
                            @error('name')
                            <span class="text-danger">*{{ $message }}</span>
                            @enderror
                        
                        <div class="input-group">
                            <i class='bx bx-mail-send'></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>  
                           @error('email')
                           <span class="text-danger">*{{ $message }}</span>
                           @enderror
                        
                        <div class="input-group">
                            <i class='bx bxs-lock-alt'></i>
                            <input type="password" name="password" placeholder="Password">
                        </div>
                            @error('password')
                            <span class="text-danger">*{{ $message }}</span>
                            @enderror                         
                        
                        <div class="input-group">
                            <i class='bx bxs-lock-alt'></i>
                            <input type="password" name="password_confirmation" placeholder="Confirm password">
                        </div>    
                        @error('password')
                            <span class="text-danger">*Password check failed.</span>
                        @enderror
                        
                        <button type="submit">Sign up</button>
                        <p>
                            <span>Already have an account?</span>
                            <b onclick="toggle()" class="pointer">Sign in here</b>
                        </p>
                    </form>
                </div>
            </div>

            <div class="col align-items-center flex-col sign-in">
                <div class="form-wrapper align-items-center">
                    <form action="{{ route('login') }}" method="POST" class="form sign-in">
                        @csrf


                        @if (session('info'))
                            <div style="color: #31708f; background-color: #d9edf7; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 0.85rem; border: 1px solid #bce8f1;">
                                <i class='bx bx-info-circle'></i> {{ session('info') }}
                            </div>
                        @endif




                        <h2>Welcome Back</h2>
                        
                        {{-- @if ($errors->any() && !$errors->has('name'))
                            <div class="text-danger" style="text-align: center;">
                                {{ $errors->first() }}
                            </div>
                        @endif --}}

                        <div class="input-group">
                            <i class='bx bxs-user'></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                        </div>
                        @error('email')
                            <span class="text-danger">*{{ $message }}</span>
                        @enderror

                        <div class="input-group">
                            <i class='bx bxs-lock-alt'></i>
                            <input type="password" name="password" placeholder="Password">
                        </div>
                        @error('password')
                           <span class="text-danger">*{{ $message }}</span>
                        @enderror

                        <button type="submit">Sign in</button>
                        <p>
                            <span>Don't have an account?</span>
                            <b onclick="toggle()" class="pointer">Sign up here</b>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div class="row content-row">
            <div class="col align-items-center flex-col">
                <div class="text sign-in">
                    <h2>Welcome</h2>
                </div>
            </div>
            <div class="col align-items-center flex-col">
                <div class="text sign-up">
                    <h2>Join Us</h2>
                </div>
            </div>
        </div>
    </div>

    <script>
    let container = document.getElementById('container');

    const toggle = () => {
        container.classList.toggle('sign-in');
        container.classList.toggle('sign-up');
    };

    // Registration errors undenkil Sign-up form show cheyyan
    @if($errors->has('name') || $errors->has('email') && old('name'))
        container.classList.add('sign-up');
    @else
        // Default aayi sign-in show cheyyikkuka
        container.classList.add('sign-in');
    @endif
</script>
</body>
</html>