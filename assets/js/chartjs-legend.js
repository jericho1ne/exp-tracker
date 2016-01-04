function legend(parent, data) {
    legend(parent, data, null);
}

function legend(parent, data, chart, legendTemplate) {
    legendTemplate = typeof legendTemplate !== 'undefined' ? legendTemplate : "<%=label%>";

    parent.className = 'legend';
    var datas = data.hasOwnProperty('datasets') ? data.datasets : data;

    // remove possible children of the parent
    while(parent.hasChildNodes()) {
        parent.removeChild(parent.lastChild);
    }

   	var show = chart ? showTooltip : noop;

    datas.forEach(function(d, i) {

        //span to div: legend appears to all element (color-sample and text div)
        var title = document.createElement('div');
        title.className = 'title';
        parent.appendChild(title);

        var colorSample = document.createElement('div');
        colorSample.className = 'color-sample';
        colorSample.style.backgroundColor = d.hasOwnProperty('strokeColor') ? d.strokeColor : d.color;
        colorSample.style.borderColor = d.hasOwnProperty('fillColor') ? d.fillColor : d.color;
        title.appendChild(colorSample);

        // Create column divs containing legend text + value
        // TODO class="floatleft"
        // Search / replace placeholders
        legendNode = legendTemplate.replace("<%=value%>", '<div class="floatright">$' + d.value + '</div>');
        legendNode = legendNode.replace("<%=label%>", '<div class="floatleft">' + d.label + '</div>');

        var textLabel = document.createElement('div');
        textLabel.innerHTML = legendNode;
        textLabel.className = 'text-node';

        title.appendChild(textLabel);

        show(chart, title, i);
    });
}

// add events to legend that show tool tips on chart
function showTooltip(chart, elem, indexChartSegment) {
    var helpers = Chart.helpers;

    var segments = chart.segments;
    // TODO:  figure out why are these busted
	// console.log(segments);

    // Only chart with segments
    if (typeof segments != 'undefined') {
        helpers.addEvent(elem, 'mouseover', function() {
            var segment = segments[indexChartSegment];
            segment.save();
            segment.fillColor = segment.highlightColor;
            chart.showTooltip([segment]);
            segment.restore();
        });

        helpers.addEvent(elem, 'mouseout', function() {
            chart.draw();
        });
    }// End if segments
}// End showTooltip

function noop() {}
