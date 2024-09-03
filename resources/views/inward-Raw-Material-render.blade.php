@foreach ($outwardRawMaterial as $item)
    <tr>
        <td>{{$item->compaey_name}}</td>
        <td>{{$item->date}}</td>
        <td>{{$item->time}}</td>
        <td>{{$item->mobile}}</td>
        <td>{{$item->location}}</td>
        <td>
            <button id="{{$item->id}}" data-raw-id="{{ $outRawId }}"
                class="btn btn-outline-primary fw-bolder viewReport"><i class="mdi mdi-eye"></i>
            </button>
        </td>
    </tr>
@endforeach
