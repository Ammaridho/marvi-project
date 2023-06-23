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
                            <input type="hidden" name="idUser" value="{{$dataUser['id']}}">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fnameAccount" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="fname" name="name" 
                                        value="{{$dataUser['name']}}" required autocomplete="off">
                                    <div id="nameAccountHelp" class="form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="emailAccount" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="option1" name="email" 
                                        value="{{$dataUser['email']}}" required autocomplete="off">
                                    <div id="emailAccountHelp" class="form-text text-danger d-none">
                                        Error message here.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile Number *</label>
                                    <input type="text" class="form-control  noArrow phone_with_ddd" 
                                        id="mobile" name="mobile" placeholder="Enter active mobile number" 
                                        autocomplete="off" value="{{isset($dataUser['phone_number']) ? 
                                        $dataUser['phone_number'] : 'kosong'}}" />
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
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <a href="#!" class="password-visibility">
                                            <i class="bx bx-hide text-light"></i>
                                        </a>
                                        <div id="password1Help" class="form-text text-danger d-none">
                                            Error message here.
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
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                        <a href="#!" class="password-visibility">
                                            <i class="bx bx-hide text-light"></i>
                                        </a>
                                        <div id="password2Help" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="roles" class="form-label">Roles</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input role-r-button" type="radio" 
                                            name="role" id="superadminrbutton" value="superadmin">
                                            <label class="form-check-label" for="superadminrbutton">
                                                Super Admin
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input role-r-button" type="radio" 
                                            name="role" id="inlineRadio1" value="admin">
                                            <label class="form-check-label" for="inlineRadio1">Admin</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input role-r-button" type="radio" 
                                            name="role" id="inlineRadio2" value="viewer">
                                            <label class="form-check-label" for="inlineRadio2">Viewer</label>
                                        </div>
                                        <div id="rolesHelp" class="form-text text-danger d-none">
                                            Error message here.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // -->
    
                <!-- Companies -->
                <div class="card mb-3 super-admin">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><h6 class="m-0">Company *</h6></div>
                        </div>
                        <hr>
                        <div class="mb-3 search">
                            <input class="form-control form-control-custom me-2" type="search" 
                            placeholder="Search company ..." aria-label="Search" autocomplete="off" />
                        </div>
                        <div class="row">
                            @foreach ($companies as $item)
                            <div class="col-12 col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input choose-companies" type="checkbox" 
                                        name="companies[]" value="{{$item->id}}" id="b-{{$item->id}}">
                                    <label class="form-check-label" for="b-{{$item->id}}"> 
                                        {{$item->name}} 
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            <div id="companySelectHelp" class="form-text text-danger d-none">
                                Error message here.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- // -->

                <div class="super-admin" id="brand-appear">

                </div>

                <div class="super-admin" id="merchant-appear">

                </div>

                <!-- -->
                <div class="my-3">
                    <div class="row justify-content-start">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="d-grid">
                                <button type="button" class="btn btn-danger delete-account"
                                data-id="{{$dataUser['id']}}">Remove account</button>
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
    {{-- set button hide and show --}}
    <div class="bg-primary fixed-bottom" style="z-index: 0 !important; display: none;" 
    id="containerButton">
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


{{-- script plugin --}}
<script type="text/javascript" src="/arvi/backend-assets/js/demo.js"></script>
<script>

    $( document ).ready(function() {
        // delete
        $(".delete-account").on('click',function(){
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
                url: "{{ route('account-admin-destroy',['companyCode' => $companyCode]) }}",
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    $('#manage-account-admin').trigger("click");
                }
            });
        })

        // superadmin
        $('.role-r-button').on('click',function () {
            if( $('#superadminrbutton').is(':checked') ){
                $('.super-admin').hide();
            }
            else{
                $('.super-admin').show();
            }
        })

        // change password appear
        $( document ).ready(function() {
            var p = $('.form-change-password-appear').detach();
            $('#change-password:checkbox').on('click',function () {
                if (p) {
                    p.appendTo( "#form-change-password-appear" );
                    p = null;
                } else {
                    p = $('.form-change-password-appear').detach();
                }
            })
        })

        // brand appear
        $('.choose-companies').on('click',function () {

            $('#merchant-appear').html('');
            // check company in check
            checkedCompanies = $('.choose-companies:checkbox:checked').map(function(){
                return $(this).val();
                }).get();
            
            if (jQuery.isEmptyObject(checkedCompanies)) {
                $('#brand-appear').html('');
            }else{
                idUser = "{{$dataUser['id']}}";
                $.get("{{route('account-admin-create-brand-appear',['companyCode' => $companyCode])}}",
                {checkedCompanies:checkedCompanies,idUser:idUser},function (data) {
                    $('#brand-appear').html(data);
                })
            }
        })


        var jArrayRole = "{{$dataUser['role']}}";
        var jArrayCompany_id = <?php echo json_encode(json_decode($dataRelationCompanies)); ?>;

        if (jArrayRole != '') {
            // set radio button roles
            let role = "{{$dataUser['role']}}";
            $("input[value="+role+"]").attr('checked',true);
        }
        
        if (jArrayCompany_id != null) {
            //set checkbox merchants
            let companies_id = jArrayCompany_id;
            companies_id.forEach(element => {
                $(".choose-companies:input[value="+element+"]").trigger('click');
            });
        }

        // hide companies brand and store if role super admin
        if( $('#superadminrbutton').is(':checked') ){
            $('.super-admin').hide();
        }
        else{
            $('.super-admin').show();
        }
    });
    

    // button cancel
    $('#btnCancelManageStore, #btnback').on('click',function () {
        $('#manage-account-admin').trigger("click");
    })

    // submit form
    $('#manageStore').on('submit',function () {
        event.preventDefault();

        if ($("input[value='admin']").is(':checked') || $("input[value='viewer']").is(':checked')) {
            if($('input[name="companies[]"]').is(':checked')){
                $.ajax({
                    type: 'PUT',
                    url: "{{ route('account-admin-update',['companyCode' => $companyCode]) }}",
                    data: $(this).serialize(),
                    success: function (data) {
                        $('#manage-account-admin').trigger("click");
                    },
                    error: function (data) {
                        var err = JSON.parse(data.responseText).errors;

                        if (!$('#companySelectHelp').hasClass('d-none')) {
                            $('#companySelectHelp').addClass('d-none');
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
                                } 
                                if (key == 'password') {
                                    $('#password1Help').removeClass('d-none');
                                } 
                            });
                        }else{
                            $('#emailAccountHelp').removeClass('d-none');
                        }
                    }
                })
                
            }else{
                $('#companySelectHelp').removeClass('d-none');

                if (!$('#rolesHelp').hasClass('d-none')) {
                    $('#rolesHelp').addClass('d-none');
                }
                if (!$('#password1Help').hasClass('d-none')) {
                    $('#password1Help').addClass('d-none');
                }
                if (!$('#emailAccountHelp').hasClass('d-none')) {
                    $('#emailAccountHelp').addClass('d-none');
                }
            }
            
        }else{
            $.ajax({
                type: 'PUT',
                url: "{{ route('account-admin-update',['companyCode' => $companyCode]) }}",
                data: $(this).serialize(),
                success: function (data) {
                    $('#manage-account-admin').trigger("click");
                },
                error: function (data) {

                    var err = JSON.parse(data.responseText).errors;

                    // hilangkan semua
                    if (!$('#password1Help').hasClass('d-none')) {
                        $('#password1Help').addClass('d-none');
                    }
                    if (!$('#rolesHelp').hasClass('d-none')) {
                        $('#rolesHelp').addClass('d-none');
                    }
                    if (!$('#emailAccountHelp').hasClass('d-none')) {
                        $('#emailAccountHelp').addClass('d-none');
                    }
                    if (err != undefined) {
                        Object.keys(err).forEach(function(key) {
                        
                            if (key == 'password') {
                                $('#password1Help').removeClass('d-none');
                            } 
                            if(key == 'role'){
                                $('#rolesHelp').removeClass('d-none');
                            } 
    
                        });
                    }else{
                        $('#emailAccountHelp').removeClass('d-none');
                    }
                }
            })

        }
        
    });
</script>
