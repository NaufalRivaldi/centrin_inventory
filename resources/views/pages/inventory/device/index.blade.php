@extends('base.app')

@section('content')
<div class="card">
  <div class="card-header">
    <a href="{{ route('inventory.device.create') }}" class="btn btn-primary btn-sm float-right">
      <i class="fas fa-plus"></i> Add new device
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
            <th>Device Name</th>
            <th>Device Status</th>
            <th>Device Type</th>
            <th>Device Brand</th>
            <th>Device IP Address</th>
            <th>Description</th>
            <th>Label Code</th>
            <th>Invoice Number</th>
            <th>Sites</th>
            <th>Device Used By</th>
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

@section('modal')
<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Computer use by <span class="device_name"></span></h5>
        <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered datatableModal">
          <thead>
            <tr>
              <th>Computer Name</th>
              <th>Computer Type</th>
              <th>Computer IP Address</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
      </div>
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
          url: "{{ route('inventory.device.index') }}",
          data: {
            filter_site: filter_site
          }
        },
        columns: [
          {data: "device_name", name: 'device_name'},
          {data: "device_status", name: 'device_status'},
          {data: "device_type", name: 'device_type'},
          {data: "device_brand", name: 'device_brand'},
          {data: "device_ipaddress", name: 'device_ipaddress'},
          {data: "device_description", name: 'device_description'},
          {data: "device_inventorynumber", name: 'device_inventorynumber'},
          {data: "device_invoiceno", name: 'device_invoiceno'},
          {data: "device_divisions.division.name", name: 'device_divisions.division.name'},
          {data: "computer_count", name: 'computer_count'},
          {data: "action", name: 'action', orderable: false},
        ]
      });
    }

    function datatableModal(device_id = null){
      let linkModal = "{{ route('inventory.device.show.modal', 'id') }}";
      linkModal = linkModal.replace('id', device_id);
      console.log(linkModal);

      $('.datatableModal').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
          type: "GET",
          url: linkModal,
          data: {
            device_id: device_id
          }
        },
        columns: [
          {data: "computer.computer_name", name: 'computer.computer_name'},
          {data: "computer.computer_type", name: 'computer.computer_type'},
          {data: "computer.computer_ipaddress", name: 'computer.computer_ipaddress'},
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
    // Show modal for detail software
    // ======================================
    $(document).on('click', '.device-detail', function(){
      let $id = $(this).data('id');
      let link = "{{ route('inventory.device.show', 'id') }}";
      link = link.replace('id', $id);
      
      $.ajax({
        url: link,
        type: "GET",
        dataType: "json",
        success: function(result){
          $('.device_name').empty();
          $('.device_name').html(result.device_name);

          datatableModal($id);
        }
      });
    });

    // ======================================
    // Close modal and destroy datatable
    // ======================================
    $(document).on('click', '.close-modal', function(){
      $('.datatableModal').DataTable().destroy();
    });

    // ======================================
    // Delete data with sweet alert
    // ======================================
    $(document).on('click', '.device-delete', function(){
      let $id = $(this).data('id');
      let link = "{{ route('inventory.device.destroy', 'id') }}";
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