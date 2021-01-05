<?php (!@$isLogin) ? exit() : null ?>

<?php if (isset($_GET['a']) && $_GET['a'] == "wallpaper"): ?>
    <div class="container content-box">
        <div align="left">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal" id="wallpaper-add-btn"
                    onclick="addButton()">Add
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
                            <input type="text" name="title" id="add-form-wallpaper-title-input" class="form-control"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <br>
                            <select class="form-control" id="add-form-wallpaper-category-input" required>
                                <?php
                                $result = $db->Select("category");
                                $array = array();
                                while ($row = mysqli_fetch_assoc($result)):
                                    ?>
                                    <option><?php echo $row['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add-form-wallpaper-tags-input">Tags</label>
                            <div class="input-group">
                                <input type="text" id="add-form-wallpaper-tags-input" class="form-control">
                                <div class="input-group-append">
                                    <button type="button" id="add-form-wallpaper-tags-input-btn"
                                            class="btn btn-secondary">
                                        Add
                                    </button>
                                </div>
                            </div>
                            <label for="add-form-wallpaper-tags-input-btn">You can press enter for add new tag</label>
                            <br>
                            <label id="add-form-wallpaper-tags-input-error" class="bg-danger text-light p-1"
                                   style="display: none; width: 100%">
                                <li class="fa fa-warning"></li>&nbsp;Please add some tags</label>
                            <input type="hidden" id="add-form-wallpaper-tags-array-string"/>
                        </div>
                        <div class="form-group">
                            <div id="add-form-wallpaper-tags-list">

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="add-form-wallpaper-image-input"
                                       accept="image/jpeg" required>
                                <label class="custom-file-label" for="add-form-wallpaper-image-input">Choose
                                    file</label>
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
        <script>
            var dataTable;
            $(document).ready(function () {
                dataTable = $('#wallpaper-tbl').DataTable({
                    "processing": true,
                    "order": [[0, "desc"]],
                    "ajax": {
                        url: "../api/ajax/fetch.php",
                        type: "GET"
                    }
                });
            });

            function reloadTable(){
                dataTable.ajax.reload();
            }
        </script>
    </div>

<?php elseif (isset($_GET['a']) && $_GET['a'] == "category"): ?>
    <div class="container content-box">
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
                    url: "../api/ajax/fetch.php?t=category",
                    type: "GET"
                }
            });
        });

        function reloadTable(){
            dataTable.ajax.reload();
        }
    </script>
<?php endif; ?>
