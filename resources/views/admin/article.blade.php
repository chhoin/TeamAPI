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
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#formAdd">Insert Form</button>

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
                                <tbody>

                                </tbody>
                            </table>

                            <div class="text-center">
                                <div id="pagination"></div>
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
                                <h4 class="modal-title">Add new article</h4>
                            </div>
                            <div class="modal-body">

                                <form action="" id="formstudent" enctype="multipart/form-data">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label for="input-text" class="col-sm-3 control-label">Title:</label>
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
                                            <label for="input-text" class="col-sm-3 control-label">Image</label>
                                            <div class="col-sm-9">
                                                <input id="input-2" name="input2[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input-text" class="col-sm-3 control-label">Category</label>
                                            <div class="col-sm-9">
                                            <select class="form-control">
                                                <option value="5" selected="selected">5</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
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
            </div>
        </div>
    </div>
@stop @section('footer')
    <script src="{{ asset('asset/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/js/bootpage.js') }}"></script>
    <script src="{{ asset('asset/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $(document).on('ready', function() {
            $("#input-24").fileinput({
                initialPreview: [
                    '<img src="/images/moon.jpg" class="file-preview-image" alt="The Moon" title="The Moon">',
                    '<img src="/images/earth.jpg" class="file-preview-image" alt="The Earth" title="The Earth">'
                ],
                overwriteInitial: false,
                maxFileSize: 100,
                initialCaption: "The Moon and the Earth"
            });
        });
    </script>
    </script>
@stop