@include('dashboard')

<!-- <h1 class="text-center">report</h1> -->
<div class="main-panel ">
    <div class="content-wrapper p-2">
        <div class="card">
            <div class="text-end pt-3 me-2">
                <a href="{{route('create')}}"><button type="button" class="btn btn-success">Add Order</button></a>
            </div>
            <div class="container p-2">
                <table id="example" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-start">Product Name</th>
                            <th>Batch Size</th>
                            <th>Batch Required</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->batch_size }}</td>
                            <td>{{ $product->batch_required }}</td>
                            <td>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                <button data-repeater-delete type="button" class="btn btn-danger delete-btn"
                                    data-id="{{ $product->id }}"
                                    {{--data-action="{{ route('products.delete', $product->id) }}"--}}
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

 <!-- Modal -->
 <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this record?
        </div>
        <div class="modal-footer">
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
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
    $(document).ready(function (){
        $("#loader").hide();
    })
    new DataTable('#example', {
        responsive: true
    });
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteForm = document.getElementById('deleteForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const actionUrl = button.getAttribute('data-action');
                deleteForm.setAttribute('action', actionUrl);
            });
        });
    });

</script>
</body>

</html>
