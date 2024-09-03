@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="card p-2">
                <div class="col-12">
                    <h3 class="fw-bold p-2">Product Master</h3>
                    <div class="table-responsive">
                        <table class="table table-hover tab-pane">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Pack Size</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($products as $key => $product)
                                <tr class="removeble-tr-{{ $product->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $product->name }}
                                    </td>

                                    <td>
                                        {{ $product->pack_size }}
                                    </td>
                                    <td>
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary"
                                            style="padding:4px 5px 3px 5px;">
                                            <i class="fs-5 text-white mdi mdi-pencil"></i></a>

                                        <button type="button" delete-id='{{ $product->id }}'
                                            class="btn btn-danger add-item delete-items"
                                            style="padding:4px 5px 3px 5px;"><i
                                                class="fs-5 text-white mdi mdi-delete"></i>
                                        </button>
                                    </td>
                            @endforeach
                            </tr>
                        </table>
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
<script src="{{ asset('assets/js/repeater.min.js') }}"></script>
<script src="{{ asset('assets/js/notify.min.js') }}"></script>
<script>
    $('.repeater').repeater({
        defaultValues: {
            'text-input': 'foo'
        },
        show: function() {
            $(this).slideDown();
            $('.items-select').select2({
                placeholder: 'Select an option'
            });
            $('.uom-select').select2({
                placeholder: 'Select an option'
            });
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        },
        isFirstItemUndeletable: true
    });

</script>
