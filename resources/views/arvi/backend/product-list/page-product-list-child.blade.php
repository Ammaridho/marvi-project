<table class="table table-bordered table-sm table-striped report">
  <thead>
    <tr class="table-primary">
      <th>Product ID</th>
      <th>SKU</th>
      <th>Date Created</th>
      <th>Product Name</th>
      <th>Description</th>
      <th>Retail Price</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody class="table-border-bottom-0">

    @foreach ($products as $item)
      <!-- row data -->  
      <tr>
        <td class="text-center">{{ $item->id }}</td>
        <td class="text-center">{{ $item->sku }}</td>
        <td>{{ date("d-m-Y", strtotime($item->create_time)) }}</td>
        <td>{{ $item->name }}</td>
        <td class="w-50">{{ $item->description }}</td>
        <td class="text-end">{{ $item->currency }}{{ $item->retail_price }}</td>
        <td class="text-center"><span class="badge bg-label-primary me-1">
          {{ $item->active ? "Active" : "Not Active" }}</span>
        </td>
        <td class="text-center">
          <button class="btn btn-sm btn-primary edit-product-modal" data-bs-toggle="modal" 
          data-bs-target="#edit-product-modal" data-item="{{ $item }}">Edit
          </button>
        </td>
      </tr>
      <!-- //row data -->
    @endforeach
        
  </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="edit-product-modal" tabindex="-1" 
aria-labelledby="edit-product-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-product-modalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-edit-product">

        @csrf

        <div class="modal-body">

          <input type="hidden" name="id" value="">

          <div class="mb-3">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" class="form-control" id="sku" name="sku">
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <br>
            <textarea name="description" id="" cols="20" rows="5" style="min-width: 100%"></textarea>
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Product price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price">
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="status" name="status" value="active">
            <label class="form-check-label" for="status">Status Active</label>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="submit-form-edit-product">Save changes</button>
        </div>

      </form>

    </div>
  </div>
</div>

@if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
<!-- paging -->
<div class="mx-3 mt-3 text-end">
  <div class="d-flex justify-content-between align-items-center">
    <div class="d-none d-sm-none d-md-block">Showing {{count($products)}} from {{$countProduct}}</div>
    <div class="d-none d-sm-none d-md-block">
      {!! $products->links() !!}
    </div>
  </div>
</div>
<!-- //paging -->
@endif

<script>
  // open form edit
  $('.edit-product-modal').on('click',function () {
    let data = $(this).data('item');
    $('input[name="id"]').val(data['id']);
    $('input[name="sku"]').val(data['sku']);
    $('input[name="name"]').val(data['name']);
    $('textarea[name="description"]').val(data['description']);
    $('input[name="price"]').val(data['retail_price']);
    if (data['active'] == 1) {
      $('input[name="status"]').prop('checked', true);
    }else{
      $('input[name="status"]').prop('checked', false);
    }
  });

  // submit form edit product
  $('#form-edit-product').on('submit',function () {
    event.preventDefault();
    id = 1;
    $.ajax({
      type: 'POST',
      url: "{{ route('product-edit',['qrCode' => $qrCode]) }}",
      data: $(this).serialize(),
      success: function (data) {
        $('#edit-product-modal').trigger("click");
        $('#product-button').trigger("click");

      },
      error: function (data) {
        console.log(data);
        alert('Masukkan Data dengan Lengkap!');
        console.log(data);
      }
    })
  });
</script>