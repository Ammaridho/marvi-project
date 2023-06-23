@php
    $title = 'Profile';
@endphp

@extends('arvi.frontend.store.layouts.main')

@section('content')

    <form action="{{ route('profile-update-store',['code'=>$code]) }}" method="post">
        @csrf
        <section class="section-first">
            <div class="container-fluid container-xs mt-2">
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><h5>Profile</h5></div>
                    </div>
                    <div class="mt-2">
                        <div class="form-group mb-3">
                            <input type="text" class="f-inputbox" required="required"
                            autocomplete="off" name="fname" value="{{ $user->name }}" />
                            <label class="f-label-fill">Full Name *</label>
                        </div>
                        @if($errors->has('fname'))
                            <div role="alert" class="form-text alert alert-danger p-2">
                                This field is required.
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <input type="text" class="f-inputbox form-control phone_with_ddd"
                            required="required" autocomplete="off" name="phone_number"
                            inputmode="decimal" value="{{ $user->phone_number }}"
                            placeholder="Mobile number" />
                            <label class="f-label-fill">Mobile Number *</label>
                        </div>
                        @if($errors->has('phone_number'))
                            <div role="alert" class="form-text alert alert-danger p-2">
                                This field is required.
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <textarea class="f-textbox" rows="2"
                            name="address">{{ $user->address }}</textarea>
                            <label class="f-label-fill">Address</label>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="devider"></section>

        <section>

            <div class="container-fluid container-xs mt-2">
                <div class="mt-3">
                    <div class="d-flex">
                        <div><h6>Change Password</h6></div>
                    </div>
                    <div class="mt-2">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox"
                                    name="change-password" id="change-password">
                                <label class="form-check-label" for="change-password">
                                    Change password?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3" id="form-change-password-appear">
                        <div class="form-group mb-3 password-group form-change-password-appear">
                            <input type="password" class="f-inputbox password-box"
                            required="required" autocomplete="off" id="password0"
                            name="password_old" value="" />
                            <a href="#!" class="password-visibility">
                                <i class="fa fa-eye text-theme-based"></i>
                            </a>
                            <label class="f-label-fill">Old Password</label>
                        </div>
                        @if (\Session::has('error'))
                            <div class="alert alert-danger">
                                {!! \Session::get('error') !!}
                            </div>
                        @endif
                        <div class="form-group mb-3 password-group form-change-password-appear">
                            <input type="password" class="f-inputbox password-box"
                            required="required" autocomplete="off" id="password1"
                            name="password" value="" />
                            <a href="#!" class="password-visibility">
                                <i class="fa fa-eye text-theme-based"></i>
                            </a>
                            <label class="f-label-fill">Password</label>
                        </div>
                        <div class="form-group mb-3 password-group form-change-password-appear">
                            <input type="password" class="f-inputbox password-box"
                            required="required" autocomplete="off" id="password2"
                            name="password_confirmation" value="" />
                            <a href="#!" class="password-visibility">
                                <i class="fa fa-eye text-theme-based"></i>
                            </a>
                            <label class="f-label-fill">Re-type password</label>
                        </div>
                        @if($errors->has('password'))
                            <div role="alert" class="form-text alert alert-danger p-2">
                                password not match.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="devider"></section>

        <section>
            <div class="container-fluid container-xs mt-2">
                <div class="mt-3">
                    <div class="d-flex">
                        <div><h6>Saved Address</h6></div>
                    </div>
                    <div class="mt-2">

                        {{-- saved address --}}
                        @foreach ($saved_address as $item)

                        <div class="pb-2 mb-2 border-bottom">
                            <div class="d-flex justify-content-between">
                                <div><span class="text-theme-primary">{{ $item->name }}</span>
                                <span class="small">
                                    <a href="javascript:void(0)" class="edit-saved-address"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit" data-data="{{ $item }}">Edit</a>
                                </span>
                                <br />{{ $item->phone_number }}
                            </div>
                            <div class="me-3">
                                <a href="javascript:void(0)" class="delete-saved-address"
                                data-id="{{ $item->id }}" data-bs-toggle="modal"
                                data-bs-target="#modalDelete">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>
                        <div class="small">{{ $item->address }}</div>
                        <div class="small">{{ $item->notes }}</div>
                        </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </section>

        <section class="section-last">
            <div class="fixed-bottom bg-white border-top">
                <div class="container-fluid container-xs">
                    <div class="my-2">
                        <div class="d-flex justify-content-center">
                            <div class="flex-grow-1 me-1">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" 
                                    onclick="location.href='{{route('index-store',['code'=>$code])}}';">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-1">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-sm btn-theme-secondary">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <!-- =================================================================
    MODAL
    ================================================================== -->
    <div class="modal fade" id="modalEdit" aria-hidden="true"
    aria-labelledby="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="fw-bold mb-4">Edit saved addresses.</div>

                    <input type="hidden" name="addressId">

                    <div class="form-group mb-3">
                        <input type="text" class="f-inputbox" required="required" 
                        autocomplete="off"
                        id="fname1" name="saved_name" value="Jushua Metamin Jr." />
                        <label class="f-label-fill">Full Name</label>
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control phone_with_ddd"
                        required="required" autocomplete="off" id="phone"
                        name="saved_phone" inputmode="decimal"
                        placeholder="Mobile number" />
                        <label class="f-label-fill">Mobile Number</label>
                    </div>

                    <div class="form-group">
                        <textarea class="f-textbox" rows="2" id="address"
                        name="saved_address"></textarea>
                        <label class="f-label-fill">Address</label>
                    </div>

                    <div class="form-group">
                        <textarea class="f-textbox" rows="2" id="notes"
                        name="saved_notes"></textarea>
                        <label class="f-label-fill">Notes</label>
                    </div>

                </div>
                <div class="modal-footer border-0 justify-content-between">
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm btn-theme-secondary"
                            id="store-address" data-bs-dismiss="modal">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelete" aria-hidden="true"
    aria-labelledby="modalDelete" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="fw-bold">Delete Saved Addresses</div>
                    <div>You are about to delete this address, are you sure?</div>
                </div>
                <div class="modal-footer border-0 justify-content-between">
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button"
                            class="btn btn-sm btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-grid">
                            <button type="button" id="confirm-delete"
                            class="btn btn-sm btn-theme-secondary"
                            data-bs-dismiss="modal">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- core -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script>
        // delete saved address
        $('.delete-saved-address').on('click',function () {
            let id = $(this).data('id');
            $('#confirm-delete').data('id',id);
        })

        $('#confirm-delete').on('click',function () {
            let id = $(this).data('id');
            $.ajax({
                type: 'Delete',
                url: "{{ route('saved-address-delete-store',['code'=>$code]) }}",
                data: {"_token": "{{ csrf_token() }}",id:id},
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    alert('error!');
                }
            })
        })

        // store saved address
        $('#store-address').on('click',function () {
            let id           = $("input[name='addressId']").val();
            let name         = $("input[name='saved_name']").val();
            let phone_number = $("input[name='saved_phone']").val();
            let address      = $("textarea[name='saved_address']").val();
            let notes        = $("textarea[name='saved_notes']").val();
            $.ajax({
                type: 'PUT',
                url: "{{ route('saved-address-update-store',['code'=>$code]) }}",
                data: {"_token": "{{ csrf_token() }}",id:id,name:name,
                    phone_number:phone_number,
                    address:address,notes:notes},
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    alert('error!');
                }
            })
        })

        // edit saved address
        $('.edit-saved-address').on('click',function () {
            data = $(this).data('data');
            $("input[name='addressId']").val(data['id']);
            $("input[name='saved_name']").val(data['name']);
            $("input[name='saved_phone']").val(data['phone_number']);
            $("textarea[name='saved_address']").text(data['address']);
            $("textarea[name='saved_notes']").text(data['notes']);
        })

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
        });
    </script>
    </body>
</html>

@endsection
