<!-- Content wrapper -->
<div class="content-wrapper">
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
                                        <span class="text-muted">Squad Account</span> / New
                                    </h4>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" id="btnback">
                                        <i class="fas fa-chevron-left"></i> back
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <input type="hidden" name="id" value="{{$squad->id}}">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="fnameAccount" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control" name="name" id="fname"
                                        value="{{$squad->name}}" required autocomplete="off" required>
                                        <div id="emailAccountHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="mb-3">
                                        <label for="mobile" class="form-label">Mobile Number *</label>
                                        <input type="text" class="form-control  noArrow phone_with_ddd"
                                        id="mobile" name="phone_number" placeholder="Enter active mobile number"
                                        autocomplete="off" required value="{{$squad->phone_number}}" />
                                        <div id="mobileHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox"
                                            name="change-password" id="change-password">
                                        <label class="form-check-label" for="change-password">
                                             Change password?
                                        </label>
                                    </div>
                                </div>
                                <div class="row" id="form-change-password-appear">
                                    <div class="col-lg-6 col-md-6 col-12 form-change-password-appear">
                                        <div class="form-group mb-3 password-group">
                                            <label for="password1" class="form-label">Password *</label>
                                            <input type="password" class="f-inputbox password-box 
                                            form-control" required="required"
                                            autocomplete="off" id="password1" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>
                                            <a href="#!" class="password-visibility">
                                                <i class="bx bx-hide text-light"></i></a>
                                            <div id="password1Help" class="form-text text-danger d-none">
                                                Password not same.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 form-change-password-appear">
                                        <div class="form-group mb-3 password-group">
                                            <label for="password2" class="form-label">
                                                Confirm Password *
                                            </label>
                                            <input type="password" class="f-inputbox password-box 
                                            form-control" required="required"
                                            autocomplete="off" id="password2" name="password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required/>
                                            <a href="#!" class="password-visibility">
                                                <i class="bx bx-hide text-light"></i>
                                            </a>
                                            <div id="password2Help" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // -->
                    <!-- -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><h6 class="m-0">Location Assigned *</h6></div>
                            </div>
                            <hr>
                            <div class="mb-4 search">
                                <input class="form-control form-control-custom me-2" type="search"
                                placeholder="Search location ..." aria-label="Search" autocomplete="off"
                                id="input-search" />
                                <button type="reset">&times;</button>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($locations as $item)
                                        <div class="form-check mb-2 location-search">
                                            <input class="form-check-input radio-location"
                                            type="radio" value="{{$item->id}}"
                                            id="{{$item->name}}{{$item->id}}" name="loc_id">
                                            <label class="form-check-label" for="{{$item->name}}{{$item->id}}">
                                                {{$item->name}}
                                            </label>
                                        </div>
                                        @if ($i == ceil(count($locations)/2))
                                            </div>
                                            <div class="col-12 col-md-6">
                                        @endif
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                <div id="locationHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- // -->
                </div>
                <!-- -->
                <div class="my-3">
                    <div class="row justify-content-start">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="d-grid">
                                <button type="button" class="btn btn-danger
                                 delete-squad" data-bs-toggle="modal"
                                data-bs-target="#modaldDefaultDelete" data-id="{{$squad->id}}">
                                    Remove account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // -->
            </div>
        </div>
        <!-- THE BUTTON -->
        <div class="mt-5">&nbsp;</div>
        <div class="bg-primary fixed-bottom" style="z-index: 0 !important; 
        display: none;" id="containerButton">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="text-white"></div>
                <div>
                    <a href="#" class="btn btn-outline-light" id="btnCancelManageStore">Cancel</a>
                    <button type="submit" class="btn btn-light" >Save</button>
                </div>
            </div>
        </div>
        <!-- //THE BUTTON -->
    </form>
</div>
<!-- Content wrapper -->

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
    // search
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".location-search").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        $.get("{{ secure_url(route('squad-account-list',['companyCode' => $companyCode])) }}"
        ,function (data) {
            $('#contentDashboard').html(data);
        })
    })

    $( document ).ready(function() {
        // set old data on radio button location assigned
        let location = "{{$squad['location_id']}}";
        $(`input[name=loc_id][value=${location}]`).prop("checked", true);
        
        // change password appear
        var p = $('.form-change-password-appear').detach();
        $('#change-password:checkbox').on('click',function () {
            if (p) {
                p.appendTo( "#form-change-password-appear" );
                p = null;
            } else {
                p = $('.form-change-password-appear').detach();
            }
        })
    });

    // delete
    $(".delete-squad").on('click',function(){
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
            url: "{{ route('squad-account-destroy',['companyCode' => $companyCode]) }}",
            data: {
                "id": id,
                "_token": token,
            },
            success: function (){
                $('#manage-squad-account-admin').trigger("click");
            }
        });
    })

    // submit form
    $('#manageStore').on('submit',function () {
        event.preventDefault();
        if($('input[name="loc_id"]').is(':checked')){
            $.ajax({
                type: 'PUT',
                url: "{{ route('squad-account-update',['companyCode' => $companyCode]) }}",
                data: $(this).serialize(),
                success: function (data) {
                    $('#manage-squad-account-admin').trigger("click");
                },
                error: function (data) {
                    var err = JSON.parse(data.responseText).errors;
                    if (!$('#locationHelp').hasClass('d-none')) {
                        $('#locationHelp').addClass('d-none');
                    }
                    if (!$('#password1Help').hasClass('d-none')) {
                        $('#password1Help').addClass('d-none');
                    }
                    if (err != undefined) {
                        Object.keys(err).forEach(function(key) {
                            if (key == 'password') {
                                $('#password1Help').removeClass('d-none');
                            }
                            if (key == 'password') {
                                $('#password1Help').removeClass('d-none');
                            }
                        });
                    }
                }
            })
        }else{
            $('#locationHelp').removeClass('d-none');
        }
    });
</script>
