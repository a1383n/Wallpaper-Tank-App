<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | Panel</title>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/plugins/dataTables/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f1f1f1;
        }

        .content-box {
            margin-top: 25px;
            margin-bottom: 25px;
            padding: 25px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 5px; /* 5px rounded corners */
            background: #ffffff;
        }
    </style>
</head>
<body>
<div class="container content-box">
    <div align="left">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal" id="wallpaper-add-btn">Add
            Wallpaper
        </button>
        <br/>
        <br/>
    </div>
    <div class="table-responsive">
        <table id="wallpaper-tbl" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Tags</th>
                <th>Info</th>
                <th>Actions</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script src="assets/js/jquery-3.5.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap.bundle.js"></script>
<script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
<script src="assets/plugins/dataTables/dataTables.bootstrap4.js"></script>
<script src="assets/js/functions.js"></script>
<script>
    $(document).ready(function () {
        var DataTable = $('#wallpaper-tbl').DataTable({
            "processing": true,
            "order": [[0, "desc"]],
            "ajax": {
                url: "api/ajax/fetch.php",
                type: "GET"
            }
        });
    });

    $("#wallpaper-add-btn").click(function () {
        resetForm("add-wallpaper-form");
        $(".modal-title").text("Add Wallpaper");
        $("#add-form-wallpaper-action-input").val("Add");
        $("#add-form-wallpaper-action-input").val("Add");
    });
</script>
</body>
</html>

<div id="addModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="add-wallpaper-form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Wallpaper</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add-form-wallpaper-title-input">Title</label>
                        <input type="text" name="title" id="add-form-wallpaper-title-input" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="add-form-wallpaper-category-input">
                            <option>Category</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="add-form-wallpaper-tags-input">Tags</label>
                        <div class="input-group">
                            <input type="text" id="add-form-wallpaper-tags-input" class="form-control">
                            <div class="input-group-append">
                                <button type="button" id="add-form-wallpaper-tags-input-btn" class="btn btn-secondary">
                                    Add
                                </button>
                            </div>
                        </div>
                        <label for="add-form-wallpaper-tags-input-btn">After evey tag press Enter</label>
                    </div>
                    <div class="form-group">
                        <div id="add-form-wallpaper-tags-list">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="add-form-wallpaper-image-input"
                                   accept="image/jpeg">
                            <label class="custom-file-label" for="add-form-wallpaper-image-input">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="wallpaper_id" id="add-form-wallpaper-id-input">
                    <input type="hidden" name="operation" id="add-form-wallpaper-operation-input">
                    <input type="submit" class="btn btn-success" name="action" id="add-form-wallpaper-action-input"
                           value="Add">
                    <input type="reset" class="btn btn-danger" name="reset" id="add-form-wallpaper-reset-input">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function () {
            const fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $("#add-wallpaper-form").on("reset", function () {
            $(".custom-file-label").removeClass("selected").html("Choose file");
        });

    </script>
</div>
