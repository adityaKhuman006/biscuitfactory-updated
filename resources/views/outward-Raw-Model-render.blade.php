<table>
    <tr>
        <td>
            <a href="{{ asset('public/img/' . $outwardRawMaterial->img) }}" target="_blank">
                <img src="{{ asset('public/img/' . $outwardRawMaterial->img) }}" style="width: 50px; height: 50px;"
                    alt="Profile" class="rounded-circle">
            </a>
        </td>
    </tr>

    <tr>
        <th>Compaey Name : </th>
        <td>{{ $outwardRawMaterial->compaey_name }}</td>
    </tr>
    <tr>
        <th>Location : </th>
        <td>{{ $outwardRawMaterial->location }}</td>
    </tr>
    <tr>
        <th>Data : </th>
        <td>{{ $outwardRawMaterial->date }}</td>
    </tr>
    <tr>
        <th>Time : </th>
        <td>{{ $outwardRawMaterial->time }}</td>
    </tr>
    <tr>
        <th>INV Challan Number : </th>
        <td>{{ $outwardRawMaterial->inv_challan_number }}</td>
    </tr>
    <tr>
        <th>INV Challan Date : </th>
        <td>{{ $outwardRawMaterial->inv_challan_date }}</td>
    </tr>
    <tr>
        <th>Vehicle Number : </th>
        <td>{{ $outwardRawMaterial->vehicle_number }}</td>
    </tr>
</table>



<table class="table mt-5 text-center">
    <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>UOM</th>
        <th>Rate</th>
        <th>Amount</th>
    </tr>
    @foreach ($outwardRawMaterialitem as $item)
        <tr>
            <td>{{$item->item}}</td>
            <td>{{$item->quantity}}</td>
            <td>{{$item->uom}}</td>
            <td>{{$item->rate}}</td>
            <td>{{$item->amount}}</td>
        </tr>
    @endforeach

</table>
