<!-- Brands -->
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div><h6 class="m-0">Brand *</h6></div>
        </div>
        <hr>
       
        @php
            $temp_company_name = '';
        @endphp

        @foreach ($companyAndBrands as $item)                    

            {{-- formation data input brand on account --}}
            @if ($item->company_name != $temp_company_name)
                @if ($temp_company_name != '')
                    <div id="brandSelectHelp" class="form-text text-danger d-none">Error message here.</div>
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-12"><div class="fw-bold mb-2">{{$item->company_name}}</div></div>
            @endif
                
                <div class="col-12 col-md-6">
                    <div class="form-check mb-2">
                        <input class="form-check-input choose-brands" type="checkbox" name="brand[]" 
                        value="{{$item->brand_id}}" id="b-{{$item->brand_id}}">
                        <label class="form-check-label" for="b-{{$item->brand_id}}"> 
                            {{$item->brand_name}} 
                        </label>
                    </div>
                </div>

            @php
                $temp_company_name = $item->company_name;
            @endphp

        @endforeach
            <div id="brandSelectHelp" class="form-text text-danger d-none">Error message here.</div>
        </div>

    </div>
</div>

<script>
    var jArrayBrand_id = <?php echo json_encode(json_decode(isset($dataRelationBrands)?$dataRelationBrands:'')); ?>;

    // merchant appear
    $('.choose-brands').on('click',function () {
        // check brand in check
        checkedBrands = $('.choose-brands:checkbox:checked').map(function(){
        return $(this).val();
        }).get();
        
        if (jQuery.isEmptyObject(checkedBrands)) {
            $('#merchant-appear').html('');
        }else{
            if (jArrayBrand_id != null) {
                idUser = {!! json_encode(isset($idUser) ? $idUser : "") !!};
                $.get("{{route('account-admin-create-merchant-appear',['companyCode' => $companyCode])}}",
                {checkedBrands:checkedBrands,idUser:idUser},function (data) {
                    $('#merchant-appear').html(data);
                })
                } else {
                $.get("{{route('account-admin-create-merchant-appear',['companyCode' => $companyCode])}}",
                {checkedBrands:checkedBrands},function (data) {
                    $('#merchant-appear').html(data);
                })
            }
        }
    })

    $( document ).ready(function() {

        if (jArrayBrand_id != null) {
            //set checkbox merchants
            let brands_id = jArrayBrand_id;
            brands_id.forEach(element => {
                $(".choose-brands:input[value="+element+"]").trigger('click');
            });
        }

    })

</script>