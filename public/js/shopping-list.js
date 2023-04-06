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