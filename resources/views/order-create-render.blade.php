<?php use App\Models\ProductMaster;
use App\Models\ProductItems;
use App\Models\itemsMaster;
use App\Models\masterCompany;
use App\Models\UomMaster;
?>

<style>
    .table th, .table td {
        padding: -8.75rem 1.9375rem !important;
    }
</style>
<table class="table table-hover" style="font-size: smaller;">
    @foreach ($OrderCreateRender as $item)
        <tr>
            <th>Date : </th>
            <td>{{ $item->date }}</td>
        </tr>
        <tr>
            <th>Name : </th>
            <td>{{ $item->name }}</td>
        </tr>
        <tr>
            <th>Order No : </th>
            <td>{{ $item->order_no }}</td>
        </tr>
        <tr>
            <?php
            $companyName = masterCompany::where('id', $item->customer_name)
                ->pluck('compaey_name')
                ->first();
            ?>
            <th>Customer name : </th>
            <td>{{ $companyName }}</td>
        </tr>
        <tr>
            <th>Contact Person : </th>
            <td>{{ $item->contact_person }}</td>
        </tr>
        <tr>
            <th>Hide : </th>
            <td>
                @if ($item->hide == 1)
                    Yes
                @elseif ($item->hide == 2)
                    No
                @endif
            </td>
        </tr>

        <hr>

        <table class="mt-4 table">
            @foreach ($productOrderRender as $item)
                <tr>
                    <th>Product Name :</th>
                    <?php
                    $productName = ProductMaster::where('id', $item->product)
                        ->pluck('name')
                        ->first();

                    $itemGet = ProductItems::where('product_id', $item->product)->get();
                    ?>
                    <td>
                        {{$productName}}
                    </td>
                </tr>
            @endforeach
        </table>
        <table class="table">
            <tr>
                <th>Item Name</th>
                <th>Resepi Weight</th>
                <th>UOM</th>
            </tr>
            @foreach ($itemGet as $item)
                <tr>
                    <?php
                    $productName = itemsMaster::where('id', $item->item_id)
                        ->pluck('name')
                        ->first();
                    $uom = UomMaster::where('id', $item->uom)
                        ->pluck('name')
                        ->first();
                    ?>
                    <td>{{ $productName }}</td>
                    <td>{{ $item->recipie_weight }}</td>
                    <td>{{ $uom }}</td>
                </tr>
            @endforeach
        </table>
    @endforeach
</table>
