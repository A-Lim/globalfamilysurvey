
// constants
var color_palettes = ["#808080", "#c45850", "#ff9800", "#3e95cd", "#004d40", "#8e5ea2","#3cba9f","#e8c3b9", "#f50057", "#ffeb3b"];
var other_color_palettes = ["#3e95cd", "#8e5ea2","#3cba9f","#f50057","#c45850", "#e8c3b9", "#ffeb3b", "#ff9800", "#607d8b", "#808080"];

// var row_template = '<tr>' +
//     '<td>{text}</td>' +
//     '<td style="width: 70%;">' +
//         '<div class="progress progress-xs">' +
//             '<div class="progress-bar" style="width: {percentage}%; background-color:{color}"></div>' +
//         '</div>' +
//     '</td>' +
//     '<td style="width: 30%;"><span class="badge" style="background-color:{color}">{percentage}%</span></td>' +
// '</tr>';

function row_template(text, percentage, color) {
    return '<tr>' +
    `<td>${text}</td>` +
    '<td style="width: 70%;">' +
    '<div class="progress progress-xs">' +
    `<div class="progress-bar" style="width: ${percentage}%; background-color:${color}"></div>` +
    '</div>' +
    '</td>' +
    `<td style="width: 30%;"><span class="badge" style="background-color: ${color}">${percentage}%</span></td>` +
    '</tr>';
}

// if (!String.format) {
// String.format = function(format) {
//   var args = Array.prototype.slice.call(arguments, 1);
//   return format.replace(/{(\d+)}/g, function(match, number) {
//     return typeof args[number] != 'undefined'
//       ? args[number]
//       : match
//     ;
//   });
// };
// }







$('.alert').fadeOut(10000);
$(document).ready(function() {
    // if ($('#datatable').length) {
    //     $('#datatable').DataTable();
    // }
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

function setTooltip(button, message) {
    $(button).attr('data-original-title', message).tooltip('show');
    setTimeout(function() {
        $(button).tooltip('hide');
    }, 500);
}

function generatePieChart(id, type, labels, values, palette) {
    var total = 0;

    for(var i = 0; i < values.length; i++){
      total += values[i];
    }

    return new Chart(document.getElementById(id), {
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
            responsive: true,
            legend: {
              display: true,
              position: 'left',
              labels: {
                fontStyle: 'bold',
                fontColor: 'black'
              }
            },
            title: {
                display: false,
            },
            animation: false,
            plugins:{
              datalabels:{
                display: (context) => {
                  return context.dataset.data[context.dataIndex] > 0;
                },
                color:'black',
                anchor:'end',
                align:'start',
                borderWidth: 2,
                borderColor:'black',
                borderRadius: 25,
                backgroundColor: (context) => {
                  return context.dataset.backgroundColor;
                },
                font: {
                  weight: 'bold',
                  size: '10'
                },
                formatter: (value) => {
                  return ((value / total) * 100).toFixed(2) + ' %';
                }
              }
            }
        }
    });
}



function generateBarChart(id, type, labels, values, palette) {
    return new Chart(document.getElementById(id), {
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
            legend: {display: false},
            title: {
                display: false,
            },
            // scaleSetting is found in js file
            scales: scaleSetting,
            animation: false,
            plugins: barchart_pluginSetting
          }
    });
}

var barchart_pluginSetting = {
    datalabels:{
      display: (context) => {
        return context.dataset.data[context.dataIndex] > 0;
      },
      color:'black',
      anchor:'end',
      align:'start',
      borderWidth: 1,
      borderColor: 'black',
      borderRadius: 25,
      backgroundColor: 'white',
      font: {
        weight: 'bold',
        size: '10'
      }
    }
};

var scaleSetting = {
    yAxes: [{
        ticks: {
            fontSize: 2,
            beginAtZero: true,
            userCallback: function(label, index, labels) {
                // when the floored value is the same as the value we have a whole number
                if (Math.floor(label) === label) {
                    return label;
                }

            },
        }
    }],
    xAxes: [{
        ticks: {
            fontSize: 11,
            fontStyle:'bold',
            fontColor:'black',
            autoSkip:false
        }
    }]
};

// function chart_plugin_setting() {
//     Chart.pluginService.register({
//         beforeInit: function (chart) {
//             // var hasWrappedTicks = chart.config.data.labels.some(function (label) {
//             //     return label.indexOf('\n') !== -1;
//             // });
//             var hasWrappedTicks = true;
//             if (hasWrappedTicks) {
//                 // figure out how many lines we need - use fontsize as the height of one line
//                 var tickFontSize = Chart.helpers.getValueOrDefault(chart.options.scales.xAxes[0].ticks.fontSize, Chart.defaults.global.defaultFontSize);
//                 // alert(chart.config.data.labels.length)
//                 var maxLines = chart.config.data.labels.reduce(function (maxLines, label) {
//                     return label.length;
//                     // return Math.max(maxLines, label.split(' ').length);
//                 }, 0);
//                 // alert(maxLines);
//                 var height = (tickFontSize + 2) * maxLines + (chart.options.scales.xAxes[0].ticks.padding || 0);
//
//                 // insert a dummy box at the bottom - to reserve space for the labels
//                 Chart.layoutService.addBox(chart, {
//                     draw: Chart.helpers.noop,
//                     isHorizontal: function () {
//                         return true;
//                     },
//                     update: function () {
//                         return {
//                             height: this.height
//                         };
//                     },
//                     height: height,
//                     options: {
//                         position: 'bottom',
//                         fullWidth: 1,
//                     }
//                 });
//
//                 // turn off x axis ticks since we are managing it ourselves
//                 chart.options = Chart.helpers.configMerge(chart.options, {
//                     scales: {
//                         xAxes: [{
//                             ticks: {
//                                 display: false,
//                                 // set the fontSize to 0 so that extra labels are not forced on the right side
//                                 fontSize: 0
//                             }
//                         }]
//                     }
//                 });
//
//                 chart.hasWrappedTicks = {
//                     tickFontSize: tickFontSize
//                 };
//             }
//         },
//         afterDraw: function (chart) {
//             if (chart.hasWrappedTicks) {
//                 // draw the labels and we are done!
//                 chart.chart.ctx.save();
//                 var tickFontSize = chart.hasWrappedTicks.tickFontSize;
//                 var tickFontStyle = Chart.helpers.getValueOrDefault(chart.options.scales.xAxes[0].ticks.fontStyle, Chart.defaults.global.defaultFontStyle);
//                 var tickFontFamily = Chart.helpers.getValueOrDefault(chart.options.scales.xAxes[0].ticks.fontFamily, Chart.defaults.global.defaultFontFamily);
//                 var tickLabelFont = Chart.helpers.fontString(tickFontSize, tickFontStyle, tickFontFamily);
//                 chart.chart.ctx.font = tickLabelFont;
//                 chart.chart.ctx.textAlign = 'center';
//                 var tickFontColor = Chart.helpers.getValueOrDefault(chart.options.scales.xAxes[0].fontColor, Chart.defaults.global.defaultFontColor);
//                 chart.chart.ctx.fillStyle = tickFontColor;
//
//                 var meta = chart.getDatasetMeta(0);
//                 var xScale = chart.scales[meta.xAxisID];
//                 var yScale = chart.scales[meta.yAxisID];
//
//                 chart.config.data.labels.forEach(function (label, i) {
//                     label.forEach(function (line, j) {
//                         chart.chart.ctx.fillText(line, xScale.getPixelForTick(i + 0.5), (chart.options.scales.xAxes[0].ticks.padding || 0) + yScale.getPixelForValue(yScale.min) +
//                             // move j lines down
//                             j * (chart.hasWrappedTicks.tickFontSize + 2));
//                     });
//                 });
//
//                 chart.chart.ctx.restore();
//             }
//         }
//     });
// }
