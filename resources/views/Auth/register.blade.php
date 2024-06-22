<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png"> --}}
    {{-- <link rel="icon" type="image/png" href="../assets/img/favicon.png"> --}}
    {{-- <link rel="icon" type="image/png" sizes="32x32" href="path/to/new-favicon-32x32.png"> --}}
    <link rel="icon" type="image/png" sizes="16x16" href="../images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>
      Register
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  
    <link href="https://cdn.jsdelivr.net/npm/nucleo/css/nucleo.css" rel="stylesheet">
  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>

<body>
    
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="col-md-6">
                <div class="text-center mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" width="80" height="auto">
                    <h3 class="mt-1 custom-title">Join SIMPI Community</h3>
                    <p class="subtitle">Create an account to unlock all features</p>    
                </div>
                <div class="card shadow">
                    <div class="card-header text-center"><h4>Register</h4></div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="nama" class="form-label">Name</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="your name" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telepon" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="08xxxxxxxxx" maxlength="13" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary w-100">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a>
                        Already have an account?
                        <a href="{{ route('login') }}"> Login</a>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>
