</div>
<!-- Bootstrap core JavaScript -->
<script src="../assets/jquery/jquery.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.bundle.js"></script>
<script src="../assets/plugins/dataTables/jquery.dataTables.js"></script>
<script src="../assets/plugins/dataTables/dataTables.bootstrap4.js"></script>
<script src="../assets/js/functions.js"></script>
<?php if (isset($_GET['a']) && $_GET['a'] == "wallpaper"): ?>
    <script>
        $(document).ready(function () {
            var DataTable = $('#wallpaper-tbl').DataTable({
                "processing": true,
                "order": [[0, "desc"]],
                "ajax": {
                    url: "../api/ajax/fetch.php",
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
<?php endif; ?>
<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
