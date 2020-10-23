<script>

    document.addEventListener("DOMContentLoaded", function(event) {

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].square, input[type="radio"].square').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass   : 'iradio_square-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].square-red, input[type="radio"].square-red').iCheck({
          checkboxClass: 'icheckbox_square-red',
          radioClass   : 'iradio_square-red'
        });

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-blue').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass   : 'iradio_flat-blue'
        })

      });

</script>
