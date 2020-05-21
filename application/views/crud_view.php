 <html>  
 <head>  
   <title></title> 
   <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
     <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css">
   <style>  
           body  
           {  
                margin:0;  
                padding:0;  
                background-color:#f1f1f1;  
           }  
           .box  
           {  
                width:900px;  
                padding:20px;  
                background-color:#fff;  
                border:1px solid #ccc;  
                border-radius:5px;  
                margin-top:10px;  
           }  
      </style>  
 </head>  
 <body>  
      <div class="container box ">  
           <h3 align="center"></h3><br />  
            <div class="">
                  <button class="btn btn-primary add_user" id="add_user">Add Task</button>
                  
                </div>
           <div class="table-responsive">  
                <br /> 
                
                <table id="user_data" class="table table-bordered table-striped">  
                     <thead>  
                          <tr>  
                               <th>Task Name</th>  
                               <th>User Name</th>  
                               <th>Action</th>  
                                
                          </tr>  
                     </thead>  
                </table>  
           </div>  
      </div>
      <div class="modal" id= "editDataModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="javascript:void(0);" name = "edit_data">
          <div class="all_users_name">
            
          </div>
        <input type="hidden" name="edit_id" id="edit_id">
      </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick="saveEditData()">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id= "addDataModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      <div class="modal-body">
        <form action="javascript:void(0);" name = "add_data" class="add_data">

        <label for="name">Task Name:</label><br>
        <input type="text" id="task_name" class="form-control col-sm-4"  name="task_name" ><br>
        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="saveAddData()">Save changes</button> -->
       
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>  
  
 <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.min.js"></script>
 <script type="text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script>
 <script type="text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js"></script>


 
 <script type="text/javascript" language="javascript" >  
  var dataTable='';
 $(document).ready(function(){ 
 
      dataTable = $('#user_data').DataTable({  

        //"processing": true,
        "ajax": {
            "url": "http://localhost/ci/Crud/fetch_user",
            "type": "POST"
        },
        "columns": [
            { "data": "task_name" },
            { "data": "users" },
           
            {"defaultContent":""},
        ],       
         "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
           $('td:eq(2)', nRow).html( '<button onClick="editData('+aData.id+')"><i class="fa fa-users" aria-hidden="true"></i></button> <button onClick="deleteData('+aData.id+')"><i class="fa fa-trash" aria-hidden="true"></i></button> ' );
               // $('td:eq(3)', nRow).html( '<b>A</b>' );
           
      }  
 });  

});

 function editData(id){
        $('#editDataModal').modal('show');
        $('.all_users_name_edit').remove();
        $.ajax({
          url:"http://localhost/ci/Crud/getEditUser",
          type:"post",
          dataType:"JSON",
          data:{action:'geteditdata',id:id},
          success:function(data){
            console.log(data);
            var users_name='';
            $.each(data,function(idx,elem){
              $('.all_users_name').append('<button class="all_users_name_edit" onClick="save_user_task('+elem.id+','+id+')">'+elem.name+'</button>');
            })
            
          }
        })
        $('#edit_id').val(id);
      } 
      function save_user_task(userid,taskid){
        $.ajax({
          url:"http://localhost/ci/Crud/saveUserToTask",
          type:"post",
          dataType:"JSON",
          data:{ userid:userid, taskid:taskid },
          success:function(data){
            console.log(data);
          }
        });
      }

      function saveEditData(){
        //alert("here")
        $('#editDataModal').modal('hide');
        dataTable.ajax.reload();
      }
      function deleteData(id){
        $.ajax({
          url:"http://localhost/ci/Crud/deleteTask",
          type:"post",
          data:{action:'delete',id:id},
          success:function(data) {

            dataTable.ajax.reload();
          }
        })
      }
      $('#add_user').click(function(){
        $('#addDataModal').modal('show');
      });
      function saveAddData(){

      }

    $("form[name='add_data']").validate({
    rules: {
      task_name: "required",
      
    },
    messages: {
      task_name: "This field is required."
    },
    submitHandler: function(form) {
      var task_name = $('#task_name').val();
    ///  var last_name = $('#alast_name').val();
      $.ajax({
        url:"http://localhost/ci/Crud/addTask",
        type:"POST",
        dataType:"JSON",
        data:{task_name:task_name},
        success:function(data){
          $('.add_data')[0].reset()
          dataTable.ajax.reload();
          $('#addDataModal').hide();
        }
      })
    }
  });

 </script>

</body> 
</html>  