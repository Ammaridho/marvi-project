<div class="card">
  <div class="d-flex justify-content-between flex-grow align-items-center">
    <div><h5 class="card-header">Product List</h5></div>
    <div>
      &nbsp;
    </div>
  </div>
  
  <div class="mx-3 pb-4 table-responsive">
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
            <td><span class="badge bg-label-primary me-1">{{ $item->active ? "Active" : "Not Active" }}</span></td>
          </tr>
          <!-- //row data -->
        @endforeach
            
      </tbody>
    </table>
  </div>

  <!-- paging -->
  <div class="mx-3 mt-3 text-end">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-none d-sm-none d-md-block">Showing 7 from 7</div>
        <div class="d-none d-sm-none d-md-block">
          <nav>
              <ul class="pagination justify-content-end">
                  <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                  <li class="page-item"><a class="page-link p-2" href="#"><i class="bx bx-chevron-left"></i></a></li>
                  <li class="page-item"><a class="page-link p-2" href="#"><i class="bx bx-chevron-right"></i></a></li>
              </ul>
          </nav>
        </div>
        <div class="d-block d-sm-block d-md-none">
          <nav>
              <ul class="pagination justify-content-end">
                  <li class="page-item"><a class="page-link p-2" href="#">Previous</a></li>
                  <li class="page-item"><a class="page-link p-2" href="#">Next</a></li>
              </ul>
          </nav>
        </div>
      </div>
  </div>
  <!-- //paging -->

</div>
