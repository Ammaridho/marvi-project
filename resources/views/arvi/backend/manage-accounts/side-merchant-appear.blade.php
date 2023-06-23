<!-- Merchants -->
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div><h6 class="m-0">Store</h6></div>
        </div>
        <hr>
       
        @php
            $temp_brand_name = '';
        @endphp

        @foreach ($brandAndMerchants as $item)                    

            {{-- formation data input store on account --}}
            @if ($item->brand_name != $temp_brand_name)
                @if ($temp_brand_name != '')
                    <div id="storeSelectHelp" class="form-text text-danger d-none">Error message here.</div>
                </div>
                @endif
                <div class="row mb-3">
                    <div class="col-12"><div class="fw-bold mb-2">{{$item->brand_name}}</div></div>
            @endif
                
                <div class="col-12 col-md-6">
                    <div class="form-check mb-2">
                        <input class="form-check-input choose-merchants" type="checkbox" name="store[]" 
                        value="{{$item->merchant_id}}" id="m-{{$item->merchant_id}}">
                        <label class="form-check-label" for="m-{{$item->merchant_id}}"> 
                            {{$item->merchant_name}} 
                        </label>
                    </div>
                </div>

            @php
                $temp_brand_name = $item->brand_name;
            @endphp

        @endforeach
            <div id="storeSelectHelp" class="form-text text-danger d-none">Error message here.</div>
        </div>

    </div>
</div>

<script>
    $( document ).ready(function() {

        var jArrayStore_id = <?php echo json_encode(json_decode(isset($dataUserStore)?$dataUserStore:'')); ?>;

        if (jArrayStore_id != null) {
            //set checkbox merchants
            let merchants_id = jArrayStore_id;
            merchants_id.forEach(element => {
                $(".choose-merchants:input[value="+element+"]").trigger('click');
            });
        }

    });
</script>