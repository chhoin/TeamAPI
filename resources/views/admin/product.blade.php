@extends('app') @section('head')
<link rel="stylesheet"
	href="{{ asset('asset/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
<link rel="stylesheet"
	href="{{ asset('asset/sweetalert/sweetalert.css') }}">
@stop @section('body')
<div class='container-fluid'>
	<div class='row'>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<div class="panel panel-primary">
				<div class="panel-heading ">menu</div>
				<div class="panel-body">
					<ul class="nav  bg-info">
						<li><a href="{{ URL::to('/article') }}">Article</a></li>
						<li><a href="{{ URL::to('/category') }}">Category</a></li>
						<li><a href="{{ URL::to('/product') }}">Product</a></li>
						<li><a href="#">Log Out</a></li>
					</ul>
				</div>

			</div>
		</div>

		<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">

			<!-- inser and search-->
			<div class="row">
				<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#formAdd">Insert Form</button>

				</div>

				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="padding-left: 50px">
					<select id="limitplaylist" onclick="chooseProduct();"
						class="form-control">
						<option value="5" selected="selected">5</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
				</div>
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div
						class="input-group ">
							<input type="text" class="form-control" id="search" name="search" value="" placeholder="Search for..."> 
							
						<span class="input-group-btn"> 
							<input type="button"  onclick="mySearchProduct();" value="search" class="btn btn-success">
						</span>
					</div>
					<small id="checksearch" class="msg" style="color:red"></small>

				</div>
			</div>
			<br />
			<!-- Table -->
			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading ">List Article</div>
					<div class="panel-body">
						<table class="table table-condensed">
							<thead>
								<tr class="success">
									<th width="10%">ID</th>
									<th width="20%">Name</th>
									<th width="20%">Description</th>
									<th width="10%">Prize</th>
									<th width="10%">Public Date</th>
									<th width="10%">Updated Date</th>
									<th width="20%">Activity</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>

						<div class="text-center">
							<div id="pagination"></div>
						</div>

					</div>
				</div>
			</div>


		</div>


	</div>

	<!-- alert veiw -->
	<div class='modal fade' id='modelView' role='dialog'>
		<div class='modal-dialog'>
			<!-- Modal content-->
			<div class='modal-content'>
				<div class='modal-header' style="background-color: #5cb85c;">
					<button type='button' class='close' data-dismiss='modal'>&times;</button>
					<h4 class='modal-title'>View Product</h4>
				</div>
				<div class='modal-body'>
					<h2 id="productName"></h2>
					<h3 id="productPrize"></h3>
					<div id="productDes"></div>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
				</div>
			</div>

		</div>
	</div>

	<!-- Modal Form -->
	<div class="modal fade" id="formAdd" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" style="background-color: #5cb85c;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Form</h4>
				</div>
				<div class="modal-body">

					<form action="" id="formstudent" enctype="multipart/form-data">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="input-text" class="col-sm-3 control-label">Name:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="name" name="name" value="" required="required">
									<input type="hidden" class="form-control" id="pro_id" name="id" value="" >
									<small id="checkproductname" class="msg" style="color:red"></small>
								</div>
							</div>
							<div class="form-group">
								<label for="input-text" class="col-sm-3 control-label">Description:</label>
								<div class="col-sm-9">
									<textarea class="form-control" rows="5" id="description" name="description" value="" required="required"></textarea>
									<small id="checkproductdescription" class="msg" style="color:red"></small>
								</div>
							</div>
							<div class="form-group">
								<label for="input-text" class="col-sm-3 control-label">Prize:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="prize" name="prize" value="" required="required">
									<small id="checkproductprize" class="msg" style="color:red"></small>
								</div>
							</div>
							
						</div>
					</form>

				</div>
				<div class="modal-footer">
					<button type="button" id="myButton" onclick="insertProduct();" class="btn btn-success">Save</button>
					<button type="button" onclick="clearForm();" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	@stop @section('foot')
	<script
		src="{{ asset('asset/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
	<script src="{{ asset('asset/js/bootpage.js') }}"></script>
	<script src="{{ asset('asset/sweetalert/sweetalert.min.js') }}"></script>
	<script type="text/javascript">		
		var limit=0;
		var offset=1;
		var totalofrecord =0;
		var numofpage=1;
		var url="{{ URL::to('/') }}";

		/**
		* choice for you search or list
		**/
		 function chooseProduct() {
			var key =$("#search").val();
			if(key.length == 0){
				mystart();
			}else{
				mySearchProduct();
			}
		} 

	 	/*
		* start process
		*/
		mystart();
		function mystart() {
			limit=$("#limitplaylist").val();
			//alert(limit);
			 $.ajax({   
		            url: url+'/product/page/'+offset+'/item/'+limit,
		            type: 'get',
		            contentType: 'application/json;charset=utf-8',
		            success: function(data) {
		            	//console.log(data);
		            	if(data.STATUS == true) {
		            		totalofrecord=data.PAGINATION.TOTALRECORD;
			            	numofpage=data.PAGINATION.TOTALPAGE;
			            	listAllProduct(1);
			            	loadPaginationProduct();
			            	
			            }
		            	
		            },
		            error: function(data) {
		            	alert("1start () unsuccess data");
		            }
		        });	  
	    	 
		}	

		/*
		* bootpage show pagination
		*/
		function loadPaginationProduct() {
			$('#pagination').bootpag({
		        total: numofpage,
		        maxVisible: 5,
		        leaps: true,
		        firstLastUse: true,
		        first: '&#8592;',
		        last: '&#8594;',
		        wrapClass: 'pagination',
		        activeClass: 'active',
		        disabledClass: 'disabled',
		        nextClass: 'next',
		        prevClass: 'prev',
		        lastClass: 'last',
		        firstClass: 'first'
		    }).on("page", function(event, num) {
		    	listAllProduct(num);
		    }); 
		}	

		/*
		* listAllProduct
		*/
		function listAllProduct(offset) {
	    	$.ajax({
	    		url: url+'/product/page/'+offset+'/item/'+limit,
	            type: 'get',
	            contentType: 'application/json;charset=utf-8',
	            success: function(data) {
		            
	            	if(data.STATUS == true) {
	            		$("tbody").html(listPlaylistDetail(data));
	            	}
	            },
	            error: function(data) {
	            	alert("listAll() unseccess data");
	            }
	        });	    	
			   
		}	

		/*
		* list product detail
		*/
		function listPlaylistDetail(data) {
			var str="";
				for(var i=0; i<data.DATA.length ; i++) {
					str +="<tr>"
							+"<td>"+i+"</td>"
							+"<td>"+data.DATA[i].pro_name+"</td>"
							+"<td>"+data.DATA[i].pro_description+"</td>"
							+"<td>"+data.DATA[i].pro_prize+"</td>"
							+"<td>"+data.DATA[i].created_at+"</td>"
							+"<td>"+data.DATA[i].updated_at+"</td>"
							+"<td>"
								+"<a title='Add Product' data-toggle='modal' data-target='#modelView' onclick=viewProduct('"+data.DATA[i].pro_id+"') class='btn btn-primary'>View</a> &nbsp;"
								+"<a title='edit playlist' data-toggle='modal' data-target='#formAdd' onclick=listProduct('"+data.DATA[i].pro_id+"') id='showFrmUpdatePlaylist' class='btn btn-success'>Edit</a> &nbsp;"              
								+"<a title='delete playlist'  onclick=deleteProduct('"+data.DATA[i].pro_id+"') class='btn btn-danger'>Delete</a> &nbsp;"    
							+"<td>"
						+"</tr>" ;
				}
					
				return str;
		}

		/*
		* viewProduct
		*/
		function listProduct(pid) {
			$.ajax({
				url: url+'/product/'+pid,
		        type: 'get',
		        contentType: 'application/json;charset=utf-8',
		        success: function(data){
		        	if(data.STATUS == true) {
		        		$("#pro_id").val(data.DATA.pro_id);
		        		$("#name").val(data.DATA.pro_name);
		        		$("#description").val(data.DATA.pro_description);
		        		$("#prize").val(data.DATA.pro_prize);
		   				$("#myButton").text("Update").attr("onclick", "updateProductProcess()");
		        	}
		        	
		        },
		        error: function(data) {
		        	alert("view playlist unseccess data");
		        }
		    });	
		}

		/*
		* viewProduct
		*/
		function updateProductProcess() {
			var id = $("#pro_id").val();
			var name = $("#name").val();
			var des = $("#description").val();
			var prize = $("#prize").val();
			
			if(validatProductName() && validatProductDes() && validatProductPrize() ){
				$.ajax({
		           url: url+'/product/'+id+'?pro_name='+name+'&pro_description='+des+'&pro_prize='+prize,
		           type: 'put',
		          contentType:false,
		           contentType: 'application/json;charset=utf-8',
		           //data: JSON.stringify(JSONObject),
		           success: function(data) {
			           	if(data.STATUS == true){
			           		mystart();
			           		swal("Product Was Update", "You clicked the button!", "success");
				          
			           	}else if(data.STATUS = 'invalid') {
			           		$("#checkproductname").text(data.ERROR.pro_name);
			           		$("#checkproductdescription").text(data.ERROR.pro_description);
			           		$("#checkproductprize").text(data.ERROR.pro_prize);
				        }else{
			           		alert("Update error check url");
				         }
		          
		           },
		           error: function(data){
		           	alert("creation unsuccess data");
		           }
		       });	
			} 

		}

		/*
		* insert product
		*/
		function insertProduct(){
			var name = $("#name").val();
			var des = $("#description").val();
			var prize = $("#prize").val();
			
			if(validatProductDes() && validatProductPrize() ){
				
				$.ajax({
		           url: url+'/product?pro_name='+name+'&pro_description='+des+'&pro_prize='+prize,
		           type: 'post',
		          contentType:false,
		           contentType: 'application/json;charset=utf-8',
		           //data: JSON.stringify(JSONObject),
		           success: function(data) {
			           	if(data.STATUS == true){
			           		mystart();
			           		swal("Product Was created", "You clicked the button!", "success");
				            myClear();
			           	}else if(data.STATUS = 'invalid') {
			           		$("#checkproductname").text(data.ERROR.pro_name);
			           		$("#checkproductdescription").text(data.ERROR.pro_description);
			           		$("#checkproductprize").text(data.ERROR.pro_prize);
				        }else{
			           		alert("insert error check url");
				         }
		          
		           },
		           error: function(data){
		           	alert("creation unsuccess data");
		           }
		       });	
			}    	
		}

		/*
		* clearForm
		*/
		function clearForm() {
			myClear();
			$("#myButton").text("Save").attr("onclick", "insertProduct()");
		}
		
		/*
		* myClear
		*/
		function myClear() {
			$("#pro_id").val("");
			$("#name").val("");
			$("#description").val("");
			$("#prize").val("");
		}

		/*
		* viewProduct
		*/
		function viewProduct(pid) {
			//alert(pid);
			$.ajax({
				url: url+'/product/'+pid,
		        type: 'get',
		        contentType: 'application/json;charset=utf-8',
		        success: function(data){
		        	if(data.STATUS == true) {
			        	
		        		$("#productName").html(data.DATA.pro_name);
		        		$("#productPrize").html(data.DATA.pro_prize);
		        		$("#productDes").html(data.DATA.pro_description);
		   
		        	}
		        	
		        },
		        error: function(data) {
		        	alert("view playlist unseccess data");
		        }
		    });	
		}
		
		/*
		* search product
		*/
		function mySearchProduct() {
			var key =$("#search").val();
			var characterReg = /^[\ba-zA-Z0-9\s-_.]+$/;
			
			if(key.length > 1 && characterReg.test(key)) {
				
				$("#search").css("border", "solid 1px green");
				$("#checksearch").text("");
				
				 $.ajax({ 
					 url: url+'/product/page/'+offset+'/item/'+limit+'/'+key,
			            type: 'get',
			            contentType: 'application/json;charset=utf-8',
			            success: function(data) {
				            
			            	if(data.STATUS == true) {
				            	
				            	//alert(data.PAGINATION.TOTALRECORD);
				            	//alert(data.PAGINATION.TOTALPAGE);
				            	
			            		totalofrecord = data.PAGINATION.TOTALRECORD;
				            	numofpage = data.PAGINATION.TOTALPAGE;
				            	loadPaginationProduct();
			            		$("tbody").html(listPlaylistDetail(data));
			            		//alert("search");
			            	}else {
			            		swal("Search Not Found");
				            }
			            },
			            error: function(data) {
			            	alert("listAll() unseccess data");
			            }
				   }); 
			}else{
				$("#search").css("border", "solid 1px red");
				$("#checksearch").text("Require, at least 2, less than 100, not allow special symbol");
			}
			

		}

		/*
		* delete product
		*/
		function deleteProduct(pid) {
			swal({   
				title: "Are you sure?",   
				text: "You will not be able to recover this Product!",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Yes, delete it!",   
				closeOnConfirm: false }, function() {   
					
					 $.ajax({  
						 	url: url+'/product/'+pid,
					       type:'delete',
					       contentType: 'application/json;charset=utf-8', // type of data
					       success: function(data) { 
					    	   	if(data.STATUS ==  true ) {
					    	   		mystart();
									swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
					    	   	}
					    	   	
					          console.log("Success..." + data);
					       }  ,  
					   		error: function(data) {
					   		console.log("ERROR..." + data);
					   	}
					   });
					
					
				});
		}

		/*
		* validate validatProductName
		*/
		function validatProductName(){
			var name= $("#name").val();
			var characterReg = /^[\sa-zA-Z0-9-_]{3,100}$/;
			    if(!characterReg.test(name)) {
			    	$("#name").css("border", "solid 1px red");
			    	$("#checkproductname").text("Require, at least 3, less than 100, not allow special symbol");
			    	   return false;
			    
			    }else{
			    	$("#name").css("border", "solid 1px green");
			    	$("#checkproductname").text("");
			    	return true;
			    }
		}
		
		/*
		* validate validatProductDes
		*/
		function validatProductDes(){
			var name= $("#description").val();
			var characterReg = /^[\sa-zA-Z0-9!@#$%^&*()-_=+\[\]{}|\\:?/.,]{3,255}$/;
			    if(!characterReg.test(name)) {
			    	$("#description").css("border", "solid 1px red");
			    	$("#checkproductdescription").text("Require and at least 3 charactors less than 255 charactors");
			    	   return false;
			    
			    }else{
			    	$("#description").css("border", "solid 1px green");
			    	$("#checkproductdescription").text("");
			    	return true;
			    }
		}


		/*
		* validate validatProductPrize
		*/
		function validatProductPrize(){
			var name= $("#prize").val();
			var characterReg = /^[\s0-9$]{1,100}$/;
			    if(!characterReg.test(name)) {
			    	$("#prize").css("border", "solid 1px red");
			    	$("#checkproductprize").text("Require less than 100 charactors and Number only");
			    	   return false;
			    
			    }else{
			    	$("#prize").css("border", "solid 1px green");
			    	$("#checkproductprize").text("");
			    	return true;
			    }
		}
	</script>
	@stop