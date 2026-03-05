<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Bootstrap Toasts Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <!-- Success Toast -->
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body" id="successMessage"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>

        <!-- Error Toast -->
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body" id="errorMessage"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header text-center bg-success text-white">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/login-user') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Login</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        New user? <a href="{{ url('/register') }}">Register here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Show Toasts based on Session Messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successToast = new bootstrap.Toast(document.getElementById('successToast'), {
                delay: 5000
            });
            const errorToast = new bootstrap.Toast(document.getElementById('errorToast'), {
                delay: 5000
            });

            @if(Session::has('success'))
                document.getElementById('successMessage').textContent = "{{ Session::get('success') }}";
                successToast.show();
            @endif

            @if(Session::has('error'))
                document.getElementById('errorMessage').textContent = "{{ Session::get('error') }}";
                errorToast.show();
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    document.getElementById('errorMessage').textContent = "{{ $error }}";
                    errorToast.show();
                @endforeach
            @endif
        });
    </script>

</body>

</html>
