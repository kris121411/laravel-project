@extends('home')


@section ('content')


<script type="text/javascript">

    $(document).ready(function(){
$("#submit").click(function(){
var Firstname = $("#Firstname").val();
var Lastname = $("#Lastname").val();
var Role = $("#Role").val();
var Username = $("#Username").val();
var Password = $("#Password").val();

// Returns successful data submission message when the entered information is stored in database.
var dataString = 'Firstname='+ Firstname + '&Lastname='+ Lastname + '&Role='+ Role + '&Username='+ Username + '&Password='+ Password + '&id='+ 0;
if(Firstname==''|| Lastname==''||Password==''|| Role==''|| Username==''|| Password=='')
{
swal({   
    title: "Please Fill The required fields",   
    timer: 800,   showConfirmButton: false 
});
}
else
{
$.ajax({
type: "GET",
url: "/user/save_data",
data: dataString,
cache: false,
success: function(result){
swal("Good job!", result, "success")
location.href = "http://localhost:8000/permissionsmenu1";
}
});
}
return false;
});
});
</script>
<div class="panel">
    <div class="panel-body">
        <h3 class="title-hero">
            <b>ADD USER</b>
        </h3>
        <div class="example-box-wrapper">
            <form class="form-horizontal bordered-row" action="">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Firstname</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="Firstname" placeholder="Enter Firstname ..." >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Lastname</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="Lastname" placeholder="Enter Lastname ..."  >
                    </div>
                </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Role</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="Role" placeholder="Enter Role ..." >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="Username" placeholder="Enter Username ..." >
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="Password" placeholder="Enter Password ..." >
                    </div>
                </div>
                <div class="modal-footer">
                                    <a class="btn btn-primary active" href="permissionsmenu1" role="button">Back</a>
                                    <input id="submit" type="submit" value="Save" class="btn btn-primary">
                                </div>
            </form>
        </div>
    </div>
</div>
@endsection