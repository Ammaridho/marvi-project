@foreach ($qrs as $key => $item)
    <tr class="border-bottom text-nowrap">
      <td class="text-end">{{$key+1}}</td>
      <th>{{$item->name}}</th>
      <th>{{$item->merchant->name}}</th>
      <td class="text-end text-center">
        @if ($item->qr_type == 0)
            Digital Menu
        @else
            AR
        @endif
      </td>
      <td>{{$item->qr_url}}</td>
      <td class="text-center">
        <div class="d-flex justify-content-end align-items-center text-center">
          
          @if (isset($item->image_poster))
            <div class="mx-2 text-center">
              <a href="{!! route('poster-download', ['id' => $item->id]) !!}" 
                class="btn btn-sm btn-primary download-qr">Download QR</a>
            </div>
            <div class="mx-2 text-center">
              <a href="javascript:void(0);" class="btn btn-sm 
              btn-primary custom-layout-qr"
                data-id="{{ $item->id }}">Update QR Layout</a>
            </div>
          @else
            <div class="d-flex mx-2 text-center">
              <a href="javascript:void(0);" class="btn btn-sm 
              btn-primary custom-layout-qr"
              data-id="{{ $item->id }}">Set Poster QR Layout</a>
            </div>
          @endif
            
        </div>
      </td>
      <td>
        <div class="d-flex justify-content-end align-items-center text-center">
          <script>
            var active = "{{$item->active}}";
            if (active == '1') {
              $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', true);
            }else{
              $("#flexSwitchCheckChecked{{$item->id}}").prop('checked', false);
            }
          </script>
          <div class="form-check form-switch me-3">
            <input class="form-check-input flexSwitchCheckChecked"
            type="checkbox" id="flexSwitchCheckChecked{{$item->id}}"
            data-data="{{$item}}">
            <label class="form-check-label">
              {{$item->active == 1 ? 'active' : 'inactive'}}
            </label>
          </div>
          <div class="mx-2">
            <a href="javascript:void(0);" 
            class="btn btn-sm btn-primary edit-qr"
            data-id="{{ $item->id }}">
                <i class="fas fa-pen"></i>
            </a>
          </div>
          <div class="mx-2">
            <a href="javascript:void(0);" 
            class="btn btn-sm btn-danger remove-qr"
            data-id="{{$item->id}}">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </div>
      </td>
    </tr>
@endforeach

<!-- modal confirm -->
<div class="modal fade" id="modalConfirm" 
tabindex="-1" aria-labelledby="modalConfirm"
aria-hidden="true" data-bs-backdrop="static" 
data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
        aria-label="Close"></button>
      </div>
      <div class="modal-body border-bottom pb-3">
        <div>Do you want to set
          <span id="active-status-to-change"></span> qr
          "<span id="confirm-name-qr"></span>"?
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" 
        data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" 
        id="save-change-active"
        data-bs-dismiss="modal" data-data="">Save changes</button>
      </div>
    </div>
  </div>
</div>

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
            <div class="modal-body center p-3 text-center">
                <h4>Are you sure you want to delete this QR?</h4>
            </div>
            <div class="modal-footer border-top pb-2">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-delete" 
                data-bs-dismiss="modal" data-id="">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>

  // delete
  $(".remove-qr").on('click',function(){
    let id = $(this).data('id');
    $('#submit-delete').data('id',id);
    // show modal
    $('#modaldDefaultDelete').modal('show');
  }); 
  $('#submit-delete').on('click',function () {
    let id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
      type: 'DELETE',
      url: "{{ route('qr-destroy') }}",
      data: {
          "id": id,
          "_token": token,
      },
      success: function (){
        $('#manage-qr').trigger('click');
      },
      error: function () {
          console.log(data);
      }
    });
  })

  // button edit
  $('.custom-layout-qr').on('click',function () {
      let id = $(this).data('id');
      $.get("{{ route('poster-qr-form-custom-layout') }}",
      {id:id},function (data) {
          $('#contentDashboard').html(data);
      })
  })

  // button edit
  $('.edit-qr').on('click',function () {
      let id = $(this).data('id');
      $.get("{{ route('qr-edit') }}",{id:id},function (data) {
          $('#contentDashboard').html(data);
      })
  })

  // click check active inactive
  $('.flexSwitchCheckChecked').on('click',function () {
    let data = $(this).data('data');
    $('#confirm-name-qr').text(data['name']);
    $('#save-change-active').data('data',data);
    if (data['active'] == 1) {
      $('#active-status-to-change').
      html('<span class="fw-bold text-danger">inactive</span>');
    } else {
      $('#active-status-to-change').
      html('<span class="fw-bold text-success">active</span>');
    }
    // show modal
    $('#modalConfirm').modal('show');
    // check old status active
    // if not checked ============================================================
    if($(this).is(":checked")){
      $(this).prop('checked', false);
    // if checked ============================================================
    }else if($(this).is(":not(:checked)")){
      $(this).prop('checked', true);
    }
  })

  // save switch check active inactive
  $('#save-change-active').on('click',function () {
    let data = $(this).data('data');
    let active = data['active'] == '1' ? '0': '1' ;
    let id = data['id'];
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
      type: 'PUT',
      url: "{{ route('qr-update') }}",
      data: {active:active,id:id,"_token": token},
      success: function (data) {
        $('#manage-qr').trigger("click");
      },
      error: function (data) {
        console.log(data);
      }
    })
  })
</script>
