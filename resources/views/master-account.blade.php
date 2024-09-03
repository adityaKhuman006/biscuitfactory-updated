@include('dashboard')
@include('dashboard')
<style>
    .select2-container {
        width: 244px !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="card p-2">
                <div class="col-12">
                    <h3 class="fw-bold p-2">Type Master</h3>
                    <div class="table-responsive">
                        <table class="table table-hover tab-pane">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($account as $key => $item)
                                <tr class="removeble-tr-{{ $item->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <input type="text" class="border-0 update-name" data-id='{{ $item->id }}'
                                            value="{{ $item->name }}">
                                    </td>
                                    <td>
                                        <input type="text" class="border-0 update-address"
                                            data-id='{{ $item->id }}' value=" {{ $item->address }}">
                                    </td>
                                    <td>
                                        <select name="type" class="update-type w-75" data-id='{{ $item->id }}'
                                            class="form-control update-type">
                                            <option
                                                {{ $item->type == \App\Models\masterAccount::CUSTOMER ? 'selected' : '' }}
                                                value="{{ \App\Models\masterAccount::CUSTOMER }}">Custome</option>
                                            <option
                                                {{ $item->type == \App\Models\masterAccount::EMPLOYE ? 'selected' : '' }}
                                                value="{{ \App\Models\masterAccount::EMPLOYE }}">Employe</option>
                                            <option
                                                {{ $item->type == \App\Models\masterAccount::VENDOR ? 'selected' : '' }}
                                                value="{{ \App\Models\masterAccount::VENDOR }}">Vendor</option>
                                            <option
                                                {{ $item->type == \App\Models\masterAccount::OTHER ? 'selected' : '' }}
                                                value="{{ \App\Models\masterAccount::OTHER }}">Other</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" delete-id='{{ $item->id }}'
                                            class="btn btn-danger add-item delete-items"
                                            style="padding:4px 5px 3px 5px;"><i
                                                class="fs-5 text-white mdi mdi-delete"></i></button>
                                    </td>
                            @endforeach
                            </tr>
                        </table>
                    </div>

                    <div class="card-body pt-10 ">
                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('master.account.create') }}">
                            @csrf
                            <!-- <div class="border border-5 m-3" style="margin-left: 0 !important;"></div> -->
                            <div class="repeater">
                                <div data-repeater-list="category-group">
                                    <h4 class="card-title">Create</h4>
                                    <div id="show_item">
                                        <div class="row mt-3" data-repeater-item>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name" required
                                                        class="form-control form-control-sm border-black"
                                                        placeholder="Enter Short Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" name="address" required
                                                        class="form-control form-control-sm border-black"
                                                        placeholder="Enter Full Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select name="type" class="form-control uom-select" required>
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="{{ \App\Models\masterAccount::CUSTOMER }}">
                                                            Custome</option>
                                                        <option value="{{ \App\Models\masterAccount::EMPLOYE }}">
                                                            Employe</option>
                                                        <option value="{{ \App\Models\masterAccount::VENDOR }}">Vendor
                                                        </option>
                                                        <option value="{{ \App\Models\masterAccount::OTHER }}">Other
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <br>
                                                    <div class="text-end mt-2">
                                                        <button data-repeater-delete type="button"
                                                            class="btn btn-sm btn-danger add-item"><i
                                                                class=" mdi mdi-delete"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    </button>
                                    <button data-repeater-create type="button" class="btn-sm btn btn-success add-item"
                                        style="margin-top: 15px;"><i class="mdi mdi-plus"></i>
                                    </button>
                                </div>
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
<script src="{{ asset('assets/js/repeater.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/js/notify.min.js') }}"></script>


<script>
    $('.repeater').repeater({
        defaultValues: {
            'text-input': 'foo'
        },
        show: function() {
            $(this).slideDown();
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        },
        isFirstItemUndeletable: true
    });

    $('.update-type').select2({
        placeholder: ''
    });

    $('.uom-select').select2({
        placeholder: 'select '
    });


    $(document).ready(function() {
        $(".update-name").change(function() {
            var name = $(this).val();
            var id = $(this).attr('data-id');
            $.ajax({
                url: '{{ route('update.account.name') }}',
                method: 'POST',
                data: {
                    id: id,
                    name: name,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $.notify("Name updated", "success");
                },
                error: function(response) {
                    alert(response);
                }
            })
        })

        $(".update-address").change(function() {
            var id = $(this).attr('data-id');
            var address = $(this).val();
            $.ajax({
                url: '{{ route('update.account.address') }}',
                method: 'POST',
                data: {
                    id: id,
                    address: address,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $.notify("address updated", "success");
                },
                error: function(response) {
                    alert(response);
                }
            })
        })
        $(".update-type").change(function() {
            var id = $(this).attr('data-id');
            var type = $(this).val();
            $.ajax({
                url: '{{ route('update.account.type') }}',
                method: 'POST',
                data: {
                    id: id,
                    type: type,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $.notify("type updated", "success");
                },
                error: function(response) {
                    alert(response);
                }
            })
        })
    });

    $("#deleteItem").click(function() {
        $("#loader").show();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route('delete.account') }}',
            method: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $.notify("Type deleted", "error");
                $("#loader").hide();
                $("#deleteModal").modal('hide');
                $(".removeble-tr-" + id).fadeOut();
            },
            error: function(response) {
                alert(response);
            }
        })
    })


    $(".delete-items").click(function() {
        var id = $(this).attr('delete-id');
        $("#deleteItem").attr('data-id', id)
        $("#deleteModal").modal('show');
    })
</script>
<!-- partial:partials/_footer.html -->
</body>

</html>
{{-- @endsection --}}
