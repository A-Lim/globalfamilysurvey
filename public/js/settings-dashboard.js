var start = moment().subtract(1, 'days');
var end = moment();

$(document).ready(function() {
    showHideDateRangeContainer($('#request-type').val());
    initDateRangePicker();
    initDatatable();
    retrieveStats();
    retrieveJobs();
});

$('#btn-refresh-queue').on('click', function(event) {
    event.preventDefault();
    retrieveStats();
    retrieveJobs();
    $('#datatable').DataTable().ajax.reload();
});

$('#request-type').on('change', function() {
    showHideDateRangeContainer(this.value);
});

function initDateRangePicker() {
    $('#daterange').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
}

function initDatatable() {
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        bLengthChange: false,
        ajax: '/requestlogs/datatable',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'}
        ],
        order: [[ 2, 'desc' ]]
    });
}

function showHideDateRangeContainer(value) {
    if (value == 'date') {
        $('#daterange-container').show();
    } else {
        $('#daterange-container').hide();
    }
}

function retrieveStats() {
    $('.stats-is-loading').css('display', 'block');
    $.ajax({
        headers: {
            Accept: "application/json",
        },
        dataType: 'json',
        url: "/requestlogs/stats",
    }).done(function(data) {
        $('.stats-is-loading').removeAttr('style');
        const totalCount = data.total_count;
        const todayCount = data.today_count;
        const dailyLimit = $('#daily-limit').val();
        const percentage = ((todayCount / dailyLimit) * 100).toFixed(2);

        $('#box-total-count .info-box-number').text((totalCount).toLocaleString('en'));
        $('#box-today-count .info-box-number').text((todayCount).toLocaleString('en'));
        $('#percentage-today').text(percentage + '%');
        $('#box-today-count .progress > .progress-bar').width(percentage);
    });
}

function retrieveJobs() {
    $('#btn-refresh-queue').addClass('fa-spin');
    $.ajax({
        headers: {
            Accept: "application/json",
        },
        dataType: 'json',
        url: "/settings/jobs",
    }).done(function(data) {
        // reset list
        $('#box-queue .box-body > .products-list').html('');
        // update count
        $('#queue-count').text(data.length);
        if (data.length > 0) {
            $('#box-queue .item-empty').css('display', 'none');
        }

        // only show 5 rows
        for (i = 0; i < 5; i++){
            if (i < data.length) {
                const html_row = queue_row(data[i]);
                $('#box-queue .box-body > .products-list').append(html_row);
            } else {
                break;
            }
        }

        if (data.length > 5) {
            const extra = data.length - 5;
            $('#box-queue .box-footer').css('display', 'block');
            $('#queue-more-count').text(extra);
        }

        $('#btn-refresh-queue').removeClass('fa-spin');
    });
}

function queue_row(job) {
    const date = new Date(job.created_at * 1000);
    const payload = JSON.parse(job.payload);
    return `<li class="item">
        <span class="product-title text-primary text-capitalize">${ job.queue }</span>
        <span class="label label-info pull-right">Attempts: ${ job.attempts }</span>
        <span class="product-description">
            <small>${ payload.displayName }</small>
            <span class="label label-danger pull-right">${ date.dateTimeFormat() }</span>
        </span>
    </li>`;
}

Date.prototype.dateTimeFormat = function() {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();

    var ss = this.getSeconds();
    var mm = this.getMinutes();
    var hh = this.getHours();

    var mmFormat = (mm>9 ? '' : '0') + mm;
    var ddFormat = (dd>9 ? '' : '0') + dd;
    var ssFormat = (ss>9 ? '' : '0') + ss;
    var mmFormat = (mm>9 ? '' : '0') + mm;
    var hhFormat = (hh>9 ? '' : '0') + hh;

    return `${this.getFullYear()}-${mmFormat}-${ddFormat} ${hhFormat}:${mmFormat}:${ssFormat}`;
};