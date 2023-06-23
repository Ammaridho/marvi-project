@extends('arvi.layouts.main')

@section('content')

    <head>
      <style>
          html, body{ height:100vh; width:100vw;}
      </style>
    </head>
    <body class="theme-payment">
    
    <div class="container-fluid d-flex justify-content-center align-items-center h-100 page-xs">
        <div class="row text-center d-flex align-items-center p-4">

            <!-- Success page -->
            <div class="card no-border">
                <div class="card-body border-0 py-4">
                    <div class="mb-4">
                        <img src="/arvi/assets/img/small-check-mark.svg" type="image/svg+xml" class="w-25" />
                    </div>
                    <h2>Thank you.</h2>
                    <div>Your order successfully been placed.</div>
                    <div>A confirmation email has been sent to you with the boooking / transaction details.</div>
                    <div class="mt-3">Transaction ID.<br /> <strong>YTR98721987391-09090912-22</strong></div>
                    <div class="mt-3 small">
                        Please check your junk/spam email folder just incase the confirmation email 
                        got delivered there instead of your inbox.
                    </div>
                    <div class="p-5">
                        <a href="index.php" class="btn btn-theme-secondary col">back to shop</a>
                    </div>
                    <!-- //Success page -->

                    <div class="p-1">
                        - OOBE -
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>    
    <script>
      $(document).ready(function(){


      }); 
    </script>
  </body>

@endsection
     