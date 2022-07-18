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

            <div class="card no-border shadow">
                <div class="card-body border-0 py-4">
                    <div class="mb-4">
                        <img src="/arvi/assets/img/icon-store.png" class="w-25" />
                    </div>
                    <h2>Sorry</h2>
                    <h4>This shop is currently closed.<br />Check again later.</h4>

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