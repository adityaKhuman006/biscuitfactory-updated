@include('dashboard')

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css"> -->


<div class="main-panel ">
    <div class="content-wrapper p-2">
        <div class="card">
            <h2 class="p-2">Get-Out-Report</h2>
            <div class="container p-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Items</label>
                            <select class="form-select form-control-sm border-dark" id="rawSelect">
                                <option value="" selected disabled>Select</option>
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
                </div>
                <table id="example" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Compaey Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>mobile</th>
                            <th>location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="rawMaterial">

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

    $(document).ready(function() {
        $("#rawSelect").change(function() {
            $("#loader").show();
            var name = $(this).val();
            // alert(name);

            $.ajax({
                url: '{{ route('out.raw.fatch') }}',
                method: 'POST',
                data: {
                    name: name,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#rawMaterial').html(response.html);
                    $("#loader").hide();
                },
                error: function(response) {
                    // alert(response);
                }
            })
        })
    })

    $(document).on('click', '.viewReport', function() {
        $("#loader").show();

        var id = $(this).attr('id');
        var outRawId = $(this).attr('data-raw-id');

        // alert(outRawId);

        $.ajax({
            url: '{{ route('out.get.fatch') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                outRawId: outRawId
            },
            success: function(response) {
                if (response.html) {
                    $("#viewReportModal").modal('show');
                    $("#reportData").html(response.html);
                }
                $("#loader").hide();
            },
            error: function(response) {
                console.error('Error:', response);
                $("#loader").hide();
            }
        });
    });
</script>
</body>

</html>
