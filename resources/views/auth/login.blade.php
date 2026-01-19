<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Project-PU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SB Admin CSS -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">

<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header text-center">
                                <h3 class="font-weight-light my-4">
                                    Login Project-PU
                                </h3>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login.process') }}">
                                    @csrf

                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                               type="email"
                                               name="email"
                                               placeholder="name@example.com"
                                               required>
                                        <label>Email address</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control"
                                               type="password"
                                               name="password"
                                               placeholder="Password"
                                               required>
                                        <label>Password</label>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                        <button class="btn btn-primary" type="submit">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="card-footer text-center py-3">
                                <small class="text-muted">
                                    Project-PU © {{ date('Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
