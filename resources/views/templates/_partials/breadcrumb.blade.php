<section class="content-header">
  <h1>
    {{ $title }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> হোমপেজ</a></li>
	@if(isset($links))
	    @foreach($links as $key => $value)
	    	<li><a href="{{ url($value) }}">{{ ucfirst($key) }}</a></li>
	    @endforeach
    @endif
  </ol>
</section>