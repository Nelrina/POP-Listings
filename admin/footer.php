<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 2.1.4 -->
<script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>

<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.min.js"></script>

<?php
// Include the script for datatables only on required pages : categories.php and listings.php
if(isset($menu) && ($menu == "cat" || $menu == "list"))
echo <<<"DATATABLES"
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- Categories -->
<script>
  $(function () {
    $("#categories").DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 2 }
        ]
    });
  });

<!-- Listings -->
  $(function () {
    $("#listings").DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 5 }
        ]
    });
  });
</script>
DATATABLES;
?>

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          POP Listings V. 0.1
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016 <a href="http://include.lollie.fr">lollie.fr</a>.</strong> All rights reserved.
      </footer>
  </body>
</html>