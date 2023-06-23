@extends('arvi.layouts.main')

@section('content')

<body class="theme-payment">
<div class="container-fluid d-flex justify-content-center align-items-center h-100 page-xs">
    <div class="row d-flex align-items-center p-4">
        <div class="card no-border shadow">
            <div class="card-body border-0 py-4">
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <h2 class="text-success">Thank you.</h2>
                        <div>Your order successfully been placed.</div>
                    </div>
                    <div>
                        <h1 class="m-0">$ {{ $ord->total_gross_price }}</h1>
                        <div class="text-end text-uppercase text-success">Success</div>
                    </div>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">Pay using</div>
                            <div class="col-12 col-sm-6 col-md-6 text-end">{{$payment}}</div>
                        </div>
                    </div>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">Transaction ID.</div>
                            <div class="col-12 col-sm-6 col-md-6 text-end">{{$ord->arvi_session_id}}</div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">A confirmation email has been sent to you with the transaction details.</div>
                <div class="mt-3 small">
                    Please check your junk/spam email folder just incase the confirmation email got delivered there instead of your inbox.
                </div>
                <div class="mt-4">
                    oobe.ai
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
