$('.alert').fadeOut(4000);
$(document).ready(function() {
    if ($('#datatable').length) {
        $('#datatable').DataTable();
    }
});

$('.select2').select2();
$('.select2.hasTags').select2({
    'tags' : true
});

$('select').on('select2:select', function (evt) {
  var element = evt.params.data.element;
  var $element = $(element);

  $element.detach();
  $(this).append($element);
  $(this).trigger("change");
});


function generatePieChart(id, type, labels, values, palette) {
    new Chart(document.getElementById(id), {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                label: "Responses",
                backgroundColor: palette,
                data: values
            }]
        },
        options: {
            legend: { display: true },
            title: {
                display: false,
            }
        }
    });
}

function generateBarChart(id, type, labels, values, palette) {
    new Chart(document.getElementById(id), {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                label: "Responses",
                backgroundColor: palette,
                data: values
            }]
        },
        options: {
            legend: { display: false },
            title: {
                display: false,
            },
            // scaleSetting is found in js file
            scales: scaleSetting
        }
    });
}

var scaleSetting = {
    yAxes: [{
        ticks: {
            beginAtZero: true,
            userCallback: function(label, index, labels) {
                // when the floored value is the same as the value we have a whole number
                if (Math.floor(label) === label) {
                    return label;
                }

            },
        }
    }]
};
