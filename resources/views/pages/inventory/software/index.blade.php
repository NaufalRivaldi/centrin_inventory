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
    <table class="table table-striped table-bordered datatable">
      <thead>
        <tr>
          <th>Software Name</th>
          <th>Software Used By</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        
      </tbody>
    </table>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Name</h6>
        <p class="software_name"></p>
        <hr>
        <h6>Serial</h6>
        <p class="software_serial"></p>
        <hr>
        <h6>Max Device</h6>
        <p class="software_maxdevice"></p>
        <hr>
        <h6>Site</h6>
        <p class="site">asd</p>
        <hr>
        <h6>Invoice Number</h6>
        <p class="software_invoiceno"></p>
        <hr>
        <h6>Scan</h6>
        <p class="software_scannedinvoice"></p>
        <hr>
        <h6>Updated By</h6>
        <p class="updated_by"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
          url: "{{ route('inventory.software.index') }}",
          data: {
            filter_site: filter_site
          }
        },
        columns: [
          {data: "software_name", name: 'software_name'},
          {data: "computer_count", name: 'computer_count'},
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
    // Show modal for detail software
    // ======================================
    $(document).on('click', '.software-detail', function(){
      let $id = $(this).data('id');
      let link = "{{ route('inventory.software.show', 'id') }}";
      link = link.replace('id', $id);
      
      $.ajax({
        url: link,
        type: "GET",
        dataType: "json",
        success: function(result){
          emptyDetail();

          $('.software_name').html(result.software_name);
          $('.software_serial').html(result.software_serial);
          $('.software_maxdevice').html(result.software_maxdevice);
          $('.site').html(result.software_divisions.division.name);
          $('.software_invoiceno').html(result.software_invoiceno);
          $('.software_scannedinvoice').html(`
            <a href="{{ asset('upload/inventory/software') }}/`+result.software_scannedinvoice+`">`+result.software_scannedinvoice+`</a>
          `);
          $('.updated_by').html(result.updated_by);
        }
      });
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