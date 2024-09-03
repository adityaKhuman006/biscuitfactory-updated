<tr>
    <td>{{ $product->product_name }}</td>
    <td>{{ (float)$netQuantity }}</td>
    {{-- <td>{{ (float)$netUom }}</td>
    <td>{{ (float)$netRate }}</td>
    <td>{{ (float)$netAmount }}</td> --}}
    <td>
        <button data-id="{{$product->id}}"
            class="btn btn-outline-primary fw-bolder viewReport"><i class="mdi mdi-eye"></i>
        </button>
    </td>
</tr>
