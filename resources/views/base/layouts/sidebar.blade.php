<div id="sidebar-nav" class="sidebar">
  <nav>
    <ul class="nav" id="sidebar-nav-menu">
      <li class="menu-group">Main</li>

      <li><a href="{{ route('dashboard.index') }}" class=""><i class="ti-dashboard"></i> <span class="title">Dashboard</span></a></li>

      <li><a href="{{ route('user.index') }}" class=""><i class="ti-user"></i> <span class="title">User</span></a></li>

      <li class="panel">
        <a href="#inventory" data-toggle="collapse" data-parent="#sidebar-nav-menu" aria-expanded="false" class=""><i class="ti-dashboard"></i> <span class="title">Inventory</span> <i class="icon-submenu ti-angle-left"></i></a>
        <div id="inventory" class="collapse">
          <ul class="submenu">
            <li><a href="{{ route('inventory.computer.index') }}">Computer</a></li>
            <li><a href="{{ route('inventory.device.index') }}">Device</a></li>
            <li><a href="{{ route('inventory.software.index') }}">Software</a></li>
            <li><a href="{{ route('inventory.log.index') }}">Log Computer</a></li>
          </ul>
        </div>
      </li>
    </ul>
    <button type="button" class="btn-toggle-minified" title="Toggle Minified Menu"><i class="ti-arrows-horizontal"></i></button>
  </nav>
</div>