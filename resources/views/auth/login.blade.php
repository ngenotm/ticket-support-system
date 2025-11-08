<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ticket Support System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background-color: #f9fafb;
            font-family: "Inter", "Segoe UI", sans-serif;
            color: #1f2937;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 2.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .login-title {
            font-weight: 600;
            text-align: center;
            font-size: 1.5rem;
            color: #111827;
        }

        .login-subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        label {
            font-weight: 500;
            font-size: 0.9rem;
            color: #374151;
        }

        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0.6rem 0.75rem;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
        }

        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
            border-radius: 6px;
            font-weight: 500;
            padding: 0.6rem;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }

        .role-radio label {
            font-weight: 400;
            margin-right: 1rem;
            color: #374151;
        }

        .alert {
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .footer-link {
            text-align: center;
            margin-top: 1rem;
        }

        .footer-link a {
            text-decoration: none;
            color: #2563eb;
            font-size: 0.875rem;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">

            <h2 class="login-title mb-1">Ticket Support System</h2>
            <p class="login-subtitle">Sign in to your account</p>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com"
                        required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter your password" required>
                </div>

                <!-- Role -->
                <div class="mb-3 role-radio">
                    <label class="form-label d-block">Role</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="admin" value="admin" required>
                        <label class="form-check-label" for="admin">Admin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="role" id="supervisor" value="supervisor">
                        <label class="form-check-label" for="supervisor">Staff</label>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100 mt-2">Sign In</button>

                <!-- Forgot Password -->
                {{-- <div class="footer-link">
                    <a href="#">Forgot your password?</a>
                </div> --}}
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
