@include('dashboard')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-6 col-xl-2 col-6">
                <div class="form-group">
                    <label for="productSelect">Product</label>
                    <select class="form-select form-control-sm border-dark" id="productSelect">
                        <option disabled selected>Select Product</option>
                        @foreach ($product as $item)
                            <option value="{{ $item->id }}" data-batch-size="{{ $item->batch_size }}">
                                {{ $item->product_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-xl-2 col-6">
                <div class="form-group">
                    <label for="batchSizeSelect">Batch Size</label>
                    <select class="form-select form-control-sm border-dark" id="batchSizeSelect">
                        <option disabled selected>Select Batch Size</option>
                        <!-- Batch sizes will be populated dynamically -->
                    </select>
                </div>
            </div>
        </div>
            <div id="appendedDiv" class="mb-5">
                <div class="card p-2">
                    <span class="text-center">Please select product</span>
                </div>
            </div>
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Launch demo modal
            </button> -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios"
                                               id="optionsRadios1" value="">
                                        Preduction
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios"
                                               id="optionsRadios1" value="">
                                        LOD Reuse
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios"
                                               id="optionsRadios1" value="">
                                        Scrap
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <button type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
</div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productSelect = document.getElementById('productSelect');
        const batchSizeSelect = document.getElementById('batchSizeSelect');

        productSelect.addEventListener('change', function () {
            // Clear the current batch size options
            batchSizeSelect.innerHTML = '<option disabled selected>Select Batch Size</option>';

            // Get the selected product's batch size
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const batchSize = selectedOption.getAttribute('data-batch-size');

            if (batchSize) {
                // Create a new option element for the batch size
                const option = document.createElement('option');
                option.value = batchSize;
                option.textContent = batchSize;
                batchSizeSelect.appendChild(option);

                // Optionally, select the new batch size if it matches any existing option
                batchSizeSelect.value = batchSize;
            }
        });
    });

    $("#productSelect").change(function () {
        $("#loader").show()
        var id = $(this).val();
        $.ajax({
            url: '{{ route('get.production.data') }}',
            method: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                id: id
            },
            success: function (response) {
                if (response.html) {
                    $("#appendedDiv").html(response.html)
                    $("#loader").hide()
                }
            },
            error: function (response) {
                console.log(response)
                $("#loader").hide()
            }
        })
    })

</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>
