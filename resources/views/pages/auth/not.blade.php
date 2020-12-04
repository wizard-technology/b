@extends('layouts.app')
@section('content')
<div class="wrapper-page">

    <div class="card">
        <div class="card-block">

            <div class="ex-page-content text-center">
                <h1 class="mb-0">422!</h1>
                <h5 class="">Sorry, You dont have access</h5><br>

                <a class="btn btn-danger mb-5 waves-effect waves-light text-light" href="#" onclick="goBack()">Back</a>
            </div>

        </div>
    </div>
</div>
<script>
    function goBack() {
  window.history.back();
}
</script>
@endsection
