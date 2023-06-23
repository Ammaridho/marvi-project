<div class="card">
  <div class="d-flex justify-content-between flex-grow align-items-center">
    <div><h5 class="card-header">Product List</h5></div>
    <div>
      &nbsp;
    </div>
  </div>
  
  <div class="mx-3 pb-4 table-responsive" id="product-list-fetch">
    @include('arvi.backend.product-list.page-product-list-child')
  </div>

</div>

<script>

  $(document).ready(function(){

    $(document).on('click', '.page-link', function(event){
      event.preventDefault(); 
      var page = $(this).attr('href').split('page=')[1];
      fetch_data(page);
    });

    function fetch_data(page)
    {
      var _token = $("input[name=_token]").val();
      $.ajax({
        url:"{{ route('product-dashboard-paginationfetch',['companyCode' => $companyCode, 'action' => 1]) }}",
        method:"POST",
        data:{_token:_token, page:page},
        success:function(data)
        {
        $('#product-list-fetch').html(data);
        }
      });

    }

  })

</script>
