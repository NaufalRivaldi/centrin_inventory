@extends('base.app')

@section('content')
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered datatable">
        <thead>
          <tr>
            <th>Modify Date</th>
            <th>Computer Name</th>
            <th>User</th>
            <th>User IP Address</th>
            <th>Description</th>
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
        order : [[ 0, "desc" ]],
        ajax: {
          type: "GET",
          url: "{{ route('inventory.log.index') }}",
          data: {
            filter_site: filter_site
          }
        },
        columns: [
          {data: "updated_at", name: 'updated_at'},
          {data: "computer_name", name: 'computer_name'},
          {data: "user.name", name: 'user.name'},
          {data: "user_ipaddress", name: 'user_ipaddress'},
          {data: "description", name: 'description'},
        ]
      });
    }
  });
</script>
@endpush