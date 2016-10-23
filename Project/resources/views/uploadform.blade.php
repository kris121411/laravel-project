@extends('home')



@section ('content')

<style>
    .upload_btn
    {
        float: right;
    }
    .form-control
    {
        float: left;
    }
   
</style>

<script type="text/javascript">

    $(document).ready(function(){
     //   alert();
$("#file_upload").change(function(){
                var file =  $('#file_upload').val();
                var extension = file.substr(file.length - 4)
                if(extension == 'xlsx')
                {
                    $("#view_file").prop('disabled', false);
                }
                else
                {
                    swal({title:"Invalid file format", 
                         type: "warning",
                         showOkButton: true});
                    $("#file_upload").val("");
                }
              
});


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
            <b>UPLOADED DATA</b>
        </h3>
        <div class="example-box-wrapper">
            
                    
                       
                  <span class="col-sm-6">
                    <button class="btn btn-primary" id = "view_file" name ="viewbtn">Save</button>
                       <a class="btn btn-primary active" href="permissionsmenu1" role="button">Back</a>
                    </span>
            
        </div>
    </div>
    <div class="panel-body">
    <h3 class="title-hero">
    <b>TABLE</b>
    </h3>
        <div class="example-box-wrapper">
            <table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
            
            <thead>
                <tr>
                    @foreach($header as $headers)
                        <th>{{$headers}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($content as $contents)
                <tr>
                    @foreach($contents as $cont)
                            <td>{{$cont}}</td>
                    @endforeach
                 </tr>
                 @endforeach
                
            </tbody>

            </table>
        </div>
    </div>

</div>





@endsection