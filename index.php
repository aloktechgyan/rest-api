<!DOCTYPE html>
<html>
<head>
	<title></title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
     #error-message{background-color: orange;color: red; width: 200px;position:absolute;top:0;right: 0;}
     #success-message{background-color: orange;color: green; width: 200px;position: absolute;top: 0;right: 0;}
</style>
</head>
<body>
<div class="section mt-4" style="margin: auto;width: 80%;border:1px solid #9d9c9c;min-height: 300px">
<div class="container">
	<div class="row p-2" style="background-color: #d2d2d2!important">
		<div class="col-md-9"><br>
			<h2 class="text-success">CRUD REST API</h2>
		</div>
		<div class="col-md-3">
			<label>Search By Name</label>
			<input type="text" name="search" class="form-control" id="search">
		</div>
	</div>
	<form id="addForm">
		<div class="row p-2">
			<div class="col-md-3">
				<label>Name</label>
				<input type="text" name="sname" id="sname" class="form-control">
			</div>
			<div class="col-md-3">
				<label>Class</label>
				<input type="text" name="sclass" id="sclass" class="form-control">
			</div>
			<div class="col-md-3">
				<label>Department</label>
				<input type="text" name="sdepartment" id="sdepartment" class="form-control">
			</div>
			<div class="col-md-2">
				<label>Roll</label>
				<input type="text" name="roll" id="roll" class="form-control">
			</div>

			<div class="col-md-1"><br>
				<button type="submit" id="save-button" class="btn btn-success">Save</button>
			</div>
		</div>
    </form>
	<div class="row p-2">
		<table class="table table-bordered">
			<thead>
			 	<tr>
				 	<th>ID</th>
				 	<th>NAME</th>
				 	<th>Class</th>
				 	<th>Department</th>
				 	<th>Roll</th>
				 	<th>EDIT</th>
				 	<th>Delete</th>
			 	</tr>
			</thead>
			<thead id="loadTable">
			 
			</thead>
		</table>
	</div>
</div>
</div>	



<div id="error-message" class="message"></div>
<div id="success-message" class="message"></div>

<!-- Modal 1 for  -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <p class="modal-title">Edit Records</p>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <form id="updateFrm">
       <div class="row">

       	<div class="col-md-6">
       		<label>Name</label>
       		<input type="text" name="sname" id="edit-name" class="form-control" placeholder="">
       		<input type="text" name="sid" id="edit-id" hidden="">
       </div>
       <div class="col-md-6">
       		<label>Class</label>
       		<input type="text" name="sclass" id="edit-class" class="form-control" placeholder="">
       </div>
      </div>
      
      <div class="row">
       	<div class="col-md-6">
       		<label>Department</label>
       		<input type="text" name="sdepartment" id="edit-dep" class="form-control" placeholder="">
       </div>
       <div class="col-md-6">
       		<label>Roll</label>
       		<input type="text" name="roll" id="edit-roll" class="form-control" placeholder="">
       </div>
      </div><br>
		<button type="button" class="btn btn-success float-right" id="edit-submit">Update</button>		
    </div>
</form>
  </div>
</div>

  	
<!-- JS FIle HERE -->	
<script>
	$(document).ready(function(){
		// 
		//fetch all records
		function loadTable(){
		$("#loadTable").html("");
		$.ajax({
			 url: "http://localhost/api/api-fetch-all.php",
			 type: "GET",
			 success:function(data){
			 	//console.log("table Records"+data);
			 	
			 	if(data.status==false){
			 		$("#loadTable").append("<tr><td colspan='8'><h2>No Recor Founds</h2></td></tr>");
			 		debugger
			 	}else{
			 		$.each(data, function(key,value){
			 			$("#loadTable").append("<tr>"
			 										+"<td>"+value.id+"</td>"+
			 										"<td>"+value.name+"</td>"+
			 										"<td>"+value.class+"</td>"+
			 										"<td>"+value.department+"</td>"+
			 										"<td>"+value.roll+"</td>"+
			 										"<td><button type='button' class='btn btn-success edit-btn' data-eid='"+value.id+"'>Edit</button></td>"+
			 										"<td><button type='button' class='btn btn-danger delete-btn' data-id='"+value.id+"'>Delete</button></td>"+
			 										
			 										"</tr>");			
			 		});
			 	}
			 }
		});
		}
	



// show success or Error Message
function message(message,status){
if(status==true){
	$("#success-message").html(message).slideDown();
		$("#error-message").slideUp(); //hide
		setTimeout(function(){
				$("#success-message").slideUp();
		},4000);

}else if(status==false){
    $("#error-message").html(message).slideDown();
	$("#success-message").slideUp();
	setTimeout(function(){
			$("#error-message").slideUp();
	},4000);
}
}




	// funtion for form jata to json object
	function jsonData(targetForm){
		var arr=$(targetForm).serializeArray();
		 //console.log(arr);
		 //conver javascrpit to object
		 var obj={};
		 for(var a=0;a<arr.length;a++){
		 	if(arr[a].value==""){
		 		// for check that all fom field are filled not empty
		 		return false;
		 	}
		 	obj[arr[a].name]=arr[a].value;
		 }
		 //console.log(obj); // js object data

		 //now json convert
		 var json_string=JSON.stringify(obj);
		 //console.log(json_string);
		 //Note : there is no any function to convert form data into json
        return json_string;
	}
/*------------[EDIT Record]------------*/
	$(document).on("click",".edit-btn", function(){
		$("#myModal").show();
		var studentId=$(this).data("eid");
		// convert json (no functin so convert object then json)
		var obj={ sid:studentId };
		// js function  object to Json file (striify())
		var myJSON=JSON.stringify(obj);
		//console.log(myJSON);

		$.ajax({
			 url: "http://localhost/api/api-fetch-single.php",
			 type: "POST",
			 data: myJSON,
			 success:function(data){
				 	console.log(data);
					$("#edit-id").val(data[0].id);
					$("#edit-name").val(data[0].name);
					$("#edit-class").val(data[0].class);
					$("#edit-dep").val(data[0].department);
					$("#edit-roll").val(data[0].roll);
				}
			});
		});

	$(document).on("click",".close", function(){
		$("#myModal").hide();
	});

	//load Table
loadTable();
/*=========[insert record]==========*/
	$("#save-button").on("click",function(e){
		e.preventDefault();
		//form data conver into json (using Array)
		 var jsonObj=jsonData("#addForm");
		    console.log("form data"+jsonObj);
		    debugger
		    if(jsonObj==false){
		    	message("All Field are required",false);
		    }else{
		    	$.ajax({
				 url: "http://localhost/api/api-insert.php",
				 type: "POST",
				 data: jsonObj,
				 success:function(data){
				 	message(data.message, data.status);
				 	if(data.status==true){
				 		loadTable();
				 		$("#addForm").trigger("reset");
				 		}
					}
				});
		    }

		});

	/*=========[Update record]==========*/
	$("#edit-submit").on("click",function(e){
		e.preventDefault();
		//form data conver into json (using Array)
		 var jsonObj=jsonData("#updateFrm");
		    console.log("Updated form data"+jsonObj);
		    //debugger
		    if(jsonObj==false){
		    	message("All Field are required",false);
		    }else{
		    	$.ajax({
				 url: "http://localhost/api/api-update.php",
				 type: "POST",
				 data: jsonObj,
				 success:function(data){
				 	message(data.message, data.status);
				 	if(data.status==true){
				 		loadTable();
				 		$("#myModal").hide();
				 		}
					}
				});
		    }

		});


//Delete
$(document).on("click",".delete-btn",function(){
	if(confirm(" Do you wan to delete this Record? ")){
		
		var studentId=$(this).data("id");
		var obj={sid: studentId};

		var myJSON=JSON.stringify(obj);
		
		var row=this;
		
		$.ajax({
			 url: "http://localhost/api/api-delete.php",
			 type: "POST",
			 data: myJSON,
			 success:function(data){
				 	console.log(data);
					message(data.message, data.status);
				 	if(data.status==true){
				 			$(row).closest("tr").fadeOut();
				 		}
					}
			});
	}

})

$("#search").on("keyup", function(){
	var search_term= $(this).val();
	$("#loadTable").html("");
	debugger
	$.ajax({
		url: 'http://localhost/api/api-search.php?search=' +search_term,
		type: "GET",
		success:function(data){
			if(data.status==false){
			 		$("#loadTable").append("<tr><td colspan='8'>"+data.message+"</td></tr>");
			 		debugger
			 	}else{
			 		$.each(data, function(key,value){
			 			$("#loadTable").append("<tr>"
			 										+"<td>"+value.id+"</td>"+
			 										"<td>"+value.name+"</td>"+
			 										"<td>"+value.class+"</td>"+
			 										"<td>"+value.department+"</td>"+
			 										"<td>"+value.roll+"</td>"+
			 										"<td><button type='button' class='btn btn-success edit-btn' data-eid='"+value.id+"'>Edit</button></td>"+
			 										"<td><button type='button' class='btn btn-danger delete-btn' data-id='"+value.id+"'>Delete</button></td>"+
			 										
			 										"</tr>");			
			 		});
			 	}
	}
});

});

});
</script>

</body>
</html>