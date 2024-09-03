<table>
    @foreach($materials as $material)
    <tr>
        <td><span class="p-3 fw-bolder"> {{ $material->getMaterial[0]->item_name}}</span></td>
        <td>:</td>
        <td><span class="p-3">{{ $material->actual_weight }}</span></td>
    </tr>
    @endforeach
</table>
