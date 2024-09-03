@include('dashboard')

<?php
$currentRouteName = 'transfer.reaport';
?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css"> -->


<div class="main-panel ">
    <div class="content-wrapper p-2">
        <div class="card">
            <h2 class="p-2">Get-In-Report</h2>
            <div class="container p-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Items</label>
                            <select class="form-select form-control-sm border-dark" id="transferReaport">
                                <option selected disabled>Select an item</option>
                                @foreach ($raw as $items)
                                    <option value="{{ $items->product_name }}">{{ $items->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <table id="example" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            {{-- <th>Date</th>
                            <th>Time</th>
                            <th>Image</th> --}}
                            <th>Items</th>
                            <th>Quantity</th>
                            <th>UOM</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Person</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody id="transferReaportData">

                    </tbody>
            </div>
        </div>
    </div>
</div>
@include('footer')

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });



    $(document).ready(function() {
        $("#transferReaport").change(function() {
            $("#loader").show();

            var product_name = $(this).val();

            $.ajax({
                url: '{{ route('transfer.Reaport.Data') }}',
                method: 'POST',
                data: {
                    product_name: product_name,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#transferReaportData').html(response.html);
                    $("#loader").hide();
                },
                error: function(response) {
                    alert('No Data');
                    $("#loader").hide();
                }
            });
        });
    });
</script>
</body>

</html>
