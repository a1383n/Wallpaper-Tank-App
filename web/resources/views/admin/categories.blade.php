@extends('admin.layout')
@section('title','Categories')

@section('content')
        <div align="left">
            <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModal" id="category-add-btn" onclick="addCategory()">Add
                category
            </button>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            <table id="category-tbl" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Wallpaper Count</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="categoryModal" class="modal fade">
        <div class="modal-dialog">
            <form id="add-category-form" method="get">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Category</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="add-category-name-input">Name</label>&nbsp;
                            <input type="text" name="name" id="add-category-name-input" class="form-control" required>&nbsp;
                            <br>
                            <label for="add-category-color-input">Category Color</label>&nbsp;
                            <input type="color" name="color" id="add-category-color-input" class="form-control">
                        </div>
                        <div class="custom-control custom-checkbox" id="notification-checkbox">
                            <input type="checkbox" class="custom-control-input" id="notification-checkbox-input"
                                   name="notification" checked>
                            <label class="custom-control-label" for="login-form-remember-check">Send notification to android users</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="add-category-id-input">
                        <input type="submit" name="submit" class="btn btn-primary" value="Add" id="add-category-action">
                        <button class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        var dataTable;
        $(document).ready(function () {
            dataTable = $('#category-tbl').DataTable({
                "processing": true,
                "order": [[0, "desc"]],
                "ajax": {
                    url: "/api/categories",
                    type: "GET"
                }
            });
        });

        function reloadTable(){
            dataTable.ajax.reload();
        }
    </script>
@endsection
