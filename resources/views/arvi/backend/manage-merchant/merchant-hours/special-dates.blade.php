<link rel="stylesheet" type="text/css" href="/arvi/backend-assets/vendor/libs/datepicker/datepicker.css"/>
<!-- New time -->
<div id="containerTime">
    <div class="card bg-light border shadow-none mb-2">
        <div class="card-body p-2">
            <form action="" method="post" id="form-special-dates-{{$countHours}}">
                @csrf
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="merchant_id" value="{{$id}}">
                        <input type="hidden" name="hours_type" value="special">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3 container-count">
                            <div class="form-text input-count me-3">
                                <span id="countNow">0</span> / 40
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control input-counter" 
                                id="inputCount-1" 
                                placeholder="special date name" name="name" 
                                autofocus maxlength="40" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <input type="text" name="date" class="form-control" data-toggle="datepicker" 
                            id="specialDate" placeholder="dd / mm / yyyy" value="25 / 12 / 2022">
                        </div>
                        <div id="dateHelp1" class="form-text text-danger d-none">
                            Selected date already used as another special date.
                        </div>
                    </div>    
                    <div class="col-6">
                        <div class="mb-3">
                            <select class="form-select default-select-single" 
                            name="condition" style="width: 100%;">
                                <option value="close">Close</option>
                                <option value="open">Open</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">                        
                    <div>
                        <div>
                            </div>
                        </div>
                    <div>
                        <div>
                            <button type="button" class="btn btn-outline-secondary actionDelete" 
                            data-day='special' data-id='{{$id}}' data-exist="not">Cancel</button>
                            <button type="submit" class="btn btn-outline-secondary actionSaved">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>                                                   
    </div>
</div>
<!-- //New time -->

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>

    //cancel
    $('.actionDelete').on('click',function () {
        let id = $(this).data('id');
        $.get("{{route('hours-list',['companyCode' => $companyCode])}}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // add service period
    $('.add-again-service-period').on('click',function () {
        let day = $(this).data('day');
        let id = $(this).data('id');
        $.get("{{route('hours-create',['companyCode' => $companyCode])}}",
        {day:day,id:id},function (data) {
            $(`.detail-trading-hours-${day}`).html(data);
        });
    })

    // store hour
    $('#form-special-dates-{{$countHours}}').on('submit',function () {
        event.preventDefault();
        let id = $("input[name='merchant_id']").val();
        $.ajax({
            type: 'POST',
            url: "{{ route('hours-store',['companyCode' => $companyCode]) }}",
            data: $(this).serialize(),
            success: function (data) {
                $.get("{{route('hours-list',['companyCode' => $companyCode])}}",
                {id:id},function (data) {
                    $('#contentDashboard').html(data);
                })
            },
            error: function (data) {
                $('#dateHelp1').removeClass('d-none');
            }
        })
    });
</script>