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

                <!-- insert and search article-->
                <div class="row">
                    <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#formAdd">Add Article</button>

                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2" style="padding-left: 50px">
                        <select id="limitplaylist" onclick="chooseArticle();"
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
                                    <th width="10%">Image</th>
                                    <th width="10%">Category</th>
                                    <th width="10%">Updated Date</th>
                                    <th width="20%">Activity</th>
                                </tr>
                                </thead>
                                <tbody >

                                </tbody>
                            </table>

                            <div class="text-center">
                                <div id="pagination"></div>
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
                                <h2 id="art_title"></h2>
                                <h3 id="art_desc"></h3>
                                <div id="art_image"></div>
                                <div id="art_category"></div>
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
                                <h4 class="modal-title" id="edit_title">Add new article</h4>
                            </div>
                            <div class="modal-body">

                                <form action="" id="formstudent" enctype="multipart/form-data">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label for="input-text" class="col-sm-3 control-label">Title:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="title" name="name" value="" required="required">
                                                <input type="hidden" class="form-control" id="pro_id" name="id" value="" >
                                                <small id="checkproductname" class="msg" style="color:red"></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input-text" class="col-sm-3 control-label">Description:</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="5" id="art_description" name="description" value="" required="required"></textarea>
                                                <small id="checkproductdescription" class="msg" style="color:red"></small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input-text" class="col-sm-3 control-label">Image</label>
                                            <div class="col-sm-9">
                                                <input id="input-2" value="Defaut Image" name="input2[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input-text" class="col-sm-3 control-label">Category</label>
                                            <div class="col-sm-9">
                                            <select class="form-control" id="art_category">
                                                @foreach($category as $cat)
                                                    <option value="{{ $cat->cat_name }}">{{ $cat->cat_name }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>

                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" id="myButton" onclick="insertArticle();" class="btn btn-success">Save</button>
                                <button type="button" onclick="clearForm();" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop @section('foot')
    <script src="{{ asset('asset/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/js/bootpage.js') }}"></script>
    <script src="{{ asset('asset/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        var limit=10;
        var offset=1;
        var totalrecord=0;
        var numofpage=1;
        var url="{{ URL::to('/') }}";
        showArticle();
        function showArticle(){
            $.ajax({
                url:url+'/article/page/'+offset+'/item/'+limit,
                type:'get',
                contentType:'application/json;charset=utf-8',
                success:function(data){
                    if(data.STATUS==true){
                    $('tbody').html(showDataArticle(data));
                    }
                },
                error:function(data){
                    alert('Error list article');
                }
            });
        }
        function showDataArticle(data){
                var str="";
                var cat=new Array();
                var i=0;
                    @foreach($category as $cat)
                        cat[i]="{{ $cat->cat_name }}";
                        i++;
                    @endforeach
            for(var i=0;i<data.DATA.length;i++){
                str+="<tr>"
                    +"<td>"+data.DATA[i].art_id+"</td>"
                    +"<td>"+data.DATA[i].title+"</td>"
                    +"<td>"+data.DATA[i].description+"</td>"
                    +"<td>"+data.DATA[i].image+"</td>"
                    +"<td>"+cat[data.DATA[i].cat_id_for]+"</td>"
                    +"<td>"+data.DATA[i].created_at+"</td>"
                    +"<td>"
                    +"<a title='Add Product' data-toggle='modal' data-target='#modelView' onclick=viewArticle('"+data.DATA[i].art_id+"') class='btn btn-primary'>View</a> &nbsp;"
                    +"<a title='edit playlist' data-toggle='modal' data-target='#formAdd' onclick=editArticle('"+data.DATA[i].art_id+"') id='showFrmUpdatePlaylist' class='btn btn-success'>Edit</a> &nbsp;"
                    +"<a title='delete playlist'  onclick=deleteArticle('"+data.DATA[i].art_id+"') class='btn btn-danger'>Delete</a> &nbsp;"
                    +"<td>"
                    +"</tr>";
            }
            return str;
        }
        function viewArticle(id){
            $.ajax({
                url:url+'/article/'+id,
                type:'get',
                contentType:'application/json;charset=uft-8',
                success:function(data){
                    if(data.STATUS==true){
                    $('#art_title').html(data.DATA.title);
                    $('#art_desc').html(data.DATA.description);
                    $('#art_image').html(data.DATA.image);
                    $('#art_category').html(data.DATA.cat_id_for);
                    }
                },
                error:function(data){
                    aler(data.MESSAGE);
                }
            });
        }
        function editArticle(id){
            $.ajax({
                url:url+'/article/'+id,
                type:'get',
                contentType:'application/json;charset=utf-8',
                success:function(data){
                    if(data.STATUS==true){
                        $('#title').val(data.DATA.title);
                        $('#art_description').val(data.DATA.description);
                    }
                }
            });
        }
        function deleteArticle(id){
            swal({
                title:'Are you sure want to delete?',
                text:'You will not be able to recover this Product!',
                type:'warning',
                showCancelButton:true,
                confirmButtonColor:'#ffaadd',
                confirmButtonText:'Delete',
                closeOnConfirm: false },function(){
                $.ajax({
                    url:url+'/article/'+id,
                    type:'delete',
                    contentType:'application/json;charset=utf-8',
                    success:function(data) {
                        if (data.STATUS == true) {
                            showArticle();
                            swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        }
                        console.log("Success..." + data);
                    },
                    error:function(data){
                        console.log("ERROR..." + data);
                    }
                });
            });
        }
        function insertArticle(){
            var title=$('#title').val();
            var description=$('#art_description').val();
            var image='Defual text';
            var category=$('select#art_category option:selected').index();
            $.ajax({
                url: url + '/article?title=' + title + '&description=' + description + '&image=' + image + '&cat_id_for=' + category,
                type: 'post',
                contentType:'application/json;charset=uft-8',
                success:function(data){
                   if(data.STATUS==true){
                       showArticle();
                       clearForm();
                       swal("Article was added", "You clicked the button!", "success");
                   }
                },
                error: function (data) {
                    alert('Error saving data');
                }
            });
        }
        function clearForm(){
            $('#title').val("");
            $('#art_description').val("");
            $('#art_image').val("");
        }
    </script>
@stop