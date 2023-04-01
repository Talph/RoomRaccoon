$(document).ready(function () {
    let i = 1;
    $("#add_row").click(function (e) {
        e.preventDefault();
        let b = i - 1;
        $('#addr' + i).html($('#addr' + b).html()).find('td:first-child').html(i + 1);
        $('#list_table').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
    });
    $("#delete_row").click(function (e) {
        e.preventDefault();
        if (i > 1) {
            $("#addr" + (i - 1)).html('');
            i--;
        }
    });

});

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';