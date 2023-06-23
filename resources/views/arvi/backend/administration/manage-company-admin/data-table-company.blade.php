@foreach ($companies as $item)
    <!-- company -->
    <tr class="border-bottom text-nowrap" id="company-list">
        <th>{{ $item->name }}</th>
        <td class="fw-bold">{{ $item->email }}</td>
        <td>{{ $item->phone_number }}</td>
        <td>{{ $item->street_address}}</td>
        <td>
            @php
                $status = isset($item->status)?$item->status:'kosong';
            @endphp
            @if ($status == 'rejected')
                <span class="badge bg-label-danger w-100">Rejected</span>
            @elseif($status == 'approved')
                <span class="badge bg-label-success w-100">Approved</span>
            @else
                <span class="badge bg-label-warning w-100">in review</span>
            @endif
        </td>
        <td>
            <div class="d-flex justify-content-end align-items-center">
                <div class="form-check form-switch me-3">
                    <script>
                        var companyActive = "{{$item->active}}";
                        if (companyActive == '1') {
                            $("#status-{{$item->id}}").prop('checked', true);
                        }else{
                            $("#status-{{$item->id}}").prop('checked', false);
                        }
                    </script>
                    <input class="form-check-input btn-checkbox active-user" 
                        type="checkbox" id="status-{{$item->id}}" data-id="{{$item->id}}" value="1">
                    <label class="form-check-label" for="status-{{$item->id}}">
                        {{$item->active == 1 ? 'active' : 'inactive'}}
                    </label>
                </div>
                <div class="mx-2">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary edit-company"
                    data-data="{{ $item }}">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
            </div>
        </td>
    </tr>
    <!-- //company -->
@endforeach