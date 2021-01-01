<?php if (isset($_GET['a']) && $_GET['a'] == "wallpaper"):?>
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
<?php endif;?>