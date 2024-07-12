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
      Change Password
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

    <style>
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .form-group {
            position: relative;
        }
        .form-control {
            padding-right: 40px;
        }
    </style>
    
</head>

<body>
    
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button class="btn-close text-dark" type="button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="btn-close text-dark" type="button" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>    
                </div>
            @endif
            
            <div class="col-md-4">
                <div class="text-center mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" width="80" height="auto">
                    <h3 class="mt-1 custom-title">Change Your Password</h3>
                    <p class="subtitle">Ensure your account security by updating your password regularly</p>
                </div>
                <div class="card shadow">
                    <div class="card-header text-center"><h4>Change Password</h4></div>
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
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="form-group">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current-password">
                                <i class="fa fa-eye eye-icon" id="toggleCurrentPassword" style="cursor: pointer; top: 51px; right: 15px;"></i>
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="form-label">New Password</label>
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password">
                                <i class="fa fa-eye eye-icon" id="toggleNewPassword" style="cursor: pointer; top: 51px; right: 15px;"></i>
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation" class="form-label">Confirm Password</label>
                                <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required autocomplete="new-password">
                                <i class="fa fa-eye eye-icon" id="toggleConfirmPassword" style="cursor: pointer; top: 51px; right: 15px;"></i>
                            </div>    
                            <div class="row">
                                <div class="col-6">
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard.index') }}" class="btn btn-secondary w-100">Cancel</a>
                                    @elseif(Auth::user()->role === 'member')
                                        <a href="{{ route('member.landingpage.index') }}" class="btn btn-secondary w-100">Cancel</a>
                                    @else
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary w-100">Cancel</a>
                                    @endif
                                </div>                                
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100">Change Password</button>
                                </div>
                            </div>                            
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('current_password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    
        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('new_password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('new_password_confirmation');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>

</html>
