@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="card p-2">
                <div class="col-12">
                    <h3 class="fw-bold p-2">Pack Master</h3>

                    <div class="card-body pt-10 ">
                        <form method="POST" action="{{ route('pack.masters.edit') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $packMaster->id }}">
                            <div class="repeater">
                                <h4 class="card-title">Raw Material</h4>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Pack Name</label>
                                            <input type="text" value="{{ $packMaster->pack_name }}" name="pack_name"
                                                required class="form-control form-control-sm border-black"
                                                placeholder="Pack Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Pack Weight</label>
                                            <input type="text" value="{{ $packMaster->pack_weight }}"
                                                name="pack_weight" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="Pack Weight">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Pack Weight Uom</label>
                                            <select name="pack_weight_uom"
                                                class="form-select update-weight1 form-control-sm border-dark"
                                                id="batchSizeSelect">
                                                <option selected disabled>Choose an uom</option>
                                                @foreach ($uom as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>No PF Packet Polybag</label>
                                            <input type="text" value="{{ $packMaster->no_pf_packet_polybag }}"
                                                name="no_pf_packet_polybag" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="No PF Packet Polybag">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Packet Polybag Uom</label>
                                            <select name="packet_polybag_uom"
                                                class="form-select update-weight2 form-control-sm border-dark" id="batchSizeSelect">
                                                <option selected disabled>Choose an uom</option>
                                                @foreach ($uom as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>No Of Polybag In Cartoon</label>
                                            <input type="text" value="{{ $packMaster->no_of_polybag_in_cartoon }}"
                                                name="no_of_polybag_in_cartoon" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="No Of Polybag In Cartoon">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>No Of Cartoon</label>
                                            <input type="text" value="{{ $packMaster->no_of_cartoon }}"
                                                name="no_of_cartoon" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="No Of Cartoon">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>No Of Cartoon Uom</label>
                                            <select name="no_of_cartoon_uom"
                                                class="form-select update-weight3 form-control-sm border-dark" id="batchSizeSelect">
                                                <option selected disabled>Choose an uom</option>
                                                @foreach ($uom as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Weight Of Cartoon</label>
                                            <input type="text" value="{{ $packMaster->weight_of_cartoon }}"
                                                name="weight_of_cartoon" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="Weight Of Cartoon">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Weight Of Cartoon Uom</label>
                                            <select name="weight_of_cartoon_uom"
                                                class="form-select update-weight4 form-control-sm border-dark" id="batchSizeSelect">
                                                <option selected disabled>Choose an uom</option>
                                                @foreach ($uom as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Loading In Container</label>
                                            <input type="text" value="{{ $packMaster->loading_in_container }}"
                                                name="loading_in_container" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="Loading In Container">
                                        </div>
                                    </div>

                                    <h4 class="card-title">Packing Material</h4>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Wrapper Qty</label>
                                            <input type="text" value="{{ $packMaster->wrapper_qty }}"
                                                name="wrapper_qty" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="Wrapper Qty">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Poly Bag Qty</label>
                                            <input type="text" value="{{ $packMaster->poly_bag_qty }}"
                                                name="poly_bag_qty" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="Poly Bag Qty">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Box Qty</label>
                                            <input type="text" value="{{ $packMaster->box_qty }}" name="box_qty"
                                                required class="form-control form-control-sm border-black"
                                                placeholder="Box Qty">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tape Qty</label>
                                            <input type="text" value="{{ $packMaster->tape_qty }}"
                                                name="tape_qty" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="Tape Qty">
                                        </div>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Master Type</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mt-4 mb-4">
                are you sure you want to delete?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                <button type="button" id="deleteItem" class="btn btn-danger text-white">Delete</button>
            </div>
        </div>
    </div>
</div>

@include('footer')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('.update-weight1').select2({
        placeholder: 'select '
    });

    $('.update-weight2').select2({
        placeholder: 'select '
    });

    $('.update-weight3').select2({
        placeholder: 'select '
    });

    $('.update-weight4').select2({
        placeholder: 'select '
    });
</script>
<!-- partial:partials/_footer.html -->
</body>

</html>
{{-- @endsection --}}
