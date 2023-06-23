@foreach ($users as $user)
<!-- user -->
<tr class="border-bottom text-nowrap" id="account-list">
    <td>{{$user->name}}</td>
    <td class="fw-bold">{{$user->email}}</td>
    <td class="fw-bold">{{$user->phone_number}}</td>
    <td>
        @foreach ($user->companies as $companies)
            
        <span class="badge bg-primary">{{$companies->name}}</span> 
        @endforeach
    </td>
    <td>
        @foreach ($user->brands as $brands)
            <span class="badge bg-primary">{{$brands->name}}</span>
        @endforeach
    </td>
    <td>
        @if ($user->store_id != null)

            @php
            $a = '';
            @endphp

            @foreach (json_decode($user->store_id) as $key => $im)
                <span class="badge bg-primary">
                    {{isset($merchant[$im]) ? $merchant[$im] : '' }}
                </span>
            @endforeach

        @else
            please set store!
        @endif
    </td>
    <td>
        @if ($user->role != null)
            {{$user->role}}
        @else
            please set role!
        @endif
    </td>
    <td>
        @if ($user->last_login != null)
            {{$user->last_login}}
        @else
            -
        @endif
    </td>
    <td class="text-nowrap">
        <div class="d-flex justify-content-end">
            <div class="form-check form-switch me-3">
                <script>
                    var userActive = "{{$user->active}}";

                    if (userActive == '1') {
                        $("#status-{{$user->id}}").prop('checked', true);
                    }else{
                        $("#status-{{$user->id}}").prop('checked', false);
                    }
                </script>
                <input class="form-check-input btn-checkbox active-user" 
                    type="checkbox" id="status-{{$user->id}}" data-id="{{$user->id}}" value="1">
                <label class="form-check-label" for="status-{{$user->id}}">
                    {{$user->active == 1 ? 'active' : 'inactive'}}
                </label>
            </div>
            <div class="mx-2"><a href="javascript:void(0)" data-data="{{ $user }}" 
                class="btn btn-sm btn-primary edit-account"><i class="fas fa-pen"></i></a>
            </div>
        </div>
    </td>
</tr>
<!-- //user -->
@endforeach
