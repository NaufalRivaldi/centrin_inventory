@extends('base.app')

@section('content')
<div class="card">
  <div class="card-header">
    <b>Detail of Computer</b>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <table class="">
          <tr>
            <th>Label Code</th>
            <td>:</td>
            <td>{{ $computer->inventory_number }}</td>
          </tr>
          <tr>
            <th>Computer Name</th>
            <td>:</td>
            <td>{{ $computer->computer_name }}</td>
          </tr>
          <tr>
            <th>Computer Status</th>
            <td>:</td>
            <td>{!! status($computer->computer_status) !!}</td>
          </tr>
          <tr>
            <th>Computer Type</th>
            <td>:</td>
            <td>{{ $computer->computer_type }}</td>
          </tr>
          <tr>
            <th>Monitor</th>
            <td>:</td>
            <td>{{ $computer->monitor }}</td>
          </tr>
          <tr>
            <th>Manufacturer</th>
            <td>:</td>
            <td>{{ $computer->manufactur }}</td>
          </tr>
          <tr>
            <th>Model</th>
            <td>:</td>
            <td>{{ $computer->model }}</td>
          </tr>
          <tr>
            <th>Processor</th>
            <td>:</td>
            <td>{{ $computer->processor }}</td>
          </tr>
          <tr>
            <th>Memory</th>
            <td>:</td>
            <td>{{ showComponent($computer->computer_component_memories) }}</td>
          </tr>
          <tr>
            <th>Hard Drive</th>
            <td>:</td>
            <td>{{ showComponent($computer->computer_component_harddrives) }}</td>
          </tr>
          <tr>
            <th>Computer IP Address</th>
            <td>:</td>
            <td>{{ $computer->computer_ipaddress }}</td>
          </tr>
          <tr>
            <th>Sites</th>
            <td>:</td>
            <td>{{ $computer->computer_divisions->division->name }}</td>
          </tr>
          <tr>
            <th>Department</th>
            <td>:</td>
            <td>{{ $computer->department }}</td>
          </tr>
          <tr>
            <th>Scanned Invoice</th>
            <td>:</td>
            <td>{!! $computer->computer_invoiceno.' '.showInvoiceScanned($computer->computer_scannedinvoice) !!}</td>
          </tr>
        </table>
      </div>

      <div class="col-md-6">
        <table class="table table-bordered table-striped datatableSoftware" style="font-size: .8em">
          <thead>
            <tr>
              <th>Software Name</th>
              <th>Software Serial Number</th>
            </tr>
          </thead>
        </table>
        <hr>
        <table class="table table-bordered table-striped datatableDevice" style="font-size: .8em">
          <thead>
            <tr>
              <th>Device Name</th>
              <th>Device Brand</th>
              <th>Device IP Address</th>
            </tr>
          </thead>
        </table>
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
    $('.datatableSoftware').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        type: "GET",
        url: "{{ route('inventory.computer.json', 'software') }}",
        data: {
          computer_id: "{{ $computer->id }}"
        }
      },
      columns: [
        {data: "software_name", name: 'software_name'},
        {data: "software_serial", name: 'software_serial'},
      ]
    });

    $('.datatableDevice').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        type: "GET",
        url: "{{ route('inventory.computer.json', 'device') }}",
        data: {
          computer_id: "{{ $computer->id }}"
        }
      },
      columns: [
        {data: "device.device_name", name: 'device.device_name'},
        {data: "device.device_brand", name: 'device.device_brand'},
        {data: "device.device_ipaddress", name: 'device.device_ipaddress'},
      ]
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