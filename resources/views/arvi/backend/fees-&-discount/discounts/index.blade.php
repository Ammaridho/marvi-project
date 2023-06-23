<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div><h4 class="m-0">Discounts</h4></div>
            <div><a href="javascript:void(0)" class="btn btn-primary" id="add-discount"><i class="tf-icons bx bx-plus"></i> Add discounts</a></div>
        </div>
        <hr>
        
        <div class="table-responsive text-nowrap pb-4" id="table-scroll">
          <table class="table table-borderless">
            <thead>
                <tr>
                    <th class="text-nowrap">Discount Name</th>
                    <th class="">Start Date</th>
                    <th class="">End Date</th>
                    <th class="">Type</th>
                    <th class="">Value</th>
                    <th class="text-nowrap">Minimum Purchase</th>
                    <th class="">Rules</th>
                    <th class="w-100">Discount code</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- discounts -->
                <tr>
                    <td class="fw-bold">Promo B1G1</td>
                    <td class="text-nowrap">12 / 08 / 2022</td>
                    <td class="text-nowrap">12 / 12 / 2022</td>
                    <td class="text-nowrap">Percentage</td>
                    <td class="text-nowrap">10%</td>
                    <td class="text-nowrap">IDR 100.000</td>
                    <td class="text-nowrap">No rules</td>
                    <td class="text-nowrap">No discount code</td>
                    <td class="text-nowrap">
                        <div class="d-flex justify-content-end">
                            <div class="me-3 mt-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input btn-checkbox" type="checkbox" checked="checked" id="statuse1" value="01">
                                    <label class="form-check-label" for="statuse1">Active</label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="mx-2"><a href="page-discount-add.php" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a></div>
                                <div class=""><a href="javascript:void(0)" class="btn btn-sm btn-primary"><i class='bx bx-trash-alt' ></i></a></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- //discounts -->
                <!-- discounts -->
                <tr>
                  <td class="fw-bold">Promo GOPAY</td>
                  <td class="text-nowrap">12 / 08 / 2022</td>
                    <td class="text-nowrap">12 / 12 / 2022</td>
                    <td class="text-nowrap">Amount</td>
                    <td class="text-nowrap">IDR 10.000</td>
                    <td class="text-nowrap">IDR 100.000</td>
                    <td class="text-nowrap">Free product</td>
                    <td class="text-nowrap">Unique code</td>
                    <td class="text-nowrap">
                        <div class="d-flex">
                            <div class="me-3 mt-1">
                                <div class="form-check form-switch">
                                    <input class="form-check-input btn-checkbox" type="checkbox" id="statuse2" value="01">
                                    <label class="form-check-label" for="statuse2">Not active</label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="mx-2"><a href="page-discount-add.php" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a></div>
                                <div class=""><a href="javascript:void(0)" class="btn btn-sm btn-primary"><i class='bx bx-trash-alt' ></i></a></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- //discounts -->
              
            </tbody>
          </table>
        </div>
        
    </div>
</div>

<script src="/arvi/backend-assets/js/demo.js"></script>

<script>
    $('#add-discount').on('click',function () {
        $.get("{{route('discount-create',['companyCode' => $companyCode])}}",function (data) {
            $('#contentDashboard').html(data);
        })
    });
</script>