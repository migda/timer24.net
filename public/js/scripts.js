userDate = new Date(dat);
userDate.setMinutes(dat.getMinutes() + 60 * userOffset); // user datetime based on offset and server datatime

// user date and time info & hidden field - offset
// clock
$('#user-date').html(moment(userDate).format('DD MMMM YYYY, HH:mm:ss'));
// offset
if (userOffset !== 0) {
    $('#stop').html(moment(stop).format('DD MMMM YYYY, HH:mm:ss'));
    $('#user-offset').html(' ' + (userOffset > 0 ? '+' : '') + moment(userOffset).format('HH:mm'));
    $("#offset").val(userOffset); // set value of hidden field
}

var now = new Date();
function updateUserDatetime() {
    // clock
    now.setSeconds(now.getSeconds() + 1);
    $('#user-date').html(moment(now).format('DD MMMM YYYY, HH:mm:ss'));
    // ends
    if (stopper) {
        var a = stopper;
    }
    else {
        var a = moment($('#date').val()); // datetime from input
    }
    var b = moment(now); // now
    var diff = a.diff(b).valueOf(); // timestamp
    if (diff > 0) {
        $('#ends').html('');
        if (moment.duration(diff, "ms").years() > 0) {
            $('#ends').append(moment.duration(diff, "ms").years());
            $('#ends').append('Y,');
        }
        if (moment.duration(diff, "ms").months() > 0) {
            $('#ends').append(moment.duration(diff, "ms").months());
            $('#ends').append('M,');
        }
        if (moment.duration(diff, "ms").days()) {
            $('#ends').append(moment.duration(diff, "ms").days());
            $('#ends').append('D,');
        }
        if (moment.duration(diff, "ms").hours() > 0) {
            $('#ends').append(moment.duration(diff, "ms").hours());
            $('#ends').append('h,');
        }
        $('#ends').append(moment.duration(diff, "ms").minutes());
        $('#ends').append('m,');
        $('#ends').append(moment.duration(diff, "ms").seconds());
        $('#ends').append('s');
    } else {
        $('#ends').html('-');
    }
}

$(document).ready(function ()
{
    setInterval('updateUserDatetime()', 1000); // update user datetime every 1 second
});

// datetimepicker
$(function () {
    $('#date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        useCurrent: false,
        sideBySide: true,
        defaultDate: userDate
    });
});