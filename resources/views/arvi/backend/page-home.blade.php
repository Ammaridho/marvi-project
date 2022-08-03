{{-- {{ dd($percentase) }} --}}
<div class="row">
    <div class="col-lg-6 mb-4 order-0">
    
    <!-- Hello -->
    <div class="card h-100">
        <div class="d-flex align-items-end row">
        <div class="col-sm-7">
            <div class="card-body">
            <h5 class="card-title text-primary">Congratulations Bootstrap! 🎉</h5>
            <p class="mb-4">
                You have <span class="fw-bold">{{ $countOrderToday }}</span> more orders today.
            </p>

            <a href="javascript:void(0);" id="view-order" class="btn btn-sm btn-outline-primary">View orders</a>
            </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
            <div class="pb-0 px-0">
            <img src="/arvi/backend-assets/img/illustrations/man-with-laptop-light.png" height="130" />
            </div>
        </div>
        </div>
    </div>
    <!-- //Hello -->

    </div>
    <div class="col-lg-2 mb-4 order-0">

    <!-- Order plan -->
    <div class="card h-100">
        <div class="card-body">
        <span class="fw-semibold d-block mb-1">Sales Today</span>
        <h3 class="card-title mb-2">{{ $currency }}{{ $incomeToday }}</h3>
        <small class="fw-semibold">

            @if($percentase > 0)
                <div class="text-success"><i class="bx bx-up-arrow-alt"></i> {{ round($percentase, 2) }}%</div>
            @elseif($percentase = 0)
                <div class="text-warning"><i class="bx bx-mid-arrow-alt"></i> {{ round($percentase, 2) }}%</div>
            @else
                <div class="text-danger"><i class="bx bx-down-arrow-alt"></i> {{ round($percentase, 2) }}%</div>
            @endif

            <div>from yesterday</div>
        </small>
        </div>
    </div>
    <!-- //Order plan -->

    </div>
    <div class="col-lg-2 mb-4 order-0">

    <!-- Production plan -->
    <div class="card h-100 d-none">
        <div class="card-body">
        <span class="fw-semibold d-block mb-1">Production Plans</span>
        <h3 class="card-title mb-2">342</h3>
        <small class="fw-semibold">
            <div class="text-success"><i class="bx bx-up-arrow-alt"></i> +32%</div>
            <div>from yesterday</div>
        </small>
        </div>
    </div>
    <!-- //Production plan -->

    </div>
    <div class="col-lg-2 mb-4 order-0">

    <!-- Production plan -->
    <div class="card h-100 d-none">
        <div class="card-body">
        <span class="fw-semibold d-block mb-1">Delivery Drop Point</span>
        <h3 class="card-title mb-2">143</h3>
        <small class="fw-semibold">
            <div class="text-warning"><i class="bx bx-down-arrow-alt"></i> -1%</div>
            <div>from yesterday</div>
        </small>
        </div>
    </div>
    <!-- //Production plan -->

    </div>
</div>
<script>
    $(document).ready(function () {
        $('#view-order').on('click',function () {
            $('#order-button').trigger("click");
        })
    })
</script>