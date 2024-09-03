<h5 class="text-secondary text-center mt-3">In Ward Item Details</h5>

<table class="table">
    <tr>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>UOM</th>
        <th>Rate</th>
        <th>Amount</th>
    </tr>
    @forelse ($inwardItems as $items)
        <tr>
            <td>{{ $items->item }}</td>
            <td>{{ $items->quantity }}</td>
            <td>{{ $items->uom }}</td>
            <td>{{ $items->rate }}</td>
            <td>{{ $items->amount }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="2">No data available</td>
        </tr>
    @endforelse
</table>




<h5 class="text-secondary text-center mt-5">Out Ward Item Details</h5>
<table class="table">
    <tr>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>UOM</th>
        <th>Rate</th>
        <th>Amount</th>
    </tr>
    @forelse ($outwardItems as $items)
        <tr>
            <td>{{ $items->item }}</td>
            <td>{{ $items->quantity }}</td>
            <td>{{ $items->uom }}</td>
            <td>{{ $items->rate }}</td>
            <td>{{ $items->amount }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="2">No data available</td>
        </tr>
    @endforelse
</table>


<h5 class="text-secondary text-center mt-5">Prodcution Details</h5>
<table class="table">
    <tr>
        <th>Production Name</th>
        <th>Material Name</th>
        <th>actual_weight</th>
        <th>Batch_number</th>
    </tr>
    @forelse ($materials as $items)
        <tr>
            <td>{{ $items->getProduct[0]->product_name }}</td>
            <td>{{ $items->getMaterial[0]->item_id }}</td>
            <td>{{ $items->actual_weight}}</td>
            <td>{{ $items->batch_number }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="2">No data available</td>
        </tr>
    @endforelse
</table>
