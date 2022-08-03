{{-- {{dd($dataUser)}} --}}
<form id="form-account">
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
                    </div>
                    <hr>
                    <div class="row">
                        <input type="hidden" name="idUser" value="{{$dataUser['id']}}">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" 
                                id="name" value="{{$dataUser['name']}}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="email" class="form-label">Login Email</label>
                                <input type="text" class="form-control" name="email" 
                                id="email" value="{{$dataUser['email']}}" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" 
                                id="password" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" 
                                id="password_confirmation" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="mb-3">
                                <label for="pass2" class="form-label">Roles</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="inlineRadio1" value="admin">
                                        <label class="form-check-label" for="inlineRadio1">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role" id="inlineRadio2" value="viewer">
                                        <label class="form-check-label" for="inlineRadio2">Viewer</label>
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
                        <div><h6 class="m-0">Store</h6></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            @foreach ($merchants as $item)
                                <div class="form-check">
                                    <input class="form-check-input" name="store[]" type="checkbox" value="{{$item->id}}">
                                    <label class="form-check-label" for="defaultCheck1"> {{$item->name}} </label>
                                </div>
                            @endforeach
                            {{-- <div class="form-check">
                                <input class="form-check-input" name="store[]" type="checkbox" value="2" id="defaultCheck2">
                                <label class="form-check-label" for="defaultCheck2"> Ayam Gebrek - Menara Mall Ambasador </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" name="store[]" type="checkbox" value="3" id="defaultCheck3">
                                <label class="form-check-label" for="defaultCheck3"> Ayam Gebrek - Margonda Depok </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="store[]" type="checkbox" value="4" id="defaultCheck4">
                                <label class="form-check-label" for="defaultCheck4"> Ayam Gebrek - Bekasi </label>
                            </div> --}}
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
<div class="bg-primary fixed-bottom" style="z-index: 0 !important;" id="containerButton">
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

<script>
    $( document ).ready(function() {
        // set radio button
        let role = "{{$dataUser['role']}}";
        $("input[value="+role+"]").attr('checked',true);

    });

    // button cancel
    $('#btnCancelManageStore').on('click',function () {
        $('#account-button').trigger("click");
    })

    // submit form edit product
    $('#form-account').on('submit',function () {
        event.preventDefault();
        id = 1;
        $.ajax({
            type: 'PUT',
            url: "{{ route('account-update',['qrCode' => $qrCode]) }}",
            data: $(this).serialize(),
            success: function (data) {
                alert('update success!');
                $('#account-button').trigger("click");
            },
            error: function (data) {
                console.log(data);
                alert('input the data correctly!');
            }
        })
    });
</script>
