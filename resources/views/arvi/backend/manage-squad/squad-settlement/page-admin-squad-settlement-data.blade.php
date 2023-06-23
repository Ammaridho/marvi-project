@foreach ($squads as $item)
    <!-- squad -->
    <tr class="border-bottom text-nowrap" id="settlement-list">
        <td>{{$item->name}}</td>
        <td>
            @if ($item->active == 1)
                <span class="badge bg-label-success w-100">
                    active
                </span>
            @else
                <span class="badge bg-label-danger w-100">
                    not active
                </span>
            @endif
        </td>
        <td><span class="badge bg-primary">{{$item->location}}</span></td>
        <td class="text-end">{{$item->balance}}</td>
        <td class="text-end">{{$item->remaining}}</td>
        <td class="text-end">{{$item->total_order}}</td>
        <td>
            @if ($item->settlement_status==0)
                -
            @elseif($item->settlement_status==1)
            <span class="badge bg-label-secondary w-100">requested</span>
            @else
            <span class="badge bg-label-secondary w-100">done</span>
            @endif
        </td>
        <td>
            <a href="javascript:void(0);" class="btn btn-sm btn-primary add-balance" 
            data-bs-toggle="modal" data-bs-target="#modalBalance" 
            data-id="{{$item->id}}">Add balance</a>
            <a href="javascript:void(0);" data-id="{{$item->id}}" 
            class="btn btn-sm btn-primary settlement-detail">Settlement</a>
        </td>
    </tr>
    <!-- //squad -->
@endforeach

<!--
=============================================
Modals
=============================================
-->

<!-- Modal balance -->
<div class="modal fade" id="modalBalance" tabindex="-1" 
aria-labelledby="modalBalance" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title">Set Balance</h5>
        <button type="button" class="btn-close" 
        data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body center p-3">
        <div class="mb-3">
            <label for="balance" class="form-label">Balance</label>
            <input type="number" class="form-control noArrow" 
            name="balance" id="balance" required autocomplete="off" placeholder="...">
            <div id="balanceHelp" class="form-text text-danger d-none">Error message here.</div>
        </div>
        </div>
        <div class="modal-footer border-top pb-2">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="submit-update" class="btn btn-primary" 
        data-id="" data-bs-dismiss="modal">Update</button>
        </div>
    </div>
    </div>
</div>
<!-- //Modal balance -->

<script>
    // open modal balance
    $('.add-balance').on('click',function () {
        id = $(this).data('id');
        $('#submit-update').data('id',id);
    })

    // settlement-detail
    $('.settlement-detail').on('click',function () {
        id = $(this).data('id');
        $.get("{{route('squad-settlement-list-table',['companyCode' => $companyCode])}}",
        {id:id},function (data) {
            $('#contentDashboard').html(data);
        })
    })
</script>