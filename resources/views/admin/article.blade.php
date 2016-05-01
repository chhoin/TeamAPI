@extends('app')

@section('head')
		<link rel="stylesheet" href="{{ asset('asset/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('asset/sweetalert/sweetalert.css') }}">
@stop


@section('body')
<div class='container-fluid'>
	<div class='row'>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" >
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
			<div class="row">
				<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#formAdd">Insert Form</button>
				</div>	
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="padding-left: 50px">
					<select id="limitplaylist" onclick="chooseArticle();" class="form-control">
						<option value="5" selected="selected">5</option>
						<option value="20">20</option>
						<option value="30">30</option>
						<option value="50">50</option>
					</select>
				</div>
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="input-group ">
						<input type="text" class="form-control" id="search" name="search" value="" placeholder="Search for..."> 
							<span class="input-group-btn"> 
								<input type="button"  onclick="SearchArticle();" value="search" class="btn btn-success">
							</span>
					</div>
					<small id="checksearch" class="msg" style="color:red"></small>
				</div>
			</div>
			<br/>

			<!-- Table -->
			<div class="row" >
				<div class="panel panel-primary">
					<div class="panel-heading ">List Article
					</div>
					<div class="panel-body">
						<table class="table table-condensed">
							<thead>
								<tr class="success">
									<th width="5%">ID</th>
									<th width="20%">Title</th>
									<th width="20%">Description</th>
									<th width="10%">Category</th>
									<th width="10%">Publish Date</th>
									<th width="10%">Image</th>
									<th width="25%">Activity</th>
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
</div>
<!-- alert veiw -->
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
						<!-- Input name -->
						<div class="form-group">
							<label for="input-text" class="col-sm-2 control-label">Title</label>
							<div class="col-sm-10">
								<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
								<input type="hidden" class="form-control" id="art_id" name="art_id" value="" required="required">
								<input type="text" class="form-control" id="title" name="title" value=""  required="required">
								<small id="checktitle" class="msg" style="color:red"></small>
							</div>
						</div>
						<div class="form-group" >
							<label for="input-text" class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<textarea class="form-control" rows="5" id="editor" name="description" value="" required="required"></textarea>
								<small id="checkdescription" class="msg" style="color:red"></small>
							</div>
						</div>
						<div class="form-group" >
							<label for="input-text" class="col-sm-2 control-label">Category</label>
							<div id="list" class="col-sm-10">
								<select class="form-control" id="category" name="category">
									
								</select>
								<small id="checkcategory" class="msg" style="color:red"></small>
							</div>
						</div>
						<div class="form-group" >
							<label for="input-text" class="col-sm-2 control-label">Image</label>
							<div class="col-sm-10">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100px; height:100px;">
											
									</div>
									<div>
										<span class="btn btn-default btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" id="ART_IMG"   name="ART_IMG">
											<input type="hidden" class="form-control" id="OLD_IMG"   name="OLD_IMG"  >
										</span>
										<a href="#" id="re_image" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
								{!! $errors->first('ART_IMG','<span class="text-danger">:message</span>') !!}
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="myButton" onclick="insertArticle();listCategory();" class="btn btn-success">Save</button>
				<button type="button" onclick="clearForm();" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- End alert view -->
@stop
@section('foot')
	<script src="{{ asset('asset/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
	<script src="{{ asset('asset/ckeditor/ckeditor.js') }}"></script>
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
		function chooseArticle() 
		{
			var key =$("#search").val();
			if(key.length == 0)
			{
				mystart();
			}
			else
			{
				SearchArticle();
			}
		}

		/**
		* start 
		**/
		mystart();
		function mystart() 
		{
			limit=$("#limitplaylist").val();
			$.ajax({
				url: url+'/article/page/'+offset+'/item/'+limit,
				type: 'get',
				contentType: 'application/json;charset=utf-8',
				success: function(data) 
				{
		            if(data.STATUS == true) 
		            {
		            	totalofrecord=data.PAGINATION.TOTALRECORD;
			            numofpage=data.PAGINATION.TOTALPAGE;
			            listAllArticle(1);
			            loadPaginationArticle();
			            	
			           }
			    },
			    error: function(data) 
			    {
			    	alert("1start () unsuccess data");
			    }
			});
		} 

		/*
		* bootpage show pagination
		*/
		function loadPaginationArticle() 
		{
			$('#pagination').bootpag(
			{
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
		    	listAllArticle(num);
		    }); 
		}	

		/*
		* listAllArticle
		*/
		function listAllArticle(offset) 
		{
	    	$.ajax(
	    	{
	    		url: url+'/article/page/'+offset+'/item/'+limit,
	            type: 'get',
	            contentType: 'application/json;charset=utf-8',
	            success: function(data) 
	            {
	            	if(data.STATUS == true) 
	            	{
	            		$("tbody").html(listPlaylistDetail(data));
	            	}
	            },
	            error: function(data) 
	            {
	            	alert("listAll() unseccess data");
	            }
	        });	    	
			   
		}

		/*
		* list product detail
		*/
		function listPlaylistDetail(data) {
			var str="";
				for(var i=0; i<data.DATA.length; i++) {
					str +="<tr>"
							+"<td>"+data.DATA[i].art_id+"</td>"
							+"<td>"+data.DATA[i].title+"</td>"
							+"<td>"+data.DATA[i].description+"</td>"
							+"<td>"+data.DATA[i].image+"</td>"
							+"<td>"+data.DATA[i].created_at+"</td>"
							+"<td>"+data.DATA[i].updated_at+"</td>"
							+"<td>"
								+"<a title='Add Article' data-toggle='modal' data-target='#modelView' onclick=viewArticle('"+data.DATA[i].art_id+"') class='btn btn-primary'>View</a> &nbsp;"
								+"<a title='edit playlist' data-toggle='modal' data-target='#formAdd' onclick=listArticle('"+data.DATA[i].art_id+"') id='showFrmUpdatePlaylist' class='btn btn-success'>Edit</a> &nbsp;"              
								+"<a title='delete playlist'  onclick=deleteArticle('"+data.DATA[i].art_id+"') class='btn btn-danger'>Delete</a> &nbsp;"    
							+"<td>"
						+"</tr>" ;
				}
					
				return str;
		}	

		/*
		* viewProduct
		*/
		function listArticle(pid) {
			$.ajax({
				url: url+'/article/'+pid,
		        type: 'get',
		        contentType: 'application/json;charset=utf-8',
		        success: function(data){
		        	if(data.STATUS == true) {
		        		$("#art_id").val(data.DATA.art_id);
		        		$("#title").val(data.DATA.title);
		        		CKEDITOR.instances['editor'].setData(data.DATA.description);
		   				$("#myButton").text("Update").attr("onclick", "updateArticle()");
		        	}
		        	
		        },
		        error: function(data) {
		        	alert("view playlist unseccess data");
		        }
		    });	
		}

		/*
		* insert product
		*/
		function insertArticle(){
			var title = $("#title").val();
			var des = CKEDITOR.instances.editor.getData();
			var cate = $("#category").val();
			
			if(validateTitle() && validateArticleDes() && validateArticleCategory()){
				$.ajax({
		        	url: url+'/article?title='+title+'&description='+des+'&category='+cate,
		            type: 'post',
		            contentType: 'application/json;charset=utf-8',
		            //data: JSON.stringify(JSONObject),
		            success: function(data) {
			           	if(data.STATUS == true){
			           		mystart();
			           		swal("Article Was created", "You clicked the button!", "success");
				            myClear();
			           	}
			           	else if(data.STATUS = 'invalid') {
			           		$("#checktitle").text(data.ERROR.title);
			           		$("#checkdescription").text(data.ERROR.description);
			           		$("#checkcategory").text(data.ERROR.category);
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
		* update article
		*/
		function updateArticle() {
			var id = $("#art_id").val();
			var title = $("#title").val();
			var des = CKEDITOR.instances.editor.getData();
			if(validateTitle() && validateArticleDes() && validateArticleCategory() ){
				$.ajax({
		           	url: url+'/article/'+id+'?title='+title+'&description='+des+'&category=',
		           	type: 'put',
		          	contentType:false,
		           	contentType: 'application/json;charset=utf-8',
		           //data: JSON.stringify(JSONObject),
		           	success: function(data) {
			           	if(data.STATUS == true){
			           		mystart();
			           		swal("Article Was Update", "You clicked the button!", "success");
				          
			           	}else if(data.STATUS = 'invalid') {
			           		$("#checktitle").text(data.ERROR.title);
			           		$("#checkdescription").text(data.ERROR.description);
			           		$("#checkcategory").text(data.ERROR.category);
				        }else{
			           		alert("Update error pls check url");
				         }
		          
		           },
		           error: function(data){
		           	alert("creation unsuccess data");
		           }
		       });	
			} 

		}
		
		/*
		* delete article
		*/
		function deleteArticle(pid) {
			swal({   
				title: "Are you sure?",   
				text: "You will not be able to recover this Product!",   
				type: "warning",   
				showCancelButton: true,   
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Yes, delete it!",   
				closeOnConfirm: true }, function() {   
					
					 $.ajax({  
						 	url: url+'/article/'+pid,
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
		* clearForm
		*/
		function clearForm() {
			myClear();
			$("#myButton").text("Save").attr("onclick", "insertArticle()");
		}
		
		/*
		* myClear
		*/
		function myClear() {
			$("#art_id").val("");
			$("#title").val("");
			CKEDITOR.instances['editor'].setData("");
		}
		/*
		* validate validatTitle
		*/
		function validateTitle(){
			var name= $("#title").val();
			var characterReg = /^[\sa-zA-Z0-9-_]{3,100}$/;
			    if(!characterReg.test(name)) {
			    	$("#title").css("border", "solid 1px red");
			    	$("#checktitle").text("Require, at least 3, less than 100, not allow special symbol");
			    	   return false;
			    
			    }
			    else{
			    	$("#title").css("border", "solid 1px green");
			    	$("#checktitle").text("");
			    	return true;
			    }
		}
		/**
		* validate article description create by sotheara
		**/
		function validateArticleDes() {
			var name= CKEDITOR.instances.editor.getData();
			var characterReg = /^[\sa-zA-Z0-9!<>@#$%^&*()-_=+\[\]{}|\\:?/.,]{3,255}$/;
			if(!characterReg.test(name)) {
			    $("#editor").css("border", "solid 1px red");
			    $("#checkdescription").text("Require and at least 3 charactors less than 255 charactors");
			    return false;
			}
			else{
			    $("#editor").css("border", "solid 1px green");
			    $("#checkdescription").text("");
			    return true;
			}
		}
		/**
		* validate article category 
		**/

		function validateArticleCategory() {
			var name= $("#category").val();
			var characterReg = /^[\s0-9$]{1,100}$/;
			    if(!characterReg.test(name)) {
			    	$("#category").css("border", "solid 1px red");
			    	$("#checkcategory").text("Require less than 100 charactors");
			    	return false;
			    }
			    else{
			    	$("#category").css("border", "solid 1px green");
			    	$("#checkcategory").text("");
			    	return true;
			    }
		}
		/**
		* Search Article
		**/
		function SearchArticle() {
			var key =$("#search").val();
			var characterReg = /^[\ba-zA-Z0-9\s-_.]+$/;
			
			if(key.length > 1 && characterReg.test(key)) {
				
				$("#search").css("border", "solid 1px green");
				$("#checksearch").text("");
				
				 $.ajax({ 
					 url: url+'/article/page/'+offset+'/item/'+limit+'/'+key,
			            type: 'get',
			            contentType: 'application/json;charset=utf-8',
			            success: function(data) {
				            
			            	if(data.STATUS == true) {
				            	
				            	//alert(data.PAGINATION.TOTALRECORD);
				            	//alert(data.PAGINATION.TOTALPAGE);
				            	
			            		totalofrecord = data.PAGINATION.TOTALRECORD;
				            	numofpage = data.PAGINATION.TOTALPAGE;
				            	loadPaginationArticle();
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
		/**
		* Category 
		**/
		function listCategory(data){
			var str="";
			$.ajax(
	    	{
	    		url: url+'/categoryall',
	            type: 'get',
	            contentType: 'application/json;charset=utf-8',
	            success: function(data) 
	            {
	            	if(data.STATUS == true) 
	            	{
	            		for (var i = 0; i < data.DATA.length; i++) {
							str += "<option value='"+data.DATA[i].cat_id+"'>"
							+data.DATA[i].cat_name
							+"</option>";
	            		};
	            		$("#category").html(fuck);
	            	}
	            },
	            error: function(data) 
	            {
	            	alert("listCategory() unseccess data.");
	            }
	        });	    
		}
	</script>
	<script>
		CKEDITOR.replace( 'editor' ,{
			filebrowserBrowseUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
			filebrowserUploadUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
			filebrowserImageBrowseUrl : 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
		});
	</script>
@stop