{{-- @extends('layouts.master')
@section('content') --}}
@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <h3 class="fw-bold mb-4">Master <span style="color: silver;"></span>Company</h3>
            <div class="card p-2">
                <div class="col-12">

                    <table class="table table-hover tab-pane">
                        <tr>
                            <th>#</th>
                            <th>Compaey name</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($items as $key => $item)
                            <tr class="removeble-tr-{{ $item->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <input type="text" class="border-0 update-name" data-id='{{ $item->id }}'
                                        value="{{ $item->compaey_name }}">
                                </td>
                                <td>
                                    <button type="button" delete-id ='{{ $item->id }}'
                                        class="btn btn-danger add-item delete-items" style="padding:4px 5px 3px 5px;"><i
                                            class="fs-5 text-white mdi mdi-delete"></i></button>
                                </td>
                        @endforeach
                        </tr>
                    </table>

                    <div class="card-body pt-10 ">
                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('master.company.create') }}">
                            @csrf
                            <!-- <div class="border border-5 m-3" style="margin-left: 0 !important;"></div> -->
                            {{-- <div class="repeater">
                                <div data-repeater-list="category-group"> --}}
                            {{-- <h4 class="card-title">Company Master</h4> --}}
                            <div id="show_item">
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="compaey_name"
                                                class="form-control form-control-sm border-black"
                                                placeholder="Company Name">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                            {{-- </div>
                            </div> --}}
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
                <h5 class="modal-title" id="exampleModalLongTitle">Company Master</h5>
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
        show: function() {
            $(this).slideDown();
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        },
        isFirstItemUndeletable: true
    });


    $(document).ready(function() {
        $(".update-name").change(function() {
            var compaey_name = $(this).val();
            var id = $(this).attr('data-id');
            $.ajax({
                url: '{{ route('update.company.name') }}',
                method: 'POST',
                data: {
                    id: id,
                    compaey_name: compaey_name,
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

        $("#deleteItem").click(function() {
            $("#loader").show();
            var id = $(this).attr('data-id');
            $.ajax({
                url: '{{ route('delete.company') }}',
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
