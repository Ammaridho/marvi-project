
<form id="manageStore" method="" action="">
    @csrf
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-start">
            <div class="col-lg-2 col-md-2 col-12 mb-3">
                &nbsp;
            </div>
            <div class="col-lg-7 col-md-8 col-12">
                <!-- -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><h4 class="m-0"><span class="text-muted">Fees</span> / Add Fee</h4></div>
                            <div>
                                <a href="javascript:void(0);" id="btnback"><i class="fas fa-chevron-left"></i> back</a>
                            </div>
                        </div>
                        <hr>
                        <input type="hidden" name="fee_id" value="{{$fee->id}}">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3 container-count">
                                    <label for="storeName" class="form-label">Fee Name</label>
                                    <div class="form-text input-count me-3"><span id="countNow">0</span> / 25</div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="name" 
                                        value="{{$fee->name}}" id="inputCount" autofocus maxlength="25" required>
                                        <div id="nameHelp" class="help form-text text-danger d-none">
                                            Please complete Name.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="storeType" class="form-label">Fee Type (Tax/Admin)</label>
                                    <div class="mb-3">
                                        <select class="form-select" name="type_fee" id="type_fee" required>
                                            <option value="Select" selected="">Choose...</option>
                                            <option value="Tax">Tax</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                        <div id="typeHelp" class="help form-text text-danger d-none">
                                            please complete Fee Type.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="storeName" class="form-label">Value</label>
                                    <div class="input-group">
                                        <select class="form-select" name="type_value" id="type_value" required>
                                            <option value="Select" selected="">Choose...</option>
                                            <option value="fixed">Fixed (Rp.)</option>
                                            <option value="percentage">Percentage</option>
                                        </select>
                                        <select class="form-select d-none" name="currency" id="currency" required>
                                            <option value="Select">Currency..</option>
                                            @foreach ($currencies as $item)
                                                <option value="{{$item['iso']['code']}}">
                                                    {{$item['name']}}({{$item['iso']['code']}})
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control numbers" name="value_fee" 
                                        value="{{$fee->value_fee}}" required>
                                    </div>
                                    <div id="valueHelp" class="help form-text text-danger d-none">
                                        Please complete value.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch mb-2">
                                    <script>
                                        var itemActive = "{{$fee->active}}";
                                        if (itemActive == '1') {
                                          $("input[name='active']").prop('checked', true);
                                        }else{
                                          $("input[name='active']").prop('checked', false);
                                        }
                                    </script>
                                    <input class="form-check-input" type="checkbox" name="active" value="1" id="blabla2">
                                    <label class="form-check-label" for="blabla2">Include this fee on checkout.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -->
                    <div class="my-3">
                        <div class="row justify-content-start">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-danger delete-fee"
                                    data-id="{{$fee->id}}">Remove fee</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- // -->
            </div>
        </div>
    </div>
    <div class="mt-5">&nbsp;</div>
    <div class="bg-primary fixed-bottom" style="z-index: 0 !important; display: none;" id="containerButton">
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="text-white"></div>
            <div>
                <a href="#" class="btn btn-outline-light" id="btnCancelManageStore">Cancel</a>
                <button type="submit" class="btn btn-light">Save</button>
            </div>
        </div>
    </div>
</form>
{{-- modal confirmatin delete --}}
<div class="modal fade" id="modaldDefaultDelete" tabindex="-1" 
aria-labelledby="modaldDefaultDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom pb-3">
                <h5 class="modal-title">Remove Confirmation</h5>
                <button type="button" class="btn-close" 
                data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body center p-3">
                <h4>You're about to <span class="text-danger">remove</span> this item.</h4>
                <div class="">By doing this action, you will removed the item and cannot be undone.</div>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-delete" 
                data-bs-dismiss="modal" data-id="">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    // type value choose
    $("select[name='type_value']").on('change click',function () {
        if ($("select[name='type_value']").val() == 'fixed') {
            $("select[name='currency']").prop( "disabled", false );
            $("select[name='currency']").removeClass("d-none");
        }else{
            $("select[name='currency']").prop( "disabled", true );
            $("select[name='currency']").addClass("d-none");
        }
    })

     $( document ).ready(function() {
        // old data type_fee
        let type_fee = "{{$fee['type_fee']}}";
        if (type_fee != '') {
            $(`#type_fee option[value="${type_fee}"]`).attr('selected','selected');
        }
        // old data type_value
        let type_value = "{{$fee['type_value']}}";
        if (type_value != '') {
            if (type_value == 'fixed') {
                $("select[name='currency']").removeClass("d-none");
            }
            $(`#type_value option[value="${type_value}"]`).attr('selected','selected');
        }
        // old data currency
        let currency = "{{$fee['currency']}}";
        if (currency != '') {
            $(`#currency option[value="${currency}"]`).attr('selected','selected');
        }
    });

    // delete
    $(".delete-fee").on('click',function(){
        let id = $(this).data('id');
        $('#submit-delete').data('id',id);
        // show modal
        $('#modaldDefaultDelete').modal('show');
    }); 
    $('#submit-delete').on('click',function () {
        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'DELETE',
            url: "{{ route('fees-destroy',['companyCode' => $companyCode]) }}",
            data: {
                "id": id,
                "_token": token,
            },
            success: function (){
                $('#fees-button').trigger("click");
            }
        });
    })

    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        $('#fees-button').trigger("click");
    })

    // submit
    $('#manageStore').on('submit',function () {
        event.preventDefault();
        if (!$('#nameHelp').hasClass('d-none')) {
            $('#nameHelp').addClass('d-none');
        }
        if (!$('#typeHelp').hasClass('d-none')) {
            $('#typeHelp').addClass('d-none');
        }
        if (!$('#valueHelp').hasClass('d-none')) {
            $('#valueHelp').addClass('d-none');
        }
        if ($("input[name='name']").val() == '') {
            $('#nameHelp').removeClass('d-none');
        } else if ($("select[name='type_fee']").val() == 'Select' || 
        $("input[name='type_fee']").val() == '') {
            $('#typeHelp').removeClass('d-none');
        } else if ($("select[name='type_value']").val() == 'Select' || 
        $("input[name='value_fee']").val() == '') {
            $('#valueHelp').removeClass('d-none');
        } else {
            $.ajax({
                type:'PUT',
                url: "{{ route('fees-update',['companyCode' => $companyCode]) }}",
                data: $(this).serialize(),
                success: function (data) {
                    $('#fees-button').trigger("click");
                },
                error: function (data) {
                    alert(data);
                }
            })
        }
    })
</script>