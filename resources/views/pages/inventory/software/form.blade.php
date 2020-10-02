@extends('base.app')

@section('content')
<div class="card">
  <div class="card-header">
    Create a New Software
  </div>
  <form action="{{ $software->id == '' ? route('inventory.software.store') : route('inventory.software.update', $software->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($software->id != '')
      @method('put')
    @endif
    <div class="card-body">
      <div class="form-group">
        <label for="">Software Name</label>
        <input type="text" name="software_name" class="form-control {{ $errors->has('software_name') ? 'is-invalid' : '' }}" value="{{ $software->software_name != '' ? $software->software_name : old('software_name') }}">

        <!-- error -->
        @if($errors->has('software_name'))
          <small class="text-danger">
            {{ $errors->first('software_name') }}
          </small>
        @endif
      </div>
      <div class="form-group">
        <label for="">Software Serial</label>
        <input type="text" name="software_serial" class="form-control {{ $errors->has('software_serial') ? 'is-invalid' : '' }}" value="{{ $software->software_serial != '' ? $software->software_serial : old('software_serial') }}">

        <!-- error -->
        @if($errors->has('software_serial'))
          <small class="text-danger">
            {{ $errors->first('software_serial') }}
          </small>
        @endif
      </div>
      <div class="form-group">
        <label for="">Software Max Device</label>
        <input type="number" name="software_maxdevice" class="form-control {{ $errors->has('software_maxdevice') ? 'is-invalid' : '' }}" value="{{ $software->software_maxdevice != '' ? $software->software_maxdevice : old('software_maxdevice') }}">

        <!-- error -->
        @if($errors->has('software_maxdevice'))
          <small class="text-danger">
            {{ $errors->first('software_maxdevice') }}
          </small>
        @endif
      </div>
      <div class="form-group">
        <label for="">Sites</label>
        <select name="site" class="form-control {{ $errors->has('site') ? 'is-invalid' : '' }} col-md-6" required>
          <option value="">- Choose Sites -</option>
          @foreach($divisions as $division)
            <option value="{{ $division->id }}" {{ $software->software_divisions->division_id != '' ? $software->software_divisions->division_id == $division->id ? 'selected' : '' : old('site') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
          @endforeach
        </select>

        <!-- error -->
        @if($errors->has('site'))
          <small class="text-danger">
            {{ $errors->first('site') }}
          </small>
        @endif
      </div>
      <div class="form-group">
        <label for="">Invoice Number</label>
        <input type="text" name="software_invoiceno" class="form-control {{ $errors->has('software_invoiceno') ? 'is-invalid' : '' }}" value="{{ $software->software_invoiceno != '' ? $software->software_invoiceno : old('software_invoiceno') }}">

        <!-- error -->
        @if($errors->has('software_invoiceno'))
          <small class="text-danger">
            {{ $errors->first('software_invoiceno') }}
          </small>
        @endif
      </div>
      <div class="form-group">
        <label for="">Scanned Invoice</label>

        @if($software->id != '')
          <input type="hidden" name="software_scannedinvoice_old" value="{{ $software->software_scannedinvoice }}">
        @endif

        <!-- if image is exist -->
        @if($software->software_scannedinvoice != null)
          <br>
          <a href="{{ asset('upload/inventory/software/'. $software->software_scannedinvoice) }}" class="badge badge-success">{{ $software->software_scannedinvoice }}</a>
          <button type="button" class="btn btn-danger btn-sm delete-image" data-id="{{ $software->id }}">
            <i class="fas fa-trash-alt"></i>
          </button>
        @endif
        <!-- if image is exist -->

        <input type="file" name="software_scannedinvoice" class="form-control {{ $errors->has('software_scannedinvoice') ? 'is-invalid' : '' }}">

        <!-- error -->
        @if($errors->has('software_scannedinvoice'))
          <small class="text-danger">
            {{ $errors->first('software_scannedinvoice') }}
          </small>
        @endif
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Submit</button>
      <a href="{{ route('inventory.software.index') }}" class="btn btn-danger">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('script')
<script>
  $(function(){
    $(document).on('click', '.delete-image', function(){
      let $id = $(this).data('id');
      let link = "{{ route('inventory.software.delete.image', 'id') }}";
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
              location.reload();
            }
          })
        }
      })
    });
  });
</script>
@endpush