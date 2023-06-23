<div class="row justify-content-start">
    <div class="col-lg-2 col-md-2 col-12 mb-3">
    &nbsp;
    </div>
        <div class="col-lg-7 col-md-8 col-12">
            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h4 class="m-0"><span class="text-muted">Store Settings</span> / Fees</h4></div>
                        <div><a href="javascript:void(0)" class="btn btn-primary" id="add-fee">
                            <i class="tf-icons bx bx-plus"></i> Add fee</a>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive ">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Fee Name</th>
                                    <th class="">Type</th>
                                    <th class="">Value</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fees as $item)
                                    <!-- fee -->
                                    <tr>
                                        <td class="fw-bold">{{$item->name}} </td>
                                        <td>
                                            {{$item->type_fee}}
                                        </td>
                                        <td>
                                            {{$item->type_value == 'percentage'?
                                            $item->value_fee.'%':$item->currency.' '.$item->value_fee}}
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="d-flex justify-content-end">
                                                <div class="mt-1 me-2">
                                                    <script>
                                                        var itemActive = "{{$item->active}}";
                                                        if (itemActive == '1') {
                                                          $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', true);
                                                        }else{
                                                          $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', false);
                                                        }
                                                    </script>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input btn-checkbox flexSwitchCheckChecked" 
                                                        type="checkbox" id="flexSwitchCheckChecked{{$item->id}}" 
                                                        data-data="{{$item}}">
                                                        <label class="form-check-label" for="flexSwitchCheckChecked{{$item->id}}">
                                                            {{$item->active == 1 ? 'Active' : 'Inactive'}}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mx-2"><a href="javascript:void(0);" class="btn btn-sm btn-primary edit-fee" 
                                                    data-id="{{$item->id}}"><i class="fas fa-pen"></i></a></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- //fee -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- // -->
        </div>
    </div>
</div>

<!-- modal confirm -->
<div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="modalConfirm" 
aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body border-bottom pb-3">
        <div>Are you sure want to disabled "<span id="confirm-name-brand"></span>" 
          Brand? This will affected all store under this brand will be 
          <span id="active-status-to-change"></span>.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-change-active" 
        data-bs-dismiss="modal" data-data="">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    // click check active inactive
    $('.flexSwitchCheckChecked').on('click',function () {
        let data = $(this).data('data');
        $('#confirm-name-brand').text(data['name']);
        $('#save-change-active').data('data',data);
        if (data['active'] == 1) {
            $('#active-status-to-change').html('<span class="fw-bold text-danger">inactive</span>');
        } else {
            $('#active-status-to-change').html('<span class="fw-bold text-success">active</span>');
        }
        // show modal
        $('#modalConfirm').modal('show');
        // check old status active
        // if not checked ============================================================
        if($(this).is(":checked")){
            $(this).prop('checked', false);
        // if checked ============================================================
        }else if($(this).is(":not(:checked)")){
            $(this).prop('checked', true);
        }
    })

    // save switch check active inactive
    $('#save-change-active').on('click',function () {
        let data = $(this).data('data');
        let active = data['active'] == '1' ? '0': '1' ;
        let id = data['id'];
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'PUT',
            url: "{{ route('fees-update',['companyCode' => $companyCode]) }}",
            data: {active:active,id:id,"_token": token},
            success: function (data) {
                $('#fees-button').trigger("click");
            },
            error: function (data) {
                console.log(data);
            }
        })
    })

    // add new
    $('#add-fee').on('click',function () {
        $.get("{{route('fees-create',['companyCode' => $companyCode])}}",function (data) {
            $('#contentDashboard').html(data);
        })
    });

    // edit
    $('.edit-fee').on('click',function () {
        let id = $(this).data('id');
        $.get("{{ secure_url(route('fees-edit',['companyCode' => $companyCode])) }}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })
</script>
