@extends('app')
@section('head')
	<link rel="stylesheet" type="text/css" href="{{ asset('asset/sweetalert/sweetalert.css') }}">
@stop
@section('body')
	<div class="container-fluid">
		<div class="row">

			<!-- Left Menu -->

			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
				<div class="panel panel-primary">
					<div class="panel-heading">Menu</div>
					<div class="panel-body">
						<div class="body-box">
							<ul class="nav bg-info">
								<li><a href=" URL::to('/article') }} ">Article</a> </li>
								<li><a href=" URL::to('/category') }} ">Category</a> </li>
								<li><a href="{{ URL::to('/product') }}">Product</a> </li>
								<li><a href="#">Log Out</a> </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- Right content -->
			<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
				<div class="form-group">
				<div class="row">
						<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
							<input type="button" value="Add" class="btn btn-info" data-toggle="modal" data-target="#addForm" width="100%">
						</div>

						<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
							<select id="item" class="form-control" onchange="item_change()">
								<option selected='selected'>5</option>
								<option>10</option>
								<option>15</option>
								<option>20</option>
								<option>30</option>
								<option>40</option>
								<option>50</option>
								<option>100</option>
							</select>
						</div><div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
							<div class="input-group">
								<input type="text" id="txtSearch" class="form-control" placeholder="Search for....">
								<span class="input-group-btn">
									<input type="button" value="Search" class="btn btn-info" onclick="btnSearch_click()">
								</span>
							</div>
						</div>
					</div>
				</div>
				<!-- List category data in table -->
				<div class="row">
					<div class="panel panel-primary">
						<div class="panel-heading">List Category</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>ID</th>
										<th>Category Name</th>
										<th>Created</th>
										<th>Updated</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="tbody">

								</tbody>
							</table>
							<div id="bootpage" class="text-center"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



		<!-- Add category form--->
		<div class="modal fade" id="addForm" role="dialog">
                    <div class="modal-dialog">
                        <!--Form content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                    <input type="button" class="close" data-dismiss="modal" value="&times;">
                                    <h4 class="modal-title" id="modal-title">Category Adding</h4>
                            </div>
                            <div class="modal-body">
                                    <form id="catForm" enctype="multipart/form-data">
                                            <div class="form-horizontal">
                                                    <div class="form-group">
                                                            <label class="col-sm-3 control-label">Category Name</label>
                                                            <div class="col-sm-9">
                                                                    <input type="text" name="txtCategory" id="txtCategory" required="required"  class="form-control" onchange="txtCategoryValidate()">
                                                                    <input type="hidden" name="id" id="id" >
                                                                    <small id="checkCategory" style="" class="msg"></small>
                                                            </div>
                                                    </div>
                                            </div>
                                    </form>
                            </div>
                            <div class="modal-footer">
                                                    <input type='button' class="btn btn-info" value="Save" onclick="btnSave_click()" id='btnSave'>
                                                    <input type='button' class="btn btn-danger" data-dismiss="modal" value="Close" id='btnClose' onclick="myClear()">
                            </div>
                        </div>
                    </div>
		</div>

	<!-- View Category --->
		<div class="modal fade" id="viewForm" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<input type="button" class="close" data-dismiss="modal" value="&times;">
						<h3 class="modal-title">View Category</h3>
					</div>
					<div class="modal-body" id="viewBody">
						<h1 id="category" align="center"></h1>
						<p id="cat_id"></p>
						<p id="created"></p>
						<p id="updated"></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-danger" data-dismiss="modal" value="Close">
					</div>
				</div>
			</div>
		</div>
	</div>

@stop

@section('foot')
	<script src="{{ asset('asset/js/bootpage.js') }}"></script>
	<script src="{{ asset('asset/sweetalert/sweetalert.min.js') }}"></script>
	<script type="text/javascript">
			var $numberofpage = 1;
			var $totalrecord =0;
			var $limit =0;
			var $offset =1;
			var $link = "{{ URL::to('/') }}";
			// page load
			page_load();
			function page_load(){
				$limit = $('#item').val();
				$.ajax({
					url: $link + '/category/page/'+ $offset +'/item/'+$limit,
					type: 'get',
					success: function(data){
						if(data.STATUS == true){
							$numberofpage = data.PAGINATION.TOTALPAGE;
							$totalrecord = data.PAGINATION.TOTALRECORD;

							listAllCategory($offset);
							paginationLoad();
						}
					}
				});
			}
			// list category
			function listAllCategory($offset){
				$.ajax({
					url: $link + '/category/page/'+$offset+'/item/'+$limit,
					type: 'get',
					success: function (data) {
						if(data.STATUS ==  true){
							$('tbody').html(tbody(data));
						}
					}
				});
			}
			// for inner html in tbody
			function tbody(data){
				var $str='';
				for(var $i=0;$i<data.DATA.length;$i++){
					$str += '<tr>'
							+'<td>'+data.DATA[$i].cat_id+'</td>'
							+'<td>'+data.DATA[$i].cat_name+'</td>'
							+'<td>'+data.DATA[$i].created_at+'</td>'
							+'<td>'+data.DATA[$i].updated_at+'</td>'
							+'<td>'
							+'<input type="button" id="btnView" onclick="btnView_click('+data.DATA[$i].cat_id+')" value="View " class="btn btn-primary" data-toggle="modal" data-target="#viewForm">'+' '
							+'<input type="button" id="btnView" onclick="btnEdit_click('+data.DATA[$i].cat_id+')" value="Edit" class="btn btn-warning" data-toggle="modal" data-target="#addForm">'+ ' '
							+'<input type="button" id="btnView" onclick="btnDelete_click('+data.DATA[$i].cat_id+')" value="Delete" class="btn btn-danger">'+' '
							+'</td>';
				}
				return $str;
			}
			// function pagingation
			function paginationLoad(){
				$('#bootpage').bootpag({
					total: $numberofpage,
					page: $offset,
					maxVisible: 5,
					leaps: true,
					firstLastUse: true,
					first: 'First',
					last: 'Last',
					wrapClass: 'pagination',
					activeClass: 'active',
					disabledClass: 'disabled',
					nextClass: 'next',
					prevClass: 'prev',
					lastClass: 'last',
					firstClass: 'first'
				}).on("page", function(event, num){
					listAllCategory(num);
				})
			}
			// option item chane
			function item_change(){
				page_load();
			}
			///Insert Category to database
                        function btnSave_click(){
							if( txtCategoryValidate() ){
								$.ajax({
									url: $link + '/category?cat_name='+ $('#txtCategory').val(),
									type: 'post',
									success: function(data){
										if(data.STATUS ==true){
											page_load();
											swal('Success','','success');
											myClear();
										}
										else{
											swal('Fail','','error');
										}
									},
									error: function(data){

									}

								});
							}

                        }

			// views category button
			function btnView_click($id){
				$.ajax({
					url: $link+'/category/'+$id,
					type: 'get',
					success: function(data){
						if(data.STATUS == true){
							$('#cat_id').html('Category ID: '+data.DATA.cat_id);
							$('#category').html(data.DATA.cat_name);
							$('#created').html('Category ID: '+data.DATA.created_at);
							$('#updated').html('Category ID: '+data.DATA.updated_at);
						}
					}
				});
			}
                        //Edit Category
                        function btnEdit_click($id){
                            $('#modal-title').html('Edit Category');
                            $.ajax({
                                url: $link+ '/category/'+$id,
                                type: 'get',
                                success: function(data){
                                    if(data.STATUS == true){
                                        $('#id').val(data.DATA.cat_id);
                                        $('#txtCategory').val(data.DATA.cat_name);
                                        $('#btnSave').val('Update').attr('onclick','btnUpdate_click()');

                                    }
                                    else{
                                        alert("flase");
                                    }
                                }

                            });
                       }
                       //update button click
                       function btnUpdate_click(){
                           $id = $('#id').val();
                           $cat = $('#txtCategory').val();
						   if( txtCategoryValidate() ){
							   $.ajax({
								   url: $link+'/category/'+$id+'?cat_name='+$cat,
								   type: 'put',
								   success: function(data){
									   if(data.STATUS == true){
										   page_load()
										   swal('success','','success');
									   }
									   else{
										   swal('Warning','Server not allow this name.','warning');
									   }
								   },
								   error: function(){
									   swal('Warning','','warning');
								   }
							   });}
                       }
			//Delete category
			function btnDelete_click($id){
					swal({
							title: "Are you sure?",
							text: "Your will not be able to recover this imaginary file!",
							type: "warning",
							showCancelButton: true,
							confirmButtonClass: "btn-danger",
							confirmButtonText: "Yes, delete it!",
							closeOnConfirm: false
						},
						function(){	
							$.ajax({
								url: $link + '/category/'+$id,
								type: 'delete',
								success: function(data){
									if(data.STATUS == true){
									 swal("Deleted!", "You have deleted successfully.", "success");
                                                                         listAllCategory();
                                                                    }
                                                                    else{
                                                                        swal("Error!", "You have deleted successfully.", "error");
                                                                    }                                                                    
								}
							});
						});
				}
			//search categroy
			function btnSearch_click(){
				$limit= $('#item').val();
				$key = $('#txtSearch').val();

				$.ajax({
					url: $link+'/category/page/'+$offset+'/item/'+$limit+'/'+$key,
					type: 'get',
					success: function(data){
						if(data.STATUS == true){
							$numberofpage = data.PAGINATION.TOTALPAGE;
							$totalrecord = data.PAGINATION.TOTALRECORD;
							$('tbody').html(tbody(data));
							paginationLoad();
						}
						else{
							swal('Warning','Not found','error');
						}

					}
				});
			}
			// clear textbox
			function myClear(){
					$('#txtCategory').val("");
					$('#btnSave').val('Save').attr('onclick','btnSave_click()');
				$('#txtCategory').css({'border':'solid 1px silver','color':'black'});
				$('#checkCategory').html('');
				}

			//Validate txtCAtegory
			function txtCategoryValidate(){
				var text= $("#txtCategory").val();
				var req = /^[\sa-zA-Z-_]{3,100}$/;
				if(!req.test(text)) {
					$("#txtCategory").css({"border":"solid 1px red",'color':'red'});
					$("#checkCategory").text("Require, at least 3, less than 100, not allow special symbol");
					$("#checkCategory").css('color','red');
					return false;
				}
				else{

					$("#txtCategory").css({"border":"solid 1px green",'color':'green'});
					$("#checkCategory").text("");
					return true;
				}
			}

			
	</script>
@stop