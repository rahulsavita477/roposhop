        </div><!-- ./wrapper -->
        
        <!-- jQuery (only one version) -->
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

        <!-- Bootstrap 3 JS -->
        <script src="<?= $this->config->item('site_url').'assets/admin/js/bootstrap.min.js' ?>"></script>

        <!-- Slimscroll plugin (needed by AdminLTE v2) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>

        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="<?= $this->config->item('site_url').'assets/admin/js/plugins/datatables/dataTables.bootstrap.js' ?>"></script>

        <!-- AdminLTE full build (includes tree, sidebar, etc.) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/js/adminlte.min.js"></script>

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
