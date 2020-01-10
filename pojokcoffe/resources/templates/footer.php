 
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.min.js"></script>
    <script src="../assets/plugin/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/plugin/bootbox/bootbox.js"></script>
    <script src="../assets/plugin/datatables-plugins/dataTables.bootstrap.min.js"></script>

    <script src="../assets/plugin/datatables-plugins/dataTables.buttons.min.js"></script>
    <script src="../assets/plugin/datatables-plugins/buttons.colVis.min.js"></script>
    <script src="../assets/plugin/datatables-plugins/pdfmake.min.js"></script>
    <script src="../assets/plugin/datatables-plugins/vfs_fonts.js"></script>


    <script src="../assets/plugin/datatables-plugins/buttons.flash.min.js"></script>
    <script src="../assets/plugin/datatables-plugins/buttons.html5.min.js"></script>
    <script src="../assets/plugin/datatables-plugins/buttons.print.min.js"></script>
    <script src="../assets/plugin/datatables-responsive/dataTables.responsive.js"></script>

    <script src="../assets/plugin/select2/js/select2.full.min.js"></script>
    <!-- <script src="../assets/plugin/jquery-validation/dataTables.bootstrap.min.js"></script> -->
    <script src="../assets/plugin/datatables-responsive/dataTables.responsive.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="../assets/js/moment.js"></script>
    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    $(document).ready(function() {
        $('.datepicker').datepicker();
        

      var table = $('#dataTables-export').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                  extend: 'excelHtml5',
                  title: 'Data export laporan transaksi - '+'<?=date('Y-m-d');?>'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data export laporan transaksi - '+'<?=date('Y-m-d');?>'
                }
            ]

        } );
      $.fn.dataTableExt.afnFiltering.push(
            function( oSettings, aData, iDataIndex ) {

                var grab_daterange = $("#date_range").val();
                // var give_results_daterange = grab_daterange.split(" to ");
                var filterstart = $('#min').val();
                var filterend = $('#max').val();
                var iStartDateCol = $('[name="date"]').val(); //using column 2 in this instance
                var iEndDateCol = $('[name="date"]').val();
                var tabledatestart = aData[iStartDateCol];
                var tabledateend= aData[iEndDateCol];

                if ( filterstart === "" && filterend === "" )
                {
                    return true;
                }
                else if ((moment(filterstart).isSame(tabledatestart) || moment(filterstart).isBefore(tabledatestart)) && filterend === "")
                {
                    return true;
                }
                else if ((moment(filterstart).isSame(tabledatestart) || moment(filterstart).isAfter(tabledatestart)) && filterstart === "")
                {
                    return true;
                }
                else if ((moment(filterstart).isSame(tabledatestart) || moment(filterstart).isBefore(tabledatestart)) && (moment(filterend).isSame(tabledateend) || moment(filterend).isAfter(tabledateend)))
                {
                    return true;
                }
                return false;
            }
            );
        $('.datepicker').datepicker()
        .on('change', function(e) {
            // `e` here contains the extra attributes
            table.draw();
        });
        $('[name="date"]').on('change',function(){
             table.draw();
        });
      //   var base_url = '<?=base_url();?>';
      //   console.log(base_url)
      //   initValidatorStyle();
    });
    </script>
</div>

</body>
</html>