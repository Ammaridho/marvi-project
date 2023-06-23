@foreach ($ars as $key => $item)
    <tr class="border-bottom text-nowrap">
      <td>{{$item->name}}</td>
      <td>{{$item->file_name}}</td>
      <td><a href="{{$item->ar_url}}" target="_blank">{{$item->ar_url}}</a></td>
      <td>
        <div class="d-flex justify-content-end align-items-center">
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
            <a href="javascript:void(0);" class="btn btn-sm btn-primary edit-ar"
            data-id="{{ $item->id }}">
                <i class="fas fa-pen"></i>
            </a>
          </div>
        </div>
      </td>
    </tr>
@endforeach

<!-- modal confirm -->
<div class="modal fade" id="modalConfirm" tabindex="-1" aria-labelledby="modalConfirm"
aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom pb-3">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
        aria-label="Close"></button>
      </div>
      <div class="modal-body border-bottom pb-3">
        <div>Do you want to set
          <span id="active-status-to-change"></span> ar
          "<span id="confirm-name-ar"></span>"?
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-change-active"
        data-bs-dismiss="modal" data-data="">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  // button edit
  $('.edit-ar').on('click',function () {
      let id = $(this).data('id');
      $.get("{{ route('ar-edit') }}",{id:id},function (data) {
          $('#contentDashboard').html(data);
      })
  })

  // click check active inactive
  $('.flexSwitchCheckChecked').on('click',function () {
    let data = $(this).data('data');
    $('#confirm-name-ar').text(data['name']);
    $('#save-change-active').data('data',data);
    if (data['active'] == 1) {
      $('#active-status-to-change').html('<span class="fw-bold text-danger">inactive</span>');
    } else {
      $('#active-status-to-change').html('<span class="fw-bold text-success">active</span>');
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
      url: "{{ route('ar-update') }}",
      data: {active:active,id:id,"_token": token},
      success: function (data) {
        $('#manage-ar').trigger("click");
      },
      error: function (data) {
        console.log(data);
      }
    })
  })
</script>
