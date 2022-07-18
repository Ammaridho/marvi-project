<div class="row">

    <div class="scrollable">
    
        <table class="table table-bordered table-hover">
            <thead>

                <tr class="sticky-top bg-dark text-white">
                    <th>Create Date</th>
                    <th>Product Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>SKU</th>
                    <th>Retail Price</th>
                    <th>Active</th>
                </tr>
                
            </thead>
            <tbody>

                @foreach ($products as $item)
                <tr>
                    <td>{{ date("d-m-Y", strtotime($item->create_time)) }}</td>
                    <td>{{ $item->id }}</td>
                    <td class="align-left">{{ $item->name }}</td>
                    <td class="align-left">{{ $item->description }}</td>
                    <td>{{ $item->sku }}</td>
                    <td>{{ $item->currency }}{{ $item->retail_price }}</td>
                    <td>{{ $item->active ? "Ready" : "Not Ready" }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
        
    </div>
    
</div>