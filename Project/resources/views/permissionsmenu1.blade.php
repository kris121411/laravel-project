@extends('home')


@section ('content')
<!-- Sparklines charts -->

<!-- Data tables -->

<!--<link rel="stylesheet" type="text/css" href="../../assets/widgets/datatable/datatable.css">-->
<script type="text/javascript" src="{{ asset("/bower_components/monarch/assets/widgets/datatable/datatable.js")}}"></script>
<script type="text/javascript" src="{{ asset("/bower_components/monarch/assets/widgets/datatable/datatable-bootstrap.js")}}"></script>
<script type="text/javascript" src="{{ asset("/bower_components/monarch/assets/widgets/datatable/datatable-responsive.js")}}"></script>
<script type="text/javascript">

    /* Datatables responsive */



    $(document).ready(function() {
        $('#datatable-responsive').DataTable( {
            responsive: true
        } );
    } );

    $(document).ready(function() {
        $('.dataTables_filter input').attr("placeholder", "Search...");
        $("#close").click(function(){
                location.reload();
        });
        
    });
    $(document).ready(function() { // get data per row in a table
        $("#update_user").click(function(){
        $("#datatable-responsive").on('click','tr',function(e){
           var data = e.currentTarget.cells;
           var idd;
             $(data).each(function(key, value){
                if(key == 0)
                {
                    idd = value;
                }
             });
             console.log(idd);
            e.preventDefault();
        var id = e.toElement.value
        $.ajax({
        type: "GET",
        url: "/user/get_data_by_id",
        data: "id="+id,
        cache: false,
        success: function(result){
            var value = result.split("_")
             $(value).each(function(key, value) {
                    var set_value = value;
                    if(key ==0)
                    $("#uid").val(set_value);
                    if(key ==1)
                    $("#Firstname").val(set_value);
                    if(key ==2)
                    $("#Lastname").val(set_value);
                    if(key ==3)
                    $("#Role").val(set_value);
                    if(key ==4)
                    $("#Username").val(set_value);
                    if(key ==5)
                    $("#Password").val(set_value);
                     if(key ==6)
                     {
                        if(set_value==1)
                            $("#is_active").prop('checked', true);
                        else
                             $("#is_active").prop('checked', false);
                     }
                    
                });
           
        }
        });


        }); 
      
       });

        $("#submit_update").click(function(){  // update data in a modal form
        var Firstname = $("#Firstname").val();
        var Lastname = $("#Lastname").val();
        var Role = $("#Role").val();
        var Username = $("#Username").val();
        var Password = $("#Password").val();
        var id = $("#uid").val();
        var is_active = $("#is_active").prop('checked');
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'Firstname='+ Firstname + '&Lastname='+ Lastname + '&Role='+ Role + '&Username='+ Username + '&Password='+ Password + '&id='+ id + '&is_active='+ is_active;

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
         $("#download").click(function(){ //download data
             $.ajax({
            type: "GET",
            url: "/download/user",
            cache: false,
            success: function(result){
            //swal("Good job!", result, "success")
            }

            });
         });
    });

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
});

</script>

<style>

.col-sm-form {
    width: 33%;
}
.odd:hover,.even:hover
{
    color: #04c;
}
.crud_buttons{
    float: left;
}
.upload_btn
    {
        float: right;
    }
    .form-control
    {
        float: left;
    }

</style>


<div class="panel">
<div class="panel-body">
<h3 class="title-hero">
    <h2>List of Users</h2>
      <a class="btn btn-primary active" href="permissionmodal" role="button">Add</a>
      <a class="btn btn-primary active" href="permissionsmenu1" role="button">Refresh</a>
      <a href="{{ URL::to('downloadExcel/xlsx') }}"><button class="btn btn-primary active">Download</button></a>
      <a href="{{ URL::to('downloadTemplate/xlsx') }}"><button class="btn btn-primary active">Template</button></a>        
</h3>

        <div class="example-box-wrapper">
             <form class="form-horizontal bordered-row" action="{{ URL::to('importExcel/xlsx') }}" method="POST" enctype="multipart/form-data" onsubmit="return mySubmitFunction()">
                 <div class="form-group">
                        <div class="col-sm-form">
                            <input type="file" class="form-control" id="file_upload" name = "user_file_upload" >
                        </div>
                        <div>
                            <button class="btn btn-primary" id = "view_file" name ="viewbtn" disabled >View</button>
                        </div>
                </div>
            </form>
        </div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><b>UPDATE USER</b></h4>
                                </div>
                                <div class="modal-body">
                                   <div class="panel">

        <div class="example-box-wrapper">
            <form class="form-horizontal bordered-row" action="/user/save_data" method="post">
            <div class="form-group">
                    <label class="col-sm-3 control-label">ID</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="uid" placeholder="" disabled>
                    </div>
                </div>
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
                 <div class="form-group">
                    <label class="col-sm-3 control-label">Is Active</label>
                    <div class="col-sm-6">
                        <div class="checkbox checkbox-success">
                            <label>
                                <input type="checkbox" id="is_active" value = "" class="custom-checkbox">

                                </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                                    <button id="close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button id="submit_update" type="button"  class="btn btn-primary">Update</button>
                                </div>
            </form>
        </div>

</div>
                                </div>
                                
                            </div>
                        </div>
                    </div>



<div class="example-box-wrapper">
<table id="datatable-responsive" class="table table-striped table-bordered responsive no-wrap" cellspacing="0" width="100%">
<thead>

<tr>
<th>ID</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Role</th>
    <th>Username</th>
    <th>Password</th>l
    <th>Active</th>
    <th>Action</th>
</tr>
</thead>

<tfoot>
<tr><th>ID</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Role</th>
    <th>Username</th>
    <th>Password</th>
    <th>Active</th>
    <th>Action</th>
</tr>
</tfoot>
<tbody>
    @foreach($users as $user)
     <tr>
    <td>{{$user['id']}}</td>
    <td>{{$user['firstname']}}</td>
     <td>{{$user['lastname']}}</td>
     <td>{{$user['role']}}</td>
     <td>{{$user['username']}}</td>
     <td>{{$user['password']}}</td>
      <td>{{$user['is_active']}}</td>
     <td><button  id = "update_user" class="btn btn-primary active" data-toggle="modal" data-target=".bs-example-modal-lg" value="{{$user['id']}}">Update</button></td>
 </tr>
    @endforeach
</tbody>

</table>
</div>
</div>
</div>


@endsection
