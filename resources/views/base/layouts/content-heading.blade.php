<div class="content-heading">
  <div class="heading-left">
    <h1 class="page-title">{{ $page_title }}</h1>
    <p class="page-subtitle">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
  </div>

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      @php
        $segments = '';
      @endphp
      @for($i = 1; $i <= count(Request::segments()); $i++)
        @php
          $segments .= '/'. Request::segment($i);
        @endphp
        @if($i < count(Request::segments()))
            <li class="breadcrumb-item">{!! ($i == 1 ? '<i class="fa fa-home"></i> ' : '').ucwords(Request::segment($i)) !!}</li>
        @else
            <li class="breadcrumb-item active">{!! ($i == 1 ? '<i class="fa fa-home"></i> ' : '').ucwords(Request::segment($i)) !!}</li>
        @endif
      @endfor
    </ol>
  </nav>
</div>