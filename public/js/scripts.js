// user date and time info & hidden field - offset
ends();
var now = timeUser;
if ((typeof timeLocal !== 'undefined')) {
    var now2 = timeLocal;
}
function updateUserDatetime() {
    now.add(1, 's');
    $('#user-date').html(moment(now).format('DD MMMM YYYY, HH:mm:ss'));
    if ((typeof timeLocal !== 'undefined')) {
        now2.add(1, 's');
        $('#local-date').html(moment(now2).format('DD MMMM YYYY, HH:mm:ss'));
    }
    //ends 
    ends();
}
function ends() {
    // ends
    if (stopper) {
        var a = stopper;
    }
    else {
        var a = moment($('#date').val()); // datetime from input
    }
    var b = moment(now); // now

    // offset
    var offset = 0;
    $('#timezone').change(function () {
        changed = true;
    });
    if (changed) {
        var changeTimezone = moment.tz.names()[$('#timezone').val()];
        var bb = moment.tz(b, changeTimezone);
        b.add((bb.utcOffset() - b.utcOffset()), 'm'); // offset between new date and old date 
    }
    var diff = a.diff(b).valueOf(); // timestamp
    if (diff < 0) { // minus value == red color
        $('#ends').css('color', '#E74C3C');
    } else {
        $('#ends').css('color', '#18BC9C');
    }
    $('#ends').html('');
    if (moment.duration(diff, "ms").years() !== 0) {
        $('#ends').append(moment.duration(diff, "ms").years());
        $('#ends').append('Y,');
    }
    if (moment.duration(diff, "ms").months() !== 0) {
        $('#ends').append(moment.duration(diff, "ms").months());
        $('#ends').append('M,');
    }
    if (moment.duration(diff, "ms").days()) {
        $('#ends').append(moment.duration(diff, "ms").days());
        $('#ends').append('D,<br>');
    }
    if (moment.duration(diff, "ms").hours() !== 0) {
        $('#ends').append(moment.duration(diff, "ms").hours());
        $('#ends').append('h,');
    }
    $('#ends').append(moment.duration(diff, "ms").minutes());
    $('#ends').append('m,');
    $('#ends').append(moment.duration(diff, "ms").seconds());
    $('#ends').append('s');
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
        defaultDate: timeUser
    });
});