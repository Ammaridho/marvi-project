<!-- Content wrapper -->
<div class="content-wrapper">

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
                        <div><h6 class="m-0">Store Login</h6></div>
                        <div>
                            <a href="javascript:void(0);" id="btnback">
                                <i class="fas fa-chevron-left"></i> back
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <input type="hidden" name="companyId" value="{{$companyId}}">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="fnameAccount" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="fname" 
                                name="name" required autocomplete="off">
                                <div id="nameAccountHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <label for="emailAccount" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="option1" 
                                name="email" required autocomplete="off">
                                <div id="emailAccountHelp" class="form-text text-danger d-none">
                                    Email already use.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile Number *</label>
                                <input type="text" class="form-control  noArrow phone_with_ddd" 
                                id="mobile" name="mobile" placeholder="Enter active mobile number" 
                                autocomplete="off" required />
                                <div id="mobileHelp" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group mb-3 password-group">
                                <label for="password1" class="form-label">Password *</label>
                                <input type="password" class="f-inputbox password-box 
                                form-control" required="required" autocomplete="off" 
                                id="password1" name="password"  
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <a href="#!" class="password-visibility">
                                    <i class="bx bx-hide text-light"></i>
                                </a>
                                <div id="password1Help" class="form-text text-danger d-none">
                                    password not same.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group mb-3 password-group">
                                <label for="password2" class="form-label">Confirm Password *</label>
                                <input type="password" class="f-inputbox password-box form-control" 
                                required="required" autocomplete="off" id="password2" 
                                name="password_confirmation"  
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <a href="#!" class="password-visibility">
                                    <i class="bx bx-hide text-light"></i>
                                </a>
                                <div id="password2Help" class="form-text text-danger d-none">
                                    Error message here.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <label for="roles" class="form-label">Roles</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" 
                                        id="inlineRadio1" value="admin">
                                        <label class="form-check-label" for="inlineRadio1">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" 
                                        id="inlineRadio2" value="viewer">
                                        <label class="form-check-label" for="inlineRadio2">Viewer</label>
                                    </div>
                                    <div id="rolesHelp" class="form-text text-danger d-none">
                                        Please select at least 1 option.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // -->
            
            <!-- Brands -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h6 class="m-0">Brand *</h6></div>
                    </div>
                    <hr>
                    <div class="row">
                        
                        @foreach ($brands as $item)
                        <div class="col-12 col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input choose-brands" 
                                type="checkbox" name="brand" value="{{$item->id}}" id="b-{{$item->id}}">
                                <label class="form-check-label" for="b-{{$item->id}}"> 
                                    {{$item->name}}
                                </label>
                            </div>
                        </div>
                        @endforeach
                        
                        <div id="brandSelectHelp" class="form-text text-danger d-none">
                            Please select at least 1 option.
                        </div>
                    </div>
                </div>
            </div>

            <div id="merchant-appear"></div>

            
            <!-- // -->

        </div>
    </div>

</div>

<!-- THE BUTTON -->
<div class="mt-5">&nbsp;</div>
{{-- set button hide and show --}}
<div class="bg-primary fixed-bottom" style="z-index: 0 !important; display: none;" id="containerButton">
{{-- <div class="bg-primary fixed-bottom" style="z-index: 0 !important;" id="containerButton"> --}}
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

</div>
<!-- Content wrapper -->

<script src="/arvi/backend-assets/js/demo.js"></script>
<script>
    // merchant appear
    $('.choose-brands').on('click',function () {
        // check brand in check
        checkedBrands = $('.choose-brands:checkbox:checked').map(function(){
        return $(this).val();
        }).get();

        
        if (jQuery.isEmptyObject(checkedBrands)) {
            $('#merchant-appear').html('');
        }else{
            $.get("{{route('account-create-merchant-appear',['companyCode' => $companyCode])}}",
            {checkedBrands:checkedBrands},function (data) {
                $('#merchant-appear').html(data);
            })
        }
    })

    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        $('#account-button').trigger("click");
    })

    // submit form edit product
    $('#manageStore').on('submit',function () {
        event.preventDefault();

        
        if ($("input[value='admin']").is(':checked') || $("input[value='viewer']").is(':checked')) {

            if($('input[name="brand"]').is(':checked')){

                $.ajax({
                    type: 'POST',
                    url: "{{ route('account-store',['companyCode' => $companyCode]) }}",
                    data: $(this).serialize(),
                    success: function (data) {
                        $('#account-button').trigger("click");
                    },
                    error: function (data) {
                        var err = JSON.parse(data.responseText).errors;

                        if (!$('#brandSelectHelp').hasClass('d-none')) {
                            $('#brandSelectHelp').addClass('d-none');
                        }
                        if (!$('#rolesHelp').hasClass('d-none')) {
                            $('#rolesHelp').addClass('d-none');
                        }
                        if (!$('#password1Help').hasClass('d-none')) {
                            $('#password1Help').addClass('d-none');
                        }
                        if (!$('#emailAccountHelp').hasClass('d-none')) {
                            $('#emailAccountHelp').addClass('d-none');
                        }

                        if (err != undefined) {
                            Object.keys(err).forEach(function(key) {
                                if (key == 'password') {
                                    $('#password1Help').removeClass('d-none');
                                } else{
                                    $('#emailAccountHelp').removeClass('d-none');
                                }
                            });
                        }else{
                            $('#emailAccountHelp').removeClass('d-none');
                        }
                    }
                })
                
            }else{

                if (!$('#rolesHelp').hasClass('d-none')) {
                    $('#rolesHelp').addClass('d-none');
                }
                if (!$('#password1Help').hasClass('d-none')) {
                    $('#password1Help').addClass('d-none');
                }
                if (!$('#emailAccountHelp').hasClass('d-none')) {
                    $('#emailAccountHelp').addClass('d-none');
                }
                $('#brandSelectHelp').removeClass('d-none');
                
            }
            
        }else{
            if (!$('#rolesHelp').hasClass('d-none')) {
                $('#rolesHelp').addClass('d-none');
            }else{
                $('#rolesHelp').removeClass('d-none');
            }
        }
    });
</script>
