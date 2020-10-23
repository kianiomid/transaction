@if(\Illuminate\Support\Facades\App::getLocale() == 'fa')
    <script>
        function initDateTimePicker(fieldName) {

            var x = $('#' + fieldName + "__alt").persianDatepicker({
                initialValue: false,
                altField: '#' + fieldName,
                format: 'D MMMM YYYY HH:mm',
                observer: false,
                timePicker: {
                    enabled: true,
                    second: {
                        enabled: false
                    }
                },
                altFieldFormatter: function (unix) {
                    var d = new Date(unix),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear(),
                        hours = d.getHours(),
                        minutes = d.getMinutes(),
                        seconds = 0;

                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;
                    if (hours.length < 2) hours = '0' + hours;
                    if (minutes < 10) minutes = '0' + minutes;
                    if (seconds < 10) seconds = '0' + seconds;

                    return [year, month, day].join('-') + " " + [hours, minutes, seconds].join(':');
                }
            });
            if ($("#" + fieldName).val() != "") {
                x.setDate(new Date($("#" + fieldName).val()).getTime());
            }

        }

        function initDatePicker(fieldName) {

            var x = $('#' + fieldName + "__alt").persianDatepicker({
                initialValue: false,
                altField: '#' + fieldName,
                format: 'D MMMM YYYY',
                observer: false,
                autoClose: true,
                timePicker: {
                    enabled: false
                },
                altFieldFormatter: function (unix) {
                    var d = new Date(unix),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear();

                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;

                    return [year, month, day].join('-');
                }
            });

            if ($("#" + fieldName).val() != "") {
                x.setDate(new Date($("#" + fieldName).val()).getTime());
            }
        }

        function resetDatePicker(fieldName) {
            $("#" + fieldName).val("");
            $('#' + fieldName + "__alt").val("");
        }
    </script>
@else
    <script>
        function initDateTimePicker(fieldName) {

                    $('#' + fieldName + "__alt").datepicker({
                        autoclose: true,
                        dateFormat: 'yy-mm-dd'
                        });
            /*var x = $('#' + fieldName + "__alt").datepicker({
                initialValue: false,
                altField: '#' + fieldName,
                format: 'D MMMM YYYY HH:mm',
                observer: false,
                timePicker: {
                    enabled: true,
                    second: {
                        enabled: false
                    }
                },
                altFieldFormatter: function (unix) {
                    var d = new Date(unix),
                        month = '' + (d.getMonth() + 1),
                        day = '' + d.getDate(),
                        year = d.getFullYear(),
                        hours = d.getHours(),
                        minutes = d.getMinutes(),
                        seconds = 0;

                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;
                    if (hours.length < 2) hours = '0' + hours;
                    if (minutes < 10) minutes = '0' + minutes;
                    if (seconds < 10) seconds = '0' + seconds;

                    return [year, month, day].join('-') + " " + [hours, minutes, seconds].join(':');
                }
            });
            if ($("#" + fieldName).val() != "") {
                x.setDate(new Date($("#" + fieldName).val()).getTime());
            }*/

        }

        function initDatePicker(fieldName) {

            var x = $('#' + fieldName + "__alt").datepicker({
                initialValue: false,
                altField: '#' + fieldName,
                altFormat: "yy-mm-dd",
                dateFormat: 'd MM yy',
                observer: false,
                autoClose: true,
                timePicker: {
                    enabled: false
                },
            });

            if ($("#" + fieldName).val() != "") {
                $('#' + fieldName + "__alt").datepicker( "setDate" , new Date($("#" + fieldName).val()));
            }

        }

        function resetDatePicker(fieldName) {
            $("#" + fieldName).val("");
            $('#' + fieldName + "__alt").val("");
        }
    </script>





@endif