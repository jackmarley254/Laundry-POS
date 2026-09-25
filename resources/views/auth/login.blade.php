<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - LaundryPOS</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    >

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #212529, #0d6efd);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            font-size: 50px;
            color: #0d6efd;
        }

        .logo h2 {
            margin-top: 10px;
            font-weight: 700;
        }

        .form-control {
            padding: 12px;
        }

        .btn-login {
            padding: 12px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="logo">

        <i class="bi bi-droplet-half logo-icon"></i>

        <h2>LaundryPOS</h2>

        <p class="text-muted mb-0">
            Sign in to your account
        </p>

    </div>


    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form method="POST" action="{{ route('login.process') }}">

        @csrf


        <div class="mb-3">

            <label for="email" class="form-label">
                Email Address
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>

                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required
                    autofocus
                >

            </div>

        </div>


        <div class="mb-3">

            <label for="password" class="form-label">
                Password
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>

                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

            </div>

        </div>


        <div class="form-check mb-4">

            <input
                class="form-check-input"
                type="checkbox"
                name="remember"
                id="remember"
                value="1"
            >

            <label class="form-check-label" for="remember">
                Remember me
            </label>

        </div>


        <button
            type="submit"
            class="btn btn-primary btn-login w-100"
        >

            <i class="bi bi-box-arrow-in-right"></i>

            Login

        </button>

    </form>

</div>

</body>

</html>