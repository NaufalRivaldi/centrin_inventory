@extends('base.app')

@section('content')
<div class="card">
  <div class="card-header">
    Create a New Computer
  </div>
  <form action="{{ $computer->id == '' ? route('inventory.computer.store') : route('inventory.computer.update', $computer->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($computer->id != '')
      @method('put')
    @endif
    <div class="card-body">
      <div class="form-group">
        <label for="">Computer Name</label>
        <input type="text" name="computer_name" class="form-control {{ $errors->has('computer_name') ? 'is-invalid' : '' }}" value="{{ $computer->computer_name != '' ? $computer->computer_name : old('computer_name') }}" required>

        <!-- error -->
        @if($errors->has('computer_name'))
          <small class="text-danger">
            {{ $errors->first('computer_name') }}
          </small>
        @endif
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Computer Status</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="computer_status" id="radioActive" value="1" {{ $computer->computer_status == '1' ? 'checked' : '' }}>
              <label class="form-check-label" for="radioActive">
                Active
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="computer_status" id="radioInactive" value="0" {{ $computer->computer_status == '0' ? 'checked' : '' }}>
              <label class="form-check-label" for="radioInactive">
                Inactive
              </label>
            </div>

            <!-- error -->
            @if($errors->has('computer_status'))
              <small class="text-danger">
                {{ $errors->first('computer_status') }}
              </small>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Computer Type</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="computer_type" id="radioActive" value="Laptop" {{ $computer->computer_type == 'Laptop' ? 'checked' : '' }}>
              <label class="form-check-label" for="radioActive">
                Laptop
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="computer_type" id="radioInactive" value="Computer" {{ $computer->computer_type == 'Computer' ? 'checked' : '' }}>
              <label class="form-check-label" for="radioInactive">
                Computer
              </label>
            </div>

            <!-- error -->
            @if($errors->has('computer_type'))
              <small class="text-danger">
                {{ $errors->first('computer_type') }}
              </small>
            @endif
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Manufacturer</label>
            <input type="text" name="manufactur" class="form-control {{ $errors->has('manufactur') ? 'is-invalid' : '' }}" value="{{ $computer->manufactur != '' ? $computer->manufactur : old('manufactur') }}">

            <!-- error -->
            @if($errors->has('manufactur'))
              <small class="text-danger">
                {{ $errors->first('manufactur') }}
              </small>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="">Monitor</label>
                <input type="text" name="monitor" class="form-control {{ $errors->has('monitor') ? 'is-invalid' : '' }}" value="{{ $computer->monitor != '' ? $computer->monitor : old('monitor') }}">

                <!-- error -->
                @if($errors->has('monitor'))
                  <small class="text-danger">
                    {{ $errors->first('monitor') }}
                  </small>
                @endif
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Monitor Size (Inch)</label>
                <input type="number" name="monitor_size" class="form-control {{ $errors->has('monitor_size') ? 'is-invalid' : '' }}" value="{{ $computer->monitor_size != '' ? $computer->monitor_size : old('monitor_size') }}">

                <!-- error -->
                @if($errors->has('monitor_size'))
                  <small class="text-danger">
                    {{ $errors->first('monitor_size') }}
                  </small>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Model</label>
            <input type="text" name="model" class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" value="{{ $computer->model != '' ? $computer->model : old('model') }}">

            <!-- error -->
            @if($errors->has('model'))
              <small class="text-danger">
                {{ $errors->first('model') }}
              </small>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Processor</label>
            <input type="text" name="processor" class="form-control {{ $errors->has('processor') ? 'is-invalid' : '' }}" value="{{ $computer->processor != '' ? $computer->processor : old('processor') }}">

            <!-- error -->
            @if($errors->has('processor'))
              <small class="text-danger">
                {{ $errors->first('processor') }}
              </small>
            @endif
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Label Code</label>
            <input type="text" name="inventory_number" class="form-control {{ $errors->has('inventory_number') ? 'is-invalid' : '' }}" value="{{ $computer->inventory_number != '' ? $computer->inventory_number : old('inventory_number') }}">

            <!-- error -->
            @if($errors->has('inventory_number'))
              <small class="text-danger">
                {{ $errors->first('inventory_number') }}
              </small>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Computer IP Address</label>
            <input type="text" name="computer_ipaddress" class="form-control {{ $errors->has('computer_ipaddress') ? 'is-invalid' : '' }}" value="{{ $computer->computer_ipaddress != '' ? $computer->computer_ipaddress : old('computer_ipaddress') }}">

            <!-- error -->
            @if($errors->has('computer_ipaddress'))
              <small class="text-danger">
                {{ $errors->first('computer_ipaddress') }}
              </small>
            @endif
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Sites</label>
            <select name="division_id" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}" required>
              <option value="">- Choose Sites -</option>
              @foreach($divisions as $division)
                <option value="{{ $division->id }}" {{ $computer->computer_divisions->division_id != '' ? $computer->computer_divisions->division_id == $division->id ? 'selected' : '' : old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
              @endforeach
            </select>

            <!-- error -->
            @if($errors->has('division_id'))
              <small class="text-danger">
                {{ $errors->first('division_id') }}
              </small>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Depertment</label>
            <select name="department" class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}" required>
              <option value="">- Choose Department -</option>
              @foreach($departments as $department)
                <option value="{{ $department }}" {{ $computer->department != '' ? $computer->department == $department ? 'selected' : '' : old('department') == $department ? 'selected' : '' }}>{{ $department }}</option>
              @endforeach
            </select>

            <!-- error -->
            @if($errors->has('department'))
              <small class="text-danger">
                {{ $errors->first('department') }}
              </small>
            @endif
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group form-memory-type">
            <label for="">
              Memory Type
              <button type="button" class="btn btn-sm btn-success add-memory" style="font-size: .6em">
                <i class="fas fa-plus"></i> Add Memory
              </button>
            </label>

            <div class="row-memory-1">
              <select name="memory_type[]" class="form-control {{ $errors->has('memory_type') ? 'is-invalid' : '' }}">
                <option value="">- Choose memory_type -</option>
                @foreach($memory_types as $memory_type)
                  <option value="{{ $memory_type }}">{{ $memory_type }}</option>
                @endforeach
              </select>
            </div>

            <!-- error -->
            @if($errors->has('memory_type'))
              <small class="text-danger">
                {{ $errors->first('memory_type') }}
              </small>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Memory Size</label>
            <div class="row">
              <div class="col-md-6 form-memory-size">
                <div class="row-memory-1">
                  <input type="number" name="memory_size[]" class="form-control {{ $errors->has('memory_size') ? 'is-invalid' : '' }}" placeholder="Memory Size">
                </div>

                <!-- error -->
                @if($errors->has('memory_size'))
                  <small class="text-danger">
                    {{ $errors->first('memory_size') }}
                  </small>
                @endif
              </div>
              <div class="col-md-6 form-memory-unit-size">
                <div class="row row-memory-1">
                  <div class="col-md-8">
                    <select name="memory_unit_size[]" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}">
                      <option value="">- Choose Memory Unit Size -</option>
                      @foreach($memory_unit_sizes as $memory_unit_size)
                        <option value="{{ $memory_unit_size }}">{{ $memory_unit_size }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <button type="button" class="btn btn-danger remove-memory" data-row="1">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>

                <!-- error -->
                @if($errors->has('memory_unit_size'))
                  <small class="text-danger">
                    {{ $errors->first('memory_unit_size') }}
                  </small>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group form-harddrive-brand">
            <label for="">
              Hard Drive Brand
              <button type="button" class="btn btn-sm btn-success add-harddrive" style="font-size: .6em">
                <i class="fas fa-plus"></i> Add Hard Drive
              </button>
            </label>

            <div class="row-harddrive-1">
              <input type="text" name="harddrive_brand[]" class="form-control {{ $errors->has('harddrive_brand') ? 'is-invalid' : '' }}" placeholder="Harddrive brand">
            </div>

            <!-- error -->
            @if($errors->has('harddrive_brand'))
              <small class="text-danger">
                {{ $errors->first('harddrive_brand') }}
              </small>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Hard Drive Size</label>
            <div class="row">
              <div class="col-md-6 form-harddrive-size">
                <div class="row-harddrive-1">
                  <input type="number" name="harddrive_size[]" class="form-control {{ $errors->has('harddrive_size') ? 'is-invalid' : '' }}" placeholder="Harddrive Size">
                </div>

                <!-- error -->
                @if($errors->has('harddrive_size'))
                  <small class="text-danger">
                    {{ $errors->first('harddrive_size') }}
                  </small>
                @endif
              </div>
              <div class="col-md-6 form-harddrive-unit-size">
                <div class="row row-harddrive-1">
                  <div class="col-md-8">
                    <select name="harddrive_unit_size[]" class="form-control {{ $errors->has('division_id') ? 'is-invalid' : '' }}">
                      <option value="">- Choose Harddrive Unit Size -</option>
                      @foreach($harddrive_unit_sizes as $harddrive_unit_size)
                        <option value="{{ $harddrive_unit_size }}">{{ $harddrive_unit_size }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <button type="button" class="btn btn-danger remove-harddrive" data-row="1">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>

                <!-- error -->
                @if($errors->has('harddrive_unit_size'))
                  <small class="text-danger">
                    {{ $errors->first('harddrive_unit_size') }}
                  </small>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group form-software-name">
            <label for="">
              Software
              <button type="button" class="btn btn-sm btn-success add-software" style="font-size: .6em">
                <i class="fas fa-plus"></i> Add Software
              </button>
            </label>

            <div class="row-software-1">
              <select name="software_name[]" id="" class="form-control software-name" data-row='1'>
                <option value="">- Choose Software -</option>
                @foreach($softwares as $software)
                  <option value="{{ $software->software_name }}">{{ $software->software_name }}</option>
                @endforeach
              </select>
            </div>

            <!-- error -->
            @if($errors->has('software_name'))
              <small class="text-danger">
                {{ $errors->first('software_name') }}
              </small>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group form-software-serial-number">
            <label for="">Software Serial Number</label>
            <div class="row row-software-1">
              <div class="col-md-10">
                <select name="software_serial_number[]" class="form-control software-serial-number-1">
                  <option value="">- Choose Serial Number -</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-software" data-row="1">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>

            <!-- error -->
            @if($errors->has('software_serial_number'))
                <small class="text-danger">
                  {{ $errors->first('software_serial_number') }}
                </small>
              @endif
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group form-device_id">
            <label for="">
              Device
              <button type="button" class="btn btn-sm btn-success add-device" style="font-size: .6em">
                <i class="fas fa-plus"></i> Add Device
              </button>
            </label>

            <div class="row row-device-1">
              <div class="col-md-11">
                <select name="device_id[]" id="" class="form-control">
                  <option value="">- Choose Device -</option>
                  @foreach($devices as $device)
                    <option value="{{ $device->device_id }}">{{ $device->device_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-1">
                <button type="button" class="btn btn-danger remove-device" data-row="1">
                    <i class="fas fa-minus"></i>
                  </button>
              </div>
            </div>

            <!-- error -->
            @if($errors->has('device_id'))
              <small class="text-danger">
                {{ $errors->first('device_id') }}
              </small>
            @endif
          </div>
        </div>

        <!-- error -->
        @if($errors->has('device_id'))
          <small class="text-danger">
            {{ $errors->first('device_id') }}
          </small>
        @endif
      </div>

      <div class="form-group">
        <label for="">Invoice Number</label>
        <input type="text" name="computer_invoiceno" class="form-control">
      </div>

      <div class="form-group">
        <label for="">Scanned Invoice</label>
        @if($computer->id != '')
          <input type="hidden" name="computer_scannedinvoice_old" value="{{ $computer->computer_scannedinvoice }}">
        @endif

        <!-- if image is exist -->
        @if($computer->computer_scannedinvoice != null)
          <br>
          <a href="{{ asset('upload/inventory/computer/'. $computer->computer_scannedinvoice) }}" class="badge badge-success">{{ $computer->computer_scannedinvoice }}</a>
          <button type="button" class="btn btn-danger btn-sm delete-image" data-id="{{ $computer->id }}">
            <i class="fas fa-trash-alt"></i>
          </button>
        @endif
        <!-- if image is exist -->

        <input type="file" name="computer_scannedinvoice" class="form-control {{ $errors->has('computer_scannedinvoice') ? 'is-invalid' : '' }}">

        <!-- error -->
        @if($errors->has('computer_scannedinvoice'))
          <small class="text-danger">
            {{ $errors->first('computer_scannedinvoice') }}
          </small>
        @endif
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Submit</button>
      <a href="{{ route('inventory.computer.index') }}" class="btn btn-danger">Cancel</a>
    </div>
  </form>
</div>
@endsection

@push('script')
<script>
  $(function(){
    // ========================================================
    // Global variable
    // ========================================================
    var rowMemory = 1;
    var rowHarddrive = 1;
    var rowSoftware = 1;
    var rowDevice = 1;

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

    // =====================================================
    // Add memory click button
    // =====================================================
    $('.add-memory').on('click', function(){
      rowMemory += 1;

      // Memory type
      var memoryTypes = @json($memory_types);
      var memoryType = '<div class="row-memory-'+rowMemory+'"><select name="memory_type[]" class="form-control mt-2">';
      memoryType += '<option value="">- Choose memory_type -</option>';
      $.each(memoryTypes, function(index, val){
        memoryType += '<option value="'+val+'">'+val+'</option>';
      });
      memoryType += '</select></div>';

      // Memory size
      var memorySize = '<div class="row-memory-'+rowMemory+'"><input type="number" name="memory_size[]" class="form-control mt-2" placeholder="Memory Size"></div>';

      // Memory unit size
      var memoryUnitSizes = @json($memory_unit_sizes);
      var memoryUnitSize = '<div class="row row-memory-'+rowMemory+'"><div class="col-md-8"><select name="memory_unit_size[]" class="form-control mt-2">';
      memoryUnitSize += '<option value="">- Choose Memory Unit Size -</option>';
      $.each(memoryUnitSizes, function(index, val){
        memoryUnitSize += '<option value="'+val+'">'+val+'</option>';
      });
      memoryUnitSize += '</select></div><div class="col-md-4"><button type="button" class="btn btn-danger remove-memory mt-2" data-row="'+rowMemory+'"><i class="fas fa-minus"></i></button></div></div>';

      // Add code to view
      $('.form-memory-type').append(memoryType);
      $('.form-memory-size').append(memorySize);
      $('.form-memory-unit-size').append(memoryUnitSize);
    });

    // =====================================================
    // Remove memory click button
    // =====================================================
    $(document).on('click', '.remove-memory', function(){
      var $row = $(this).data('row');
      
      $('.row-memory-'+$row).remove();
    });

    // =====================================================
    // Add harddrive click button
    // =====================================================
    $('.add-harddrive').on('click', function(){
      rowHarddrive += 1;

      // Harddrive type
      var harddriveBrand = '<div class="row-harddrive-'+rowHarddrive+'"><input type="text" name="harddrive_brand[]" class="form-control mt-2" placeholder="Harddrive brand"></div>';

      // Harddrive size
      var harddriveSize = '<div class="row-harddrive-'+rowHarddrive+'"><input type="number" name="harddrive_size[]" class="form-control mt-2" placeholder="Harddrive Size"></div>';

      // Harddrive unit size
      var harddriveUnitSizes = @json($harddrive_unit_sizes);
      var harddriveUnitSize = '<div class="row row-harddrive-'+rowHarddrive+'"><div class="col-md-8"><select name="harddrive_unit_size[]" class="form-control mt-2">';
      harddriveUnitSize += '<option value="">- Choose Harddrive Unit Size -</option>';
      $.each(harddriveUnitSizes, function(index, val){
        harddriveUnitSize += '<option value="'+val+'">'+val+'</option>';
      });
      harddriveUnitSize += '</select></div><div class="col-md-4"><button type="button" class="btn btn-danger remove-harddrive mt-2" data-row="'+rowHarddrive+'"><i class="fas fa-minus"></i></button></div></div>';

      // Add code to view
      $('.form-harddrive-brand').append(harddriveBrand);
      $('.form-harddrive-size').append(harddriveSize);
      $('.form-harddrive-unit-size').append(harddriveUnitSize);
    });

    // =====================================================
    // Remove harddrive click button
    // =====================================================
    $(document).on('click', '.remove-harddrive', function(){
      var $row = $(this).data('row');
      
      $('.row-harddrive-'+$row).remove();
    });

    // =====================================================
    // Search serial number by software
    // =====================================================
    $(document).on('change', '.software-name', function(){
      var $softwareName = $(this).val();
      var $rowSoftwareSerialNumber = $(this).data('row');
      
      $.ajax({
        url: "{{ route('inventory.computer.search.software') }}",
        type: "GET",
        dataType: "JSON",
        data: {
          software_name: $softwareName
        },
        success: function(response){
          $('.software-serial-number-'+$rowSoftwareSerialNumber).empty();
          $('.software-serial-number-'+$rowSoftwareSerialNumber).append('<option value="">- Choose Serial Number -</option>')
          $.each(response, function(index, val){
            $('.software-serial-number-'+$rowSoftwareSerialNumber).append('<option value="'+val.id+'">'+val.software_serial+'</option>')
          });
        }
      });
    });

    // =====================================================
    // Add software click button
    // =====================================================
    $('.add-software').on('click', function(){
      rowSoftware += 1;

      // Software name
      var softwareNames = @json($softwares);
      var softwareName = '<div class="row-software-'+rowSoftware+'"><select name="software_name[]" id="" class="form-control software-name mt-2" data-row="'+rowSoftware+'">';
      softwareName += '<option value="">- Choose Software -</option>';
      $.each(softwareNames, function(index, val){
        softwareName += '<option value="'+val.software_name+'">'+val.software_name+'</option>';
      });
      softwareName += '</select></div>';

      // Harddrive unit size
      var softwareSerialNumber = '<div class="row row-software-'+rowSoftware+'"><div class="col-md-10"><select name="software_serial_number[]" class="form-control software-serial-number-'+rowSoftware+' mt-2">';
      softwareSerialNumber += '<option value="">- Choose Serial Number -</option>';
      softwareSerialNumber += '</select></div><div class="col-md-2"><button type="button" class="btn btn-danger remove-software mt-2" data-row="'+rowSoftware+'"><i class="fas fa-minus"></i></button></div></div></div>';

      // Add code to view
      $('.form-software-name').append(softwareName);
      $('.form-software-serial-number').append(softwareSerialNumber);
    });

    // =====================================================
    // Remove software click button
    // =====================================================
    $(document).on('click', '.remove-software', function(){
      var $row = $(this).data('row');
      
      $('.row-software-'+$row).remove();
    });

    // =====================================================
    // Add device click button
    // =====================================================
    $('.add-device').on('click', function(){
      rowDevice += 1;

      // Software name
      var devices = @json($devices);
      var device = '<div class="row row-device-'+rowDevice+' mt-2"><div class="col-md-11"><select name="device_id[]" id="" class="form-control">';
      device += '<option value="">- Choose Device -</option>';
      $.each(devices, function(index, val){
        device += '<option value="'+val.id+'">'+val.device_name+'</option>';
      });
      device += '</select></div><div class="col-md-1"><button type="button" class="btn btn-danger remove-device" data-row="'+rowDevice+'"><i class="fas fa-minus"></i></button></div></div>';

      // Add code to view
      $('.form-device_id').append(device);
    });

    // =====================================================
    // Remove device click button
    // =====================================================
    $(document).on('click', '.remove-device', function(){
      var $row = $(this).data('row');
      
      $('.row-device-'+$row).remove();
    });
  });
</script>
@endpush