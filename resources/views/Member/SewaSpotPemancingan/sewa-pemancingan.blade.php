<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/logo.png">
    <title>SIMPI | Sewa Spot Pemancingan</title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />

    <!-- Nepcha Analytics -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/css/bs-stepper.min.css" rel="stylesheet">

    <style>
        .spot {
            width: 50px;
            height: 50px;
            margin: 10px;
            display: inline-block;
            border: 1px solid #000;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
        }
        .reserved {
            background-color: red;
            cursor: not-allowed;
        }
        .selected {
            background-color: green;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        @include('Member.Layouts.navbar')

        <div class="container-fluid py-2">
            <div class="container">
                <h1>Fishing Spot Reservation</h1>
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('member.spots.reserve') }}">
                    @csrf
                    <div id="spots">
                        @foreach($spots as $spot)
                            <div class="spot {{ $spot->is_reserved ? 'reserved' : '' }}" data-id="{{ $spot->id }}">
                                {{ $spot->name }}
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="spots" id="selected-spots">
                    <button type="submit" class="btn btn-primary">Reserve</button>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>
            $(document).ready(function(){
                var selectedSpots = [];
        
                $('.spot').click(function() {
                    if ($(this).hasClass('reserved')) {
                        return;
                    }
        
                    var spotId = $(this).data('id');
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                        selectedSpots = selectedSpots.filter(function(id) {
                            return id !== spotId;
                        });
                    } else {
                        $(this).addClass('selected');
                        selectedSpots.push(spotId);
                    }
        
                    $('#selected-spots').val(selectedSpots.join(','));
                });
            });
        </script>

        <!-- Bootstrap JS and Other Dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/js/bs-stepper.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    </main>
</body>

</html>
