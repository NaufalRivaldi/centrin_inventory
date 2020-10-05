@extends('base.app')

@section('content')
<div class="card">
  <div class="card-header">
    <a href="{{ route('inventory.computer.create') }}" class="btn btn-primary btn-sm float-right">
      <i class="fas fa-plus"></i> Add new computer
    </a>
  </div>
  <div class="card-body">
    <p>
      <b>Sites: </b> 
      <select name="filter_site">
        <option value="">All Sites</option>
        @foreach($divisions as $division)
          <option value="{{ $division->id }}">{{ $division->name }}</option>
        @endforeach
      </select>
    </p>
    <div class="table-responsive">
      <table class="table table-striped table-bordered datatable">
        <thead>
          <tr>
            <th>Computer Name</th>
            <th>Status</th>
            <th>Computer Type</th>
            <th>Monitor</th>
            <th>Manufacturer</th>
            <th>Model</th>
            <th>Processor</th>
            <th>Memory</th>
            <th>Hard Drive</th>
            <th>Label Code</th>
            <th>IP Address</th>
            <th>Sites</th>
            <th>Department</th>
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

    function datatable(filter_site = null){
      $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          type: "GET",
          url: "{{ route('inventory.computer.index') }}",
          data: {
            filter_site: filter_site
          }
        },
        columns: [
          {data: "computer_name", name: 'computer_name'},
          {data: "computer_status", name: 'computer_status'},
          {data: "computer_type", name: 'computer_type'},
          {data: "monitor", name: 'monitor'},
          {data: "manufactur", name: 'manufactur'},
          {data: "model", name: 'model'},
          {data: "processor", name: 'processor'},
          {data: "memory", name: 'memory'},
          {data: "harddrive", name: 'harddrive'},
          {data: "inventory_number", name: 'inventory_number'},
          {data: "computer_ipaddress", name: 'computer_ipaddress'},
          {data: "computer_divisions.division.name", name: 'computer_divisions.division.name'},
          {data: "department", name: 'department'},
          {data: "action", name: 'action', orderable: false},
        ]
      });
    }

    // ====================================
    // Filtering datatable
    // ====================================
    $('select[name="filter_site"]').on('change', function(){
      $division_id = $(this).val();

      $('.datatable').DataTable().destroy();
      datatable($division_id);
    });

    // ======================================
    // Delete data with sweet alert
    // ======================================
    $(document).on('click', '.computer-delete', function(){
      let $id = $(this).data('id');
      let link = "{{ route('inventory.computer.destroy', 'id') }}";
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