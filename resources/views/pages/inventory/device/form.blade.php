@extends('base.app')

@section('content')
<div class="card">
  <div class="card-header">
    Create a New Device
  </div>
  <form action="{{ $device->id == '' ? route('inventory.device.store') : route('inventory.device.update', $device->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($device->id != '')
      @method('put')
    @endif
    <div class="card-body">
      <div class="form-group">
        <label for="">Device Name</label>
        <input type="text" name="device_name" class="form-control {{ $errors->has('device_name') ? 'is-invalid' : '' }}" value="{{ $device->device_name != '' ? $device->device_name : old('device_name') }}" required>

        <!-- error -->
        @if($errors->has('device_name'))
          <small class="text-danger">
            {{ $errors->first('device_name') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Device Status</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="device_status" id="radioActive" value="1" {{ $device->device_status == '1' ? 'checked' : '' }}>
          <label class="form-check-label" for="radioActive">
            Active
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="device_status" id="radioInactive" value="0" {{ $device->device_status == '0' ? 'checked' : '' }}>
          <label class="form-check-label" for="radioInactive">
            Inactive
          </label>
        </div>

        <!-- error -->
        @if($errors->has('device_status'))
          <small class="text-danger">
            {{ $errors->first('device_status') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Device Description</label>
        <textarea name="device_description" class="form-control {{ $errors->has('device_description') ? 'is-invalid' : '' }}">{{ $device->device_description != '' ? $device->device_description : old('device_description') }}</textarea>

        <!-- error -->
        @if($errors->has('device_description'))
          <small class="text-danger">
            {{ $errors->first('device_description') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Device Type</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="device_type" id="radioActive" value="Router" {{ $device->device_type != '' ? $device->device_type == 'Router' ? 'checked' : '' : 'checked' }}>
          <label class="form-check-label" for="radioActive">
            Router
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="device_type" id="radioInactive" value="Switch" {{ $device->device_type != '' ? $device->device_type == 'Switch' ? 'checked' : '' : '' }}>
          <label class="form-check-label" for="radioInactive">
            Switch
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="device_type" id="radioInactive" value="Access Point" {{ $device->device_type != '' ? $device->device_type == 'Access Point' ? 'checked' : '' : '' }}>
          <label class="form-check-label" for="radioInactive">
            Access Point
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="device_type" id="radioInactive" value="Printer" {{ $device->device_type != '' ? $device->device_type == 'Printer' ? 'checked' : '' : '' }}>
          <label class="form-check-label" for="radioInactive">
            Printer
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="device_type" id="radioInactive" value="Other" {{ $device->device_type != '' ? $device->device_type == 'Other' ? 'checked' : '' : '' }}>
          <label class="form-check-label" for="radioInactive">
            Other
          </label>
        </div>

        <!-- error -->
        @if($errors->has('device_type'))
          <small class="text-danger">
            {{ $errors->first('device_type') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Device Brand</label>
        <input type="text" name="device_brand" class="form-control {{ $errors->has('device_brand') ? 'is-invalid' : '' }}" value="{{ $device->device_brand != '' ? $device->device_brand : old('device_brand') }}">

        <!-- error -->
        @if($errors->has('device_brand'))
          <small class="text-danger">
            {{ $errors->first('device_brand') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Device IP Address</label>
        <input type="text" name="device_ipaddress" class="form-control {{ $errors->has('device_ipaddress') ? 'is-invalid' : '' }}" value="{{ $device->device_ipaddress != '' ? $device->device_ipaddress : old('device_ipaddress') }}">

        <!-- error -->
        @if($errors->has('device_ipaddress'))
          <small class="text-danger">
            {{ $errors->first('device_ipaddress') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Device Label Code</label>
        <input type="text" name="device_inventorynumber" class="form-control {{ $errors->has('device_inventorynumber') ? 'is-invalid' : '' }}" value="{{ $device->device_inventorynumber != '' ? $device->device_inventorynumber : old('device_inventorynumber') }}">

        <!-- error -->
        @if($errors->has('device_inventorynumber'))
          <small class="text-danger">
            {{ $errors->first('device_inventorynumber') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Sites</label>
        <select name="division_id" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }} col-md-6" required>
          <option value="">- Choose Sites -</option>
          @foreach($divisions as $division)
            <option value="{{ $division->id }}" {{ $device->device_divisions->division_id != '' ? $device->device_divisions->division_id == $division->id ? 'selected' : '' : old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
          @endforeach
        </select>

        <!-- error -->
        @if($errors->has('division_id'))
          <small class="text-danger">
            {{ $errors->first('division_id') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Invoice Number</label>
        <input type="text" name="device_invoiceno" class="form-control {{ $errors->has('device_invoiceno') ? 'is-invalid' : '' }}" value="{{ $device->device_invoiceno != '' ? $device->device_invoiceno : old('device_invoiceno') }}">

        <!-- error -->
        @if($errors->has('device_invoiceno'))
          <small class="text-danger">
            {{ $errors->first('device_invoiceno') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Scanned Invoice</label>

        @if($device->id != '')
          <input type="hidden" name="device_scannedinvoice_old" value="{{ $device->device_scannedinvoice }}">
        @endif

        <!-- if image is exist -->
        @if($device->device_scannedinvoice != null)
          <br>
          <a href="{{ asset('upload/inventory/device/'. $device->device_scannedinvoice) }}" class="badge badge-success">{{ $device->device_scannedinvoice }}</a>
          <button type="button" class="btn btn-danger btn-sm delete-image" data-id="{{ $device->id }}">
            <i class="fas fa-trash-alt"></i>
          </button>
        @endif
        <!-- if image is exist -->

        <input type="file" name="device_scannedinvoice" class="form-control {{ $errors->has('device_scannedinvoice') ? 'is-invalid' : '' }}">

        <!-- error -->
        @if($errors->has('device_scannedinvoice'))
          <small class="text-danger">
            {{ $errors->first('device_scannedinvoice') }}
          </small>
        @endif
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Submit</button>
      <a href="{{ route('inventory.device.index') }}" class="btn btn-danger">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('script')
<script>
  $(function(){
    $(document).on('click', '.delete-image', function(){
      let $id = $(this).data('id');
      let link = "{{ route('inventory.device.delete.image', 'id') }}";
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