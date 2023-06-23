<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-start">
        <div class="col-lg-7 col-md-8 col-12">
            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="m-0">
                                <span class="text-muted">Manage Store</span>
                                 / {{$merchantName}} / Hours
                            </h4>
                        </div>
                        <div>
                            <a href="javascript:void(0);" id="btnback">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="demo-inline-spacing mt-2">
                        <div class="list-group list-group-horizontal-md text-md-center">
                        <a class="list-group-item list-group-item-action active" id="home-list-item" 
                        data-bs-toggle="list" href="#trading-hours">Trading Hours</a>
                        <a class="list-group-item list-group-item-action" id="messages-list-item" 
                        data-bs-toggle="list" href="#special-dates">Special Dates</a>
                    </div>
                    <div class="tab-content px-0 mt-0">
                        <!-- trading hours -->
                        <div class="tab-pane fade active show" id="trading-hours">
                            @foreach ($days as $item)
                                <!-- add time -->
                                <div class="row align-items-top mb-3">
                                    <div class="col-lg-3 col-md-3 col-12 fw-bold">
                                        <div class="mt-2">{{$item}}</div>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-12 detail-trading-hours-{{$item}}">
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-outline-primary 
                                            add-service-period" id="{{$item}}"
                                                data-day="{{$item}}" data-id="{{$id}}">
                                                <i class="bx bx-plus"></i> 
                                                Add service period
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <!-- //add time -->
                            @endforeach
                        </div>
                        <!-- //trading hours -->
                        <!-- special dates -->
                        <div class="tab-pane fade" id="special-dates">
                            <!-- add special date -->
                            @foreach ($specialDates as $item)
                                <!-- New time -->
                                <div id="containerTime">
                                    <div class="card bg-light border shadow-none mb-2">
                                        <div class="card-body p-2">
                                            <form action="" method="post" class="form-special-dates">
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="hidden" name="merchant_id" value="{{$item->merchant_id}}">
                                                        <input type="hidden" name="hours_type" value="{{$item->hours_type}}">
                                                        <input type="hidden" name="dates_id" value="{{$item->id}}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">     
                                                        <div class="mb-3 container-count">                                                                   
                                                            <div class="form-text input-count me-3">
                                                                <span id="countNow">0</span> / 40
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="text" class="form-control input-counter 
                                                                special-date" 
                                                                name="name" autofocus placeholder="special date name" 
                                                                maxlength="20" 
                                                                value="{{$item->name}}" data-id="{{$item->id}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <input type="date" class="form-control special-date"
                                                            name="date" data-id="{{$item->id}}" placeholder="dd / mm / yyyy" 
                                                            value="{{date("Y-m-d", strtotime($item->date))}}" required>
                                                            <div id="dateHelp-{{$item->id}}" class="form-text text-danger d-none">
                                                                Selected date already used as another special date.
                                                            </div>
                                                        </div>
                                                    </div>    
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <select class="form-select default-select-single 
                                                                condition-{{$item->id}} special-date" 
                                                                name="condition" data-id="{{$item->id}}" 
                                                                style="width: 100%;" required>
                                                                <option value="close">Close</option>
                                                                <option value="open">Open</option>
                                                            </select>
                                                            <script>
                                                                $(".condition-{{$item->id}} > option[value='{{$item->condition}}']").
                                                                attr('selected','selected');
                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <div>
                                                            <button type="button" 
                                                            class="btn btn-outline-secondary actionDeleteSpecial" 
                                                            data-type='special' data-dates_id='{{$item->id}}' 
                                                            data-merchant_id='{{$item->merchant_id}}' data-id="{{$item->id}}">
                                                                <i class="bx bx-trash-alt text-danger" ></i>
                                                            </button>
                                                            </div>
                                                        </div>
                                                    <div>
                                                        <div>
                                                            <button type="submit" class="btn btn-outline-secondary 
                                                            actionSavedSpecial {{isset($item)?'d-none':''}}" 
                                                            data-id="{{$item->id}}">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>                                                   
                                    </div>
                                </div>
                                <!-- //New time -->
                            @endforeach
                            <div id="dateHelp" class="form-text text-danger d-none">
                                Selected date already used as another special date.
                            </div>
                                <div class="new-form-special-dates">
                                    <!-- Btn add -->
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-outline-primary" 
                                        id="addSpecialDate" data-type="special" data-id="{{$id}}">
                                            <i class="bx bx-plus"></i>
                                            Add special date
                                        </button>
                                    </div>
                                    <!-- //Btn add -->
                                    <!-- //add special date -->
                                </div>
                            </div>
                        </div>
                        <!-- //special dates -->
                    </div>
                </div>
            </div>
            <!-- // -->
        </div>
    </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    // $('#dateHelp').removeClass('d-none');

    // button cancel
    $('#btnback').on('click',function () {
        $('#manage-store-button').trigger("click");
    })

    // check if change diffrent hours
    $('.special-date').on('keyup change',function () {
        let id = $(this).data('id');
        $(`.actionSavedSpecial[data-id="${id}"]`).removeClass('d-none');
    })

    // edit specialdates
    $('.form-special-dates').on('submit',function () {
        event.preventDefault();
        let id = $("input[name='merchant_id']").val();
        let dateId = $(this).serializeArray()[3].value;
        $('#dateHelp').addClass('d-none');
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
                $(`#dateHelp-${dateId}`).removeClass('d-none');
            }
        })
    })

    // delete special dates
    $('.actionDeleteSpecial').on('click',function (params) {
        let dates_id    = $(this).data('dates_id');
        let type        = $(this).data('type');
        let merchant_id = $(this).data('merchant_id');
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'DELETE',
            url: "{{ route('hours-destroy',['companyCode' => $companyCode]) }}",
            data: {
                "dates_id": dates_id,
                "merchant_id": merchant_id,
                "type": type,
                "_token": token,
            },
            success: function (){
                $.get("{{route('hours-list',['companyCode' => $companyCode])}}",
                {id:merchant_id},function (data) {
                    $('#contentDashboard').html(data);
                })
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    // add special date
    $('#addSpecialDate').on('click',function () {
        let id = $(this).data('id');
        let type = $(this).data('type');
        $.get("{{route('hours-create',['companyCode' => $companyCode])}}",
        {type:type,id:id},function (data) {
            $(`.new-form-special-dates`).html(data);
        });
    })

    // parse php array to javascript
    var alreadySet = JSON.parse('<?= json_encode($alreadySet); ?>');
    
    // add service period
    $('.add-service-period').on('click',function () {
        let day = $(this).data('day');
        let id = $(this).data('id');
        $.get("{{route('hours-create',['companyCode' => $companyCode])}}",
        {day:day,id:id},function (data) {
            $(`.detail-trading-hours-${day}`).html(data);
        });
    })

    // open if already set
    alreadySet.forEach(element => {
        $(`.add-service-period#${element}`).click();
    });

</script>
