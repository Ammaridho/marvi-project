<form id="manageStore" autocomplete="off">
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
                        <div><h4 class="m-0"><span class="text-muted">Company Settings</span></h4></div>
                        <div></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="nameUser" class="form-label">Full Name *</label>
                                        <input type="text" name="nameUser" value="{{$loginData->name}}" 
                                        class="form-control" id="nameUser" autofocus required>
                                        <div id="nameUserHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                                @if (isset($dataCompany))
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="nameCompany" class="form-label">Company Name *</label>
                                            <input type="text" name="nameCompany" value="{{$dataCompany->name}}"
                                            class="form-control" id="nameCompany" required>
                                            <div id="nameCompanyHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="company_address" class="form-label">
                                                Company Address *
                                            </label>
                                            <input type="text" name="company_address" 
                                            value="{{$dataCompany->street_address}}"
                                            class="form-control" id="company_address" required>
                                            <div id="company_addressHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="mobile" class="form-label">Mobile Number *</label>
                                            <input type="text" name="phone_number" value="{{$dataCompany->phone_number}}"
                                            class="form-control noArrow phone_with_ddd" id="mobile" name="mobile" 
                                            placeholder="Enter active mobile number" autocomplete="off" required/>
                                            <div id="mobileHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" name="email" value="{{$dataCompany->email}}"
                                            class="form-control" id="email" name="email-username" 
                                            placeholder="Enter your email or username" 
                                            autofocus autocomplete="off" required/>
                                            <div id="fnameHelp" class="form-text text-danger d-none">
                                                Error message here.
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                        <div>
                            <h4 class="m-0">
                                <span class="text-muted">
                                    Password Account
                                </span>
                            </h4>
                        </div>
                        <div></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input change-password" type="checkbox" 
                                    name="change-password" value="change-password" id="change-password">
                                <label class="form-check-label" for="change-password"> 
                                    Change password? 
                                </label>
                            </div>
                        </div>
                        <div class="row" id="form-change-password-appear">
                            <div class="col-12 form-change-password-appear">
                                <div class="form-group mb-3 password-group">
                                    <label for="password0" class="form-label">Old Password</label>
                                    <input type="password" class="f-inputbox password-box form-control" 
                                    equired="required" autocomplete="off" id="password0" name="passwordOld"  
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;
                                    &#xb7;&#xb7;&#xb7;" />
                                    <a href="#!" class="password-visibility">
                                        <i class="bx bx-hide text-light"></i>
                                    </a>
                                    <div id="oldPasswordHelp" class="form-text text-danger d-none">
                                        Wrong old password.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-change-password-appear">
                                <div class="form-group mb-3 password-group">
                                    <label for="password1" class="form-label">New Password</label>
                                    <input type="password" class="f-inputbox password-box form-control" 
                                    required="required" autocomplete="off" id="password1" name="password"  
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;
                                    &#xb7;&#xb7;&#xb7;" />
                                    <a href="#!" class="password-visibility">
                                        <i class="bx bx-hide text-light"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 form-change-password-appear">
                                <div class="form-group mb-3 password-group">
                                    <label for="password2" class="form-label">Confirm New Password</label>
                                    <input type="password" class="f-inputbox password-box form-control" 
                                    required="required" autocomplete="off" id="password2" 
                                    name="password_confirmation"  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;
                                    &#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <a href="#!" class="password-visibility">
                                        <i class="bx bx-hide text-light"></i>
                                    </a>
                                    <div id="passwordConfirmHelp" class="form-text text-danger d-none">
                                        Password confirmation not match.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // -->
        </div>
    </div>
</div>

<!-- THE BUTTON -->
<div class="mt-5">&nbsp;</div>
<div class="bg-primary fixed-bottom" 
style="z-index: 0 !important; display: none;" id="containerButton">
    <div class="d-flex justify-content-between align-items-center p-3">
        <div class="text-white"></div>
        <div>
            <a href="#" class="btn btn-outline-light" id="btnCancelManageStore">Cancel</a>
            <button type="submit" class="btn btn-light">Save</button>
        </div>
    </div>
</div>
<!-- //THE BUTTON -->
</form>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    $( document ).ready(function() {
        // change password appear
        var p;
        $("#change-password:checkbox").trigger('click');
        $('#change-password:checkbox').on('click',function () {
            if (p) {
                p.appendTo( "#form-change-password-appear" );
                p = null;
            } else {
                p = $('.form-change-password-appear').detach();
            }
        })
        $("#change-password:checkbox").trigger('click');
    })

    // button cancel
    $('#btnCancelManageStore').on('click',function () {
        $('#dashboard-button').trigger("click");
    })

    // submit form edit product
    $('#manageStore').on('submit',function () {
        event.preventDefault();
        $.ajax({
            type: 'PUT',
            url: "{{ route('setting-account-dashboard',['companyCode' => $companyCode]) }}",
            data: $(this).serialize(),
            success: function (data) {
                location.reload();
            },
            error: function (data) {
                var err = JSON.parse(data.responseText).errors;
                if (!$('#passwordConfirmHelp').hasClass('d-none')) {
                    $('#passwordConfirmHelp').addClass('d-none');
                }
                if (!$('#oldPasswordHelp').hasClass('d-none')) {
                    $('#oldPasswordHelp').addClass('d-none');
                }
                if (err != undefined) {
                    $('#passwordConfirmHelp').removeClass('d-none');
                }else{
                    $('#oldPasswordHelp').removeClass('d-none');
                }
            }
        })
    });
</script>