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
                            <div>
                                <h4 class="m-0">
                                    <span class="text-muted">Fees</span> / Add Fee
                                </h4>
                            </div>
                            <div>
                                <a href="javascript:void(0);" id="btnback"><i class="fas fa-chevron-left"></i> back</a>
                            </div>
                        </div>
                        <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="storeName" class="form-label">Fee Name</label>
                                <div class="form-text input-count me-3"><span id="countNow">0</span> / 25</div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="name" 
                                    id="inputCount" autofocus maxlength="25" required>
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
                                    <select class="form-select" name="type_fee" required>
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
                                    <select class="form-select" name="type_value" id="inputGroupSelect02" required>
                                        <option value="Select">type...</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="percentage">Percentage</option>
                                    </select>

                                    <select class="form-select d-none" name="currency" id="brandCurrencies" required>
                                        <option value="Select">Currency..</option>
                                        @foreach ($currencies as $item)
                                            <option value="{{$item['iso']['code']}}">
                                                {{$item['name']}}({{$item['iso']['code']}})
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <input type="text" class="form-control numbers" name="value_fee" required>
                                </div>
                                <div id="valueHelp" class="help form-text text-danger d-none">
                                    Please complete value.
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="active" id="blabla2" checked>
                                <label class="form-check-label" for="blabla2">Include this fee on checkout.</label>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
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
    
    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        $('#fees-button').trigger("click");
    })

    // submit
    $('#manageStore').on('submit',function () {
        event.preventDefault();

        $('.help').addClass('d-none');

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
                type:'POST',
                url: "{{ route('fees-store',['companyCode' => $companyCode]) }}",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#fees-button').trigger("click");
                },
                error: function (data) {
                    console.log(data);
                }
            })
        }
    })
</script>