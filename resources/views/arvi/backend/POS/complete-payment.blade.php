@if ($channel_code == 'DANA')
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
            <title>OOBE - Dashboard</title>
            <meta name="description" content="Oobe Bussiness Owners Platform" />
            <!-- Favicon -->
            <link rel="icon" type="image/x-icon" href="/arvi/backend-assets/img/fav/favicon.ico" />
            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
            <link rel="stylesheet" href="/arvi/backend-assets/vendor/fonts/boxicons.css" />
            <link rel="stylesheet" href="/arvi/backend-assets/vendor/css/core.css" class="template-customizer-core-css" />
            <link rel="stylesheet" href="/arvi/backend-assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
            <link rel="stylesheet" href="/arvi/backend-assets/css/styles.css" />
            <link rel="stylesheet" href="/arvi/backend-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
            <link rel="stylesheet" href="/arvi/backend-assets/vendor/css/pages/page-auth.css" />
            
            <script src="/arvi/backend-assets/vendor/js/helpers.js"></script>
            <script src="/arvi/backend-assets/js/config.js"></script>
        </head>
        
        <body>
        
@endif

<div class="modal-body center p-3">
                         
    <div class="row justify-content-center mt-5">
        @if ($channel_code == 'CASH')
            <div class="col-12 col-md-8 text-center">
                <div class="mb-2">
                    Paid {{$data->payment->currency}} 
                    {{number_format($custCash)}}
                </div>
            </div>
            <div class="col-12 col-md-8 text-center">
                <h1 class="fw-bold">
                    {{$data->payment->currency}} 
                    {{number_format($change)}} Change 
                    <span class="h3">(Cash)</span>
                </h1>
            </div>
        @else
        <div class="col-12 col-md-8 text-center">
            <div class="mb-2">
                Paid {{$order->currency}} 
                {{number_format($order->total_gross_price)}}
            </div>
        </div>
        <div class="col-12 col-md-8 text-center">
            <h1 class="fw-bold">
                Payment Success
                <span class="h3">({{$order->payment_methods}})</span>
            </h1>
        </div>
        @endif
        <div class="col-12 col-md-8 text-center">
            <h5 class="fw-noraml">Transaction ID : #OOBE-{{$orderId}}</h5>
        </div>
        <div class="col-12 col-md-8 text-center mb-5">
            <img src="/arvi/backend-assets/img/icons/checked.png">
        </div>
        <div class="col-12"></div>
        <div class="col-12 col-md-8 text-center">
            <form id="form-email" method="post">
                @csrf
                <div class="">
                    <div class="input-group">
                        <input type="hidden" name="id" value="{{$orderId}}">
                        <input type="email" name="email" class="form-control" 
                        placeholder="Email receipt" required>
                        <button class="btn btn-primary" id="send-email">Send</button>
                    </div>
                    <div id="emailHelp" 
                    class="form-text text-start text-warning fw-bold d-none">
                        Please wait...
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 mb-5"></div>
        <div class="col-6 col-md-4">
            <div class="d-grid gap-2 mb-3">
                <a href="javascript: print();" class="btn btn-outline-secondary">
                    <i class='bx bx-printer' ></i> Print
                </a>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="d-grid gap-2 mb-3">
                <a href="javascript: void(0);" 
                class="btn btn-outline-primary" id="new-sale">
                <i class='bx bx-basket'></i> New Sale
                </a>
            </div>
        </div>
    </div>

</div>


@if ($channel_code == 'DANA')
        </body>
    </html>
    <script type="text/javascript" src="/arvi/backend-assets/vendor/libs/jquery/jquery.js"></script>
    <script>
        $('#new-sale').on('click',function () {
            window.location.href = "{{route('main-dashboard',['companyCode'=>$companyCode])}}";
        })
    </script>
@else
    <script>
        $('#new-sale').on('click',function () {
            $('#modalDone').find('.modal-content').html('<h1>Loading...</h1>');
            $('#modalDone').modal('toggle'); 
            $('#pos-button').trigger('click'); 
        })
    </script>

@endif

<script>
    $( document ).ready(function() {
        sessionStorage.removeItem('cart-pos-cashier');
    });

    // new order
    $('#new-sale').on('click',function () {
        $('#modalDone').modal('toggle'); 
        $('#pos-button').trigger('click'); 
    })

    // send email
    $('#form-email').on('submit',function () {
        event.preventDefault();
        $('#send-email').prop('disabled', true);
        $('#emailHelp').removeClass('d-none');
        let email = $('input[name="email"]').val();
        if (email != '') {
            $.ajax({
                type: 'POST',
                url: "{{ route('pos-set-email',['companyCode' => $companyCode]) }}",
                data: $(this).serialize(),
                success: function (data) {
                    $('#emailHelp').text('Success send receipt.');
                    $('#emailHelp').removeClass('text-warning');
                    $('#emailHelp').addClass('text-primary');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });
</script>