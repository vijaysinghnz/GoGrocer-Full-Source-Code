@extends('web.layout.app')
<style>
.canreq_cont {
    background-color: #f6f2f2;
}
</style>
@section('content')
  <div class="container-fluid canreq_cont" align="center" style="z-index:999999 !important">
         <?= $about->description ?>
     
  </div>
@endsection