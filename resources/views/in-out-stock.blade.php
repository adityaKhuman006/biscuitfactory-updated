@include('dashboard')

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css"> -->

<div class="main-panel ">
    <div class="content-wrapper p-2">
        <div class="card">
            <h2 class="p-2">Stock</h2>
            <div class="container p-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select material</label>
                            <select class="form-select form-control-sm border-dark rawSelectClass" id="rawSelect">
                                <option value="" selected disabled>Select material</option>
                                <option value="{{ \App\Models\outwardRawMaterial::RAW_MATERIAL }}">Raw-material</option>
                                <option value="{{ \App\Models\outwardRawMaterial::PACKING_MATERIAL }}">Packing Material
                                </option>
                                <option value="{{ \App\Models\outwardRawMaterial::MACHINERY_ITEM }}">Machinery items
                                </option>
                                <option value="{{ \App\Models\outwardRawMaterial::FINISH_GOOD }}">Finish good</option>
                                <!-- Batch sizes will be populated dynamically -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" id="itemsDiv" style="display: none;">
                            <label>Items</label>
                            <select class="form-select form-control-sm border-dark" id="transferReaport">
                                <option selected disabled>Select an item</option>
                                @foreach ($raw as $item)
                                    <option value="{{ $item->id }}">{{ $item->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <table id="example" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Available Stock</th>
                            {{-- <th>UOM</th>
                            <th>Rate</th>
                            <th>Amount</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="transferReaportData">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">All Data</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="reportData">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    $(document).on('change', '.rawSelectClass', function() {
        $('#itemsDiv').show();
    })


    $(document).ready(function() {
        $("#transferReaport").change(function() {
            $("#loader").show();
            var materialId = $('#rawSelect').val();
            // alert(matirialId);
            var id = $(this).val();

            $.ajax({
                url: '{{ route('in.out.stock.data') }}',
                method: 'POST',
                data: {
                    materialId: materialId,
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.message === 'No data available') {
                        $('#transferReaportData').html('<p>No data available</p>');
                    } else {
                        $('#transferReaportData').html(response.html);
                    }
                    $("#loader").hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred. Please try again.');
                    $("#loader").hide();
                }
            });
        });
    });


    $(document).on('click', '.viewReport', function() {
        $("#loader").show();
        var item_id = $(this).attr('data-id');
        var materialId = $('#rawSelect').val();
        var selectId = $('#transferReaport').val();
        // alert(selectId);

        $.ajax({
            url: '{{ route('in.out.stock.rendar') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                item_id: item_id,
                materialId: materialId,
            },
            success: function(response) {
                if (response.html) {
                    $("#viewReportModal").modal('show');
                    $("#reportData").html(response.html);
                    $("#loader").hide();
                }
            },
            error: function(response) {
                console.log(response);
                $("#loader").hide();
            }
        });
    });
</script>
</body>

</html>
