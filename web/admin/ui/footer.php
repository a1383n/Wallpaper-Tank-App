<?php (!$isLogin) ? header("Location: ../login.php") : null?>
</div>
<!-- Bootstrap core JavaScript -->
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
    </script>
<?php endif; ?>
<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");

        if (document.getElementsByClassName("content-box")[0].style.marginTop == "20px"){
            document.getElementsByClassName("content-box")[0].style.marginTop = "0"
            document.getElementsByClassName("content-box")[0].style.marginBottom = "0"
        }else{
            document.getElementsByClassName("content-box")[0].style.marginTop = "20px"
            document.getElementsByClassName("content-box")[0].style.marginBottom = "20px"
        }
    });
</script>
