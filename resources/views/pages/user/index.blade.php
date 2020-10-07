@extends('base.app')

@section('content')
<div class="card">
  <div class="card-header">
    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm float-right">
      <i class="fas fa-plus"></i> Add new user
    </a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered datatable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
  $(function(){
    // ====================================
    // Datatable init with jquery
    // ====================================
    datatable();

    function datatable(){
      $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          type: "post",
          url: "{{ route('user.ajax') }}",
          data: {
            _token: "{{ csrf_token() }}",
            param: 'datatable',
          }
        },
        columns: [
          {data: "name", name: 'name'},
          {data: "email", name: 'email'},
          {data: "action", name: 'action', orderable: false},
        ]
      });
    }

    // ======================================
    // Delete data with sweet alert
    // ======================================
    $(document).on('click', '.user-delete', function(){
      let $id = $(this).data('id');
      let link = "{{ route('user.show', 'id') }}";
      link = link.replace('id', $id);

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: link,
            type: "DELETE",
            data: {
              _token: "{{ csrf_token() }}"
            },
            success: function(){
              $('.datatable').DataTable().ajax.reload();
            }
          })
        }
      })
    });
  });
</script>
@endpush