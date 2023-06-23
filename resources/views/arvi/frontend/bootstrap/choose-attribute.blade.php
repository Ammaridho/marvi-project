<h4>Which option of extra like?</h4>
    <div class="mt-3 mb-4">
    @foreach ($Attributes as $item)
    <div class="form-group">
        <label class="option-radio-selection shadow-sm mb-3 inputData arrowDownSm">
            <input class="chooseAttribute arrowDownSm inputData" type="checkbox" 
            name="flav[]" value="{{$item->id}}" />
            <div>{{$item->name}}
                <div class="float-end">+ {{$item->currency}}{{$item->fee}}</div>
            </div>
        </label>
    </div>
    @endforeach
</div>