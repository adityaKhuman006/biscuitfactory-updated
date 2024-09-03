

@foreach ($transferReaport as $items)
    <tr>
        <td>{{$items->item}}</td>
        <td>{{$items->quantity}}</td>
        <td>{{$items->uom}}</td>
        <td>{{$items->from}}</td>
        <td>{{$items->to}}</td>
        <td>{{$items->person}}</td>
        <td>{{$items->remark}}</td>
    </tr>
@endforeach
