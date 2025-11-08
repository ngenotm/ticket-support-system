<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Client Login - Ticket Support System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
            padding: 1.5rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .login-title {
            font-weight: 600;
            text-align: center;
            font-size: 1.4rem;
            color: #111827;
        }

        .login-subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 1.8rem;
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
            transition: all 0.2s ease;
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

            <h2 class="login-title">Client Login</h2>
            <p class="login-subtitle">Access your support dashboard</p>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('client.login.submit') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="you@example.com" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter your password" required>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100 mt-2">Sign In</button>

                {{-- Optional Forgot Password --}}
                {{-- <div class="footer-link">
                    <a href="#">Forgot your password?</a>
                </div> --}}
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
