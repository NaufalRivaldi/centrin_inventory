@extends('base.app')

@section('content')
<div class="card">
  <div class="card-header">
    <a href="{{ route('inventory.software.create') }}" class="btn btn-primary btn-sm float-right">
      <i class="fas fa-plus"></i> Add new software
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
          <th>Software Name</th>
          <th>Serial Number</th>
          <th>Max Device</th>
          <th>Scanned Invoice</th>
          <th>Software Used By</th>
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
        <h5 class="modal-title" id="modalDetailLabel">Detail Software</h5>
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
          type: "post",
          url: "{{ route('inventory.software.ajax') }}",
          data: {
            _token: "{{ csrf_token() }}",
            param: 'datatable',
            filter_site: filter_site
          }
        },
        columns: [
          {data: "software_name", name: 'software_name'},
          {data: "software_serial", name: 'software_serial'},
          {data: "software_maxdevice", name: 'software_maxdevice'},
          {data: "software_scannedinvoice", name: 'software_scannedinvoice'},
          {data: "computer_count", name: 'computer_count'},
          {data: "action", name: 'action', orderable: false},
        ]
      });
    }

    function datatableModal(device_id = null){
      let linkModal = "{{ route('inventory.software.show.modal', 'id') }}";
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

    // ======================================
    // Show modal for detail software
    // ======================================
    $(document).on('click', '.software-detail', function(){
      let $id = $(this).data('id');
      datatableModal($id);
    });

    // ======================================
    // Close modal and destroy datatable
    // ======================================
    $(document).on('click', '.close-modal', function(){
      $('.datatableModal').DataTable().destroy();
    });

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
    $(document).on('click', '.software-delete', function(){
      let $id = $(this).data('id');
      let link = "{{ route('inventory.software.show', 'id') }}";
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

    // ======================================
    // Empty data for detail
    // ======================================
    function emptyDetail(){
      $('.software_name').empty();
      $('.software_serial').empty();
      $('.software_maxdevice').empty();
      $('.site').empty();
      $('.software_invoiceno').empty();
      $('.software_scannedinvoice').empty();
      $('.updated_by').empty();
    }
  });
</script>
@endpush