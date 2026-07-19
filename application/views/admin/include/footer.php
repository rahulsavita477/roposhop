        </div><!-- ./wrapper -->
        
        <!-- jQuery (only one version) -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

        <!-- jQuery UI (needed for autocomplete) -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

        <!-- Bootstrap 3 JS -->
        <script src="<?= $this->config->item('site_url').'assets/admin/js/bootstrap.min.js' ?>"></script>

        <!-- Slimscroll plugin -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>

        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="<?= $this->config->item('site_url').'assets/admin/js/plugins/datatables/dataTables.bootstrap.js' ?>"></script>

        <!-- AdminLTE -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/js/adminlte.min.js"></script>

        <!-- AdminLTE App -->
        <script src="<?= $this->config->item('site_url').'assets/admin/js/AdminLTE/app.js' ?> " type="text/javascript"></script>
        
        <script type="text/javascript">
        function confirmSave(msg) {
            return confirm(msg);
        }

        $(function() {

            $('[data-toggle="tooltip"]').tooltip();

            $(".data-pagination-table").each(function() {
                var $table = $(this);
                var $headerRow = $table.find('thead tr:last');
                var headerCols = $headerRow.children('th').length;
                if (headerCols === 0) return;
                var valid = true;
                $table.find('tbody tr').each(function() {
                    var cells = $(this).children('td, th').length;
                    if (cells > 0 && cells !== headerCols) {
                        valid = false;
                        return false;
                    }
                });
                if (valid) {
                    $table.dataTable();
                }
            });
        });
        </script>
    </body>
</html>
