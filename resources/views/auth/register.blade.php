<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Event Ticketing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(16, 185, 129, 0.07) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(13, 148, 136, 0.05) 0%, transparent 55%);
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 2.5rem;
            backdrop-filter: blur(20px);
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #10b981, #0d9488);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 10px !important;
            color: #fff !important;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: rgba(16, 185, 129, 0.7) !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12) !important;
            background: rgba(255, 255, 255, 0.07) !important;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.25) !important; }

        .form-label {
            color: rgba(255,255,255,0.5);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.4rem;
        }

        .btn-register {
            background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: #fff;
            width: 100%;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            background: linear-gradient(135deg, #059669 0%, #0f766e 100%);
            color: #fff;
        }

        /* Password strength */
        .strength-bar {
            height: 3px;
            border-radius: 3px;
            background: rgba(255,255,255,0.07);
            margin-top: 6px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.3s, background-color 0.3s;
            width: 0%;
        }
    </style>
</head>
<body>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center text-bg-success border-0 rounded-3" role="alert" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body" id="successMessage"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0 rounded-3" role="alert" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body" id="errorMessage"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <div class="auth-card">
        <!-- Brand -->
        <div class="brand-icon">
            <i class="fas fa-bolt text-white fs-5"></i>
        </div>

        <h4 class="text-white fw-bold text-center mb-1" style="letter-spacing: -0.3px;">Create account</h4>
        <p class="text-center mb-4" style="color: rgba(255,255,255,0.35); font-size: 0.875rem;">Join Event Ticketing — it's free</p>

        <form action="{{ url('/register-user') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Your full name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Min. 8 characters" required oninput="updateStrength(this.value)">
                <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                <small id="strength-text" style="color: rgba(255,255,255,0.3); font-size: 0.75rem;"></small>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
            </div>

            <button type="submit" class="btn-register mb-4">Create Account</button>
        </form>

        <p class="text-center mb-0" style="font-size: 0.875rem; color: rgba(255,255,255,0.35);">
            Already have an account?
            <a href="{{ url('/login') }}" style="color: #34d399; text-decoration: none; font-weight: 600;">Sign in</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateStrength(val) {
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { pct: '0%', color: 'transparent', label: '' },
                { pct: '25%', color: '#ef4444', label: 'Weak' },
                { pct: '50%', color: '#f97316', label: 'Fair' },
                { pct: '75%', color: '#eab308', label: 'Good' },
                { pct: '100%', color: '#22c55e', label: 'Strong' },
            ];

            const lvl = levels[score] || levels[0];
            document.getElementById('strength-fill').style.width = lvl.pct;
            document.getElementById('strength-fill').style.backgroundColor = lvl.color;
            document.getElementById('strength-text').textContent = lvl.label ? `Strength: ${lvl.label}` : '';
            document.getElementById('strength-text').style.color = lvl.color;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const successToast = new bootstrap.Toast(document.getElementById('successToast'));
            const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));

            @if(Session::has('success'))
                document.getElementById('successMessage').textContent = "{{ Session::get('success') }}";
                successToast.show();
            @endif

            @if(Session::has('error'))
                document.getElementById('errorMessage').textContent = "{{ Session::get('error') }}";
                errorToast.show();
            @endif

            @if($errors->any())
                document.getElementById('errorMessage').textContent = "{{ $errors->first() }}";
                errorToast.show();
            @endif
        });
    </script>
</body>
</html>
