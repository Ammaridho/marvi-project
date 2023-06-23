<!-- New time -->
<div id="containerTime">
    <div class="card bg-light border shadow-none mb-2">
        <div class="card-body p-2">
            <form action="" method="post" id="form-hours-{{$day}}">
                @csrf
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="day" value="{{$day}}">
                        <input type="hidden" name="merchant_id" value="{{$id}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">From</span>
                            <input type="time" class="form-control time from save-{{$id}}-{{$day}}" 
                            placeholder="HH:MM" 
                            name="hours_from" value="{{isset($hours) ? $hours->hours_from : ''}}" 
                            data-old_from_hours="{{isset($hours) ? $hours->hours_from : ''}}" 
                            data-patokan="save-{{$id}}-{{$day}}" required>
                            <div id="fromHelp" class="form-text text-danger d-none">Error message here.</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">To</span>
                            <input type="time" class="form-control time to save-{{$id}}-{{$day}}" 
                            placeholder="HH:MM" 
                            name="hours_to" value="{{isset($hours) ? $hours->hours_to : ''}}" 
                            data-old_to_hours="{{isset($hours) ? $hours->hours_to : ''}}" 
                            data-patokan="save-{{$id}}-{{$day}}" required>
                            <div id="toHelp" class="form-text text-danger d-none">
                                Error message here.
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="d-flex justify-content-between">
                    <div>
                        <div>
                            @if (isset($hours))
                                <button type="button" class="btn btn-outline-secondary actionDelete" 
                                data-day='{{$day}}' data-id='{{$id}}'>
                                    <i class="bx bx-trash-alt text-danger" ></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    <div>
                        <div>
                            @if (!isset($hours))
                                <button type="button" class="btn btn-outline-secondary actionDelete" 
                                data-day='{{$day}}' data-id='{{$id}}' data-exist="not">Cancel</button>
                            @endif
                            <button type="submit" class="btn btn-outline-secondary 
                            {{isset($hours)?'d-none':''}}" 
                            id="save-{{$id}}-{{$day}}">
                                save
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
    
    // check if change diffrent hours
    $('.time').on('keyup change',function () {
        //form
        let form_str_old = $(`.time.from.${$(this).data('patokan')}`).data('old_from_hours');
        let form_old = form_str_old.slice(0, -3);
        let form_now = $(`.time.from.${$(this).data('patokan')}`).val();
        // to
        let to_str_old = $(`.time.to.${$(this).data('patokan')}`).data('old_to_hours');
        let to_old = to_str_old.slice(0, -3);
        let to_now = $(`.time.to.${$(this).data('patokan')}`).val();
        if(form_old != form_now || to_old != to_now){
            $(`#${$(this).data('patokan')}`).removeClass('d-none');
        }else{
            $(`#${$(this).data('patokan')}`).addClass('d-none');
        }
    })

    // delete hour
    $('.actionDelete').on('click',function (params) {
        let day = $(this).data('day');
        let id = $(this).data('id');
        if ($(this).data('exist') == 'not') {
            $.get("{{route('hours-list',['companyCode' => $companyCode])}}",
            {id:id},function (data) {
                $('#contentDashboard').html(data);
            })
        } else {
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: 'DELETE',
                url: "{{ route('hours-destroy',['companyCode' => $companyCode]) }}",
                data: {
                    "id": id,
                    "day": day,
                    "_token": token,
                },
                success: function (){
                    $.get("{{route('hours-list',['companyCode' => $companyCode])}}",
                    {id:id},function (data) {
                        $('#contentDashboard').html(data);
                    })
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });

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
    $('#form-hours-{{$day}}').on('submit',function () {
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
                console.log(data);
            }
        })
    });
</script>