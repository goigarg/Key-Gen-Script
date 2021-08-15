@extends('layouts.index')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="container text-center">
    <div class="alert-warning">{{session('resource')}}</div>
    <h1>Generate Key</h1>

    <input id="msg" class="form-control" readonly style="background-color: white;">
<p></p>
    <button id="ajaxSubmit" name="get_key" class="btn btn-primary">Generate</button>

    <p></p>
<h1>Generation History</h1>

    @foreach($gen as $i=>$g)

    <p class="alert-warning" style="font-size:15px;">{{$i+1}} : {{$g->stkey}}</p>

    @endforeach

</div>

<script type="text/javascript">
$("#ajaxSubmit").click(function (e) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: 'POST',
    url: '/dash/data',
    success: function success(data) {
      $('#msg').val(JSON.parse(data));
    }
  });
});
</script>

@endsection