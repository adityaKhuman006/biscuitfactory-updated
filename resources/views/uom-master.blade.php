@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="card p-2">
                <div class="col-12">
                    <h3 class="fw-bold p-2">UOM Master</h3>
                    <table class="table table-hover tab-pane">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Short Name</th>
                            <th>Conversion</th>
                            <th>uom 2</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($Uoms as $key => $uom)
                            <tr class="removeble-tr-{{ $uom->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <input type="text" class="border-0 update-name" onchange="updateUomData('{{ $uom->id }}',$(this).val(),'name')" data-id='{{ $uom->id }}'
                                           value="{{ $uom->name }}">
                                </td>
                                <td>
                                    <input type="text" class="border-0 update-short-Name" data-id='{{ $uom->id }}' onchange="updateUomData('{{ $uom->id }}',$(this).val(),'shortName')"
                                           value=" {{ $uom->short_form }}">
                                </td>
                                <td>
                                    <input type="text" class="border-0 update-conversion" data-id='{{ $uom->id }}' onchange="updateUomData('{{ $uom->id }}',$(this).val(),'conversion')"
                                           value=" {{ $uom->conversion }}">
                                </td>
                                <td>
                                    <input type="text" class="border-0 update-uom-2" data-id='{{ $uom->id }}' onchange="updateUomData('{{ $uom->id }}',$(this).val(),'uom2')"
                                           value=" {{ $uom->uom_2 }}">
                                </td>
                                <td>
                                    <button type="button" delete-id='{{ $uom->id }}'
                                            class="btn btn-danger add-item delete-items"
                                            style="padding:4px 5px 3px 5px;"><i
                                            class="fs-5 text-white mdi mdi-delete"></i></button>
                                </td>
                                @endforeach
                            </tr>
                    </table>

                    <div class="card-body pt-10 ">
                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('master.uom.create') }}">
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
                                                           placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Short Name</label>
                                                    <input type="text" name="short_name" required
                                                           class="form-control form-control-sm border-black"
                                                           placeholder="Enter Short Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Conversion</label>
                                                    <input type="text" name="conversion" required
                                                           class="form-control form-control-sm border-black"
                                                           placeholder="Enter Conversion">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Uom 2</label>
                                                    <input type="text" name="uom_2" required
                                                           class="form-control form-control-sm border-black"
                                                           placeholder="Enter uom 2">
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
<script src="{{ asset('assets/js/notify.min.js') }}"></script>
<script>
    $('.repeater').repeater({
        defaultValues: {
            'text-input': 'foo'
        },
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },
        isFirstItemUndeletable: true
    });

    $("#deleteItem").click(function () {
        $("#loader").show();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route('delete.uom') }}',
            method: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            }, success: function (response) {
                $.notify("Uom deleted", "error");
                $("#loader").hide();
                $("#deleteModal").modal('hide');
                $(".removeble-tr-" + id).fadeOut();
            }, error: function (response) {
                alert(response);
            }
        })
    })


    $(".delete-items").click(function () {
        var id = $(this).attr('delete-id');
        $("#deleteItem").attr('data-id', id)
        $("#deleteModal").modal('show');
    })

    function updateUomData(id,value,type){
        $.ajax({
            url: '{{ route('update.uom') }}',
            method: 'POST',
            data: {
                id: id,
                value: value,
                type : type,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                $.notify("update success", "success");
            },
            error: function (response) {
                alert(response);
            }
        })
    }
</script>
