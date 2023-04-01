$(document).ready(function () {
    let i = 1;
    $("#add_row").click(function (e) {
        e.preventDefault();
        let b = i - 1;
        $('#addr' + i).html($('#addr' + b).html()).find('td:first-child').html(i + 1);
        $('#invoice_table').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
    });
    $("#delete_row").click(function (e) {
        e.preventDefault();
        if (i > 1) {
            $("#addr" + (i - 1)).html('');
            i--;
        }
        calculate();
    });

    $('#invoice_table tbody').on('keyup change', function () {
        calculate();
    });
    $('#tax').on('keyup change', function () {
        calculate_total();
    });


});

function calculate() {
    $('#invoice_table tbody tr').each(function (i, element) {
        let html = $(this).html();
        if (html !== '') {
            let quantity = $(this).find('.quantity').val();
            let price = $(this).find('.price').val();
            $(this).find('.total').val(quantity * price);

            calculate_total();
        }
    });
}

function calculate_total() {
    let total = 0;
    $('.total').each(function () {
        total += parseInt($(this).val());
    });
    $('#sub_total').val(total.toFixed(2));
    let tax_sum = (total / 100) * $('#tax1').val();
    $('#tax_amount').val(tax_sum.toFixed(2));
    $('#total_amount').val((tax_sum + total).toFixed(2));
}

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}