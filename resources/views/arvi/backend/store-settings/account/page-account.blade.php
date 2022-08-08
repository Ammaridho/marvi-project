<div class="row justify-content-start">
    <div class="col-lg-2 col-md-2 col-12 mb-3">
        <div class="fw-bold">Account information</div>
        <div>The details will only be used for communication between Oobe and your business. 
            Customers will not see this information.</div>
    </div>
    <div class="col-lg-7 col-md-8 col-12">
    
        <!-- -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h4 class="m-0"><span class="text-muted">Store Settings</span> / Account</h4></div>
                    <div><a href="javascript:void(0)" class="btn btn-primary" id="add-account">
                        <i class="tf-icons bx bx-plus"></i> Add account</a>
                    </div>
                </div>
                <hr>

                <div class="mb-3">
                    <form class="search" onsubmit="return false">
                    <input class="form-control form-control-custom me-2" type="search" id="input-search" 
                    placeholder="Username/Id_store/Role" aria-label="Search" autocomplete="off" />
                    <button type="reset">&times;</button>
                    </form>
                </div>

                <div class="table-responsive ">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Username</th>
                                <th class="">Store</th>
                                <th class="">Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody-account-list">
                            <!-- user -->
                            @foreach ($user as $item)
                                <tr id="account-list">
                                    <td class="fw-bold">{{$item->email}}</td>
                                    <td>
                                        @if ($item->store_id != null)
                                            @php
                                            $a = '';
                                            foreach(json_decode($item->store_id) as $key => $im){
                                                if ($key!=0) {
                                                    $a .= ', ';
                                                }
                                                $a .= $merchants[$im-1];
                                            }    
                                            @endphp 
                                            {{$a}}
                                        @else
                                            please set store!
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->role != null)
                                        {{$item->role}}
                                        @else
                                            please set role!
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="d-flex justify-content-end">
                                            <div class="mx-2"><a href="javascript:void(0)" data-data="{{ $item }}" 
                                                class="btn btn-sm btn-primary edit-account"><i class="fas fa-pen"></i></a>
                                            </div>
                                            <div class=""><a href="javascript:void(0)" data-id="{{ $item->id }}" 
                                                class="btn btn-sm btn-primary delete-account"><i class='bx bx-trash-alt' ></i></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- //user -->-
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!-- // -->
    </div>
</div>


<script>
    // search order
    $("#input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbody-account-list tr#account-list").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // button openform add account
    $('#add-account').on('click',function () {
        $.get("{{route('account-form',['qrCode' => $qrCode])}}",function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // button open form edit account
    $('.edit-account').on('click',function () {
        dataUser = $(this).data('data');
        $.get("{{route('account-from-update',['qrCode' => $qrCode])}}",
            {dataUser:dataUser},function (data) {
            $('#contentDashboard').html(data);
        })
    })

    // delete
    $(".delete-account").on('click',function(){

        conf = confirm('delete?');

        if (conf) {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
        
            $.ajax({
                type: 'DELETE',
                url: "{{ route('account-delete',['qrCode' => $qrCode]) }}",
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    alert('delete success!');
                    $('#account-button').trigger("click");
                }
            });
            
        }
    
    });

    
</script>
