<link rel="stylesheet" type="text/css"
href="/arvi/backend-assets/vendor/libs/datepicker/datepicker.css"/>
<form id="manageStore" method="post">
    @csrf
    <div class="row justify-content-start">
        <div class="col-lg-2 col-md-2 col-12 mb-3">
            &nbsp;
        </div>
        <div class="col-lg-7 col-md-8 col-12">
            <!-- -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="m-0"><span class="text-muted">QR Management</span> / Add New QR Details</h4>
                        <div>
                            <a href="javascript:void(0);"
                                onclick="$('#manage-qr').trigger('click')">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="locName" class="form-label">
                                    Name *
                                </label>
                                <div class="form-text input-count me-3">
                                    <span id="countNow">0</span> / 60
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control"
                                    id="inputCount" name="name"
                                    autofocus maxlength="60" required autocomplete="off">
                                    <div id="nameHelp" class="form-text text-danger d-none HelpMes">
                                        Name is Required.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="locAddr" class="form-label">
                                    Select Store *
                                </label>
                                <select class="form-select
                                default-select-single w-100" name="store">
                                    <option>Select</option>
                                    @foreach ($merchantIds as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <div id="storeHelp" class="form-text text-danger d-none HelpMes">
                                    Choose Store is Required.
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3 container-count">
                                <label for="locAddr" class="form-label">
                                    Select Type *
                                </label>
                                <select class="form-select default-select-single w-100"
                                 name="type" id="qr_type">
                                    <option>Select</option>
                                    <option value="0">Digital Menu</option>
                                    <option value="1">AR</option>
                                </select>
                                <div id="typeHelp" class="form-text text-danger d-none HelpMes">
                                    Choose type is Required.
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="url-input">
                            <div class="mb-3 container-count">
                                <label for="locBulding" class="form-label">URL *</label>
                                <input type="text" class="form-control" name="url"
                                autocomplete="off" placeholder="https://" id="form-url">
                                <div id="urlHelp" class="form-text text-danger d-none HelpMes">
                                    URL is Required.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mt-5">&nbsp;</div>
    <div class="bg-primary fixed-bottom"
    style="z-index: 0 !important; display: none;" id="containerButton">
    <div class="d-flex justify-content-between align-items-center p-3">
    <div class="text-white"></div>
    <div>
        <a href="#" class="btn btn-outline-light"
        onclick="$('#manage-qr').trigger('click')">Cancel</a>
        <button type="submit" class="btn btn-light">
            Save
        </button>
    </div>

</form>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    // if digital menu
    $('#qr_type').on('change',function () {
        if ($(this).val() == 0) {
            $('#url-input').addClass('d-none');
            $('#form-url').prop('required',false);
        }else{
            $('#url-input').removeClass('d-none');
            $('#form-url').prop('required',true);
        }
    })

    // save
    $('#manageStore').on('submit',function () {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('qr-store') }}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#manage-qr').trigger('click');
            },
            error: function (data) {

                $('.HelpMes').addClass('d-none');

                let em = JSON.parse(data.responseText)['errors'];
                Object.values(em).forEach(val => {
                    if (val[0] == 'The name field is required.') {
                        $('#nameHelp').removeClass('d-none');
                    }
                    if (val[0] == 'The store must be a number.') {
                        $('#storeHelp').removeClass('d-none');
                    }
                    if (val[0] == 'The type must be a number.') {
                        $('#typeHelp').removeClass('d-none');
                    }
                    if (val[0] == 'The url field is required.') {
                        $('#urlHelp').removeClass('d-none');
                    }
                });
            }
        })
    })
</script>
