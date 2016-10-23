@extends('home')
@section ('content')

<style>
.title-hero
{
    color:red;
}
</style>

<script type="text/javascript">

</script>

<div class="panel">
    <div class="panel-body">
        <h1 class="title-hero">
        
            <b>{{$message}}</b>
       
        </h1>
        <div class="example-box-wrapper">
                  <span class="col-sm-6">
                       <a class="btn btn-primary active" href="permissionsmenu1" role="button">Back</a>
                    </span>
            
        </div>
    </div>
</div>
@endsection