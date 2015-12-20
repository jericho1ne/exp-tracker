//
// main.js
// 

//
// Work to do after page load
//
window.onload = function() {
    // Load monthly data by default on page load
    getChargeData('monthly');

    // UI listeners
    $('.btn-mode').click(function() {
        // console.log($(this).attr('data-id'));
        var mode = $(this).attr('data-id');

        var headerText = '';

        if (mode == "yearly") 
            headerText = "By Year";
        else if (mode == "monthly") 
            headerText = "By Month";
        else if (mode == "all") 
            headerText = "All charge data, ever.";
        else if (mode == "detail") {
             // Hide DataTables
             $('.dataTables_wrapper').toggle();
             // Update display text
             headerText = $('.dataTables_wrapper').is(':hidden') ? 'Chart Only' : 'Charge Details';
        }   

        $("#title-header").html(headerText);

       //getChargeData(mode);
    });
};// End window.onload


/**
 *  @method displayYearlyChargeData()
 *  @param array expenseCategories
 *  @param array data charge data from ajax call
 */
function displayYearlyChargeData(expenseCategories, data) {
    // Clear any pre-existing content
    $('#charge-data').empty();

    var $dataTableParent = $('<div>')
        .addClass("normal-pad");

    // YEARS loop
    for (var year in data) {
        var chargeData = data[year];

        // Add year header
        var $yearDiv = $('<div>')
            .addClass('container chart-block')
            .html('<div class="title-large pad-top-20">' + year + '</div>');

        // MONTHS loop
        for (var month in chargeData) {
             // Clean looking month name
            var monthNames = [
                "January", 
                "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            // Charge data to be displayed in tabulated form
            var monthlyData = chargeData[month];

            // Pie chart-friendly category subtotal data
            var subtotals = {};

            var $monthDiv = $('<div>')
                .addClass('chart-and-table container');

            // eg: January 2016
            var $monthName = $('<div>')
                .addClass('title-medium')
                .css('opacity', 0.7)
                .css('position', 'relative')
                .css('float', 'right')
                .css('margin-right', '14px')
                .css('margin-top', '-248px')
                .html(monthNames[month-1] + ' ' + year);

            // Initialize loop counters
            var rowCount = 0;
            var totalAmount = 0;

            //
            //  DATA TABLES
            //       Create an old school HTML table for charge tabulation
            // 
            var dataTableUniqueID = 'data-table-' + year + '-' + month;
            var $dataTable = $('<table>')
                .attr('id', dataTableUniqueID)
                .addClass('display container dataTable border');

            var $tableHeader = $('<thead>')
                    .addClass('row-bold')
                    .html('<tr><th class="left">date</td>'
                        + '<th class="left">category</td>'
                        + '<th class="left">detail</td>'
                        + '<th class="right">amount</td></tr>' );

            // Datatables can also make use of a footer (not a must-have)
            // create one if necessary, duplicating $tableHeader; then append()
           
            $dataTable.append($tableHeader);

            // Initialze once, outside the upcoming loop
            var row = '';
            // CHARGE data (finally)
            for (var charge in monthlyData) {
                row = monthlyData[charge];
                //console.log(row.label + ' >> ' + expenseCategories[row.label].color);

                // Append to category subtotals
                if (typeof subtotals[row.label] === 'undefined') {
                    subtotals[row.label] = parseFloat(row.value);
                }
                else {
                    subtotals[row.label] += parseFloat(row.value);
                }

                if (typeof expenseCategories[row.label] === 'undefined') {
                    window.EffinRow = row;
                    console.log("!!! undefined row label found !!! " );
                }

                // Date | Category | Detail | Amount
                var $newDataDiv = $('<tr>')
                    .addClass('line-item' + (rowCount % 2 ? '' : ' alternate-bgcolor'))
                    .html('<td class="left">' 
                        + row.date + '</td>'
                        + '<td class="left" style="background-color:' + expenseCategories[row.label].color + '">' + row.label + '</td>' 
                        + '<td class="left">' + row.description + '</td>' 
                        + '<td class="right">' + row.value.toFixed(2) + '</td>' 
                        + '</td></tr>' );

                // Append individual row of charges
                $dataTable.append($newDataDiv);
                // Add to monthly subtotal
                totalAmount += parseFloat(row.value);
                
                rowCount ++;
            }// Actual Charge Data loop

            // append a monthly/yearly subtotal before we close the dataTable
            var $totalAmount = $('<tr>')
                    .addClass('row-bold')
                    .html('<td>&nbsp;</td><td>&nbsp;</td>' 
                    +'<td class="right">TOTAL</td><td class="right">' 
                    + totalAmount.toFixed(2) + '</td>');
            $dataTable.append($totalAmount);

            // Prepare chart ===========================================================
            chartID = 'chart-area-' + year + '-' + month;

            // Append chart placeholder
            var $donutChartParent = $('<div>')
                .addClass('container left-half');

            var $chartCanvas = $('<div>')
                .attr('id', 'canvas-holder')
                .addClass('block') 
                .html('<canvas id="' + chartID + '" class="pie-chart" height="180px"/>' );

            var legendId = chartID + '-legend';

            var $chartLegend = $('<div>')
                .attr('id', legendId)
                .addClass('container inline-block')
                .html('* LEGEND LOADING *');

                // +'<div id="'+ chartID +'-legend" class="legend container inline-block">* LEGEND LOADING *</div>');

            // Append Chart + Legend
            $donutChartParent.append($chartLegend);
            $donutChartParent.append($chartCanvas);

            // Overlay month name
            $donutChartParent.append($monthName);

            // Append sexy donut chart
            $monthDiv.append($donutChartParent);

            // Add the current monthly charges to the Month header
            $monthDiv.append($dataTable);

            
            // Append entire month (chart + tabulated data)
            $dataTableParent.append($monthDiv);
            
            //
            //  Append that whole mess to the DOM
            //
            $('#charge-data').append($dataTableParent);

            //
            //  Call upon the magic of ~ DataTables ~
            //
            $('#' + dataTableUniqueID).DataTable( {
                "lengthMenu": [[10, 20, 40, -1], [10, 20, 40, "All"]],
                 // 0 = date, 1 = cat, 2 = detail, 3 = amount
                 "order": [[ 3, "desc" ]]  
             } );

            // Send data to chart already in DOM
            var subtotalsMod = [];
            for (key in subtotals) {
                subtotalsMod.push({
                    'color': expenseCategories[key].color,
                    'highlight': '#FFF000',
                    'label': key,
                    'value': subtotals[key].toFixed(2)
                });
            }

            //
            //  Draw actual chartdetai
            //
            drawChart(chartID, subtotalsMod);

        }
       // $dataTableParent.append($yearDiv);
    }// Years loop

   

    // Append tabulated data
   
}// End displayChargeData


/**
 * 
 *
 */
function drawChart(chartId, data) {
    // Set up options object
    var options = {
        responsive : true,
        animation: false,
        segmentShowStroke : false,
        segmentStrokeWidth : 1,
        percentageInnerCutout: 22, // This is 0 for Pie charts
        legend :    // TODO:  is this necessary??
            '<ul>'
                +'<% for (var i=0; i<datasets.length; i++) { %>'
                    +'<li>'
                        +'<span style=\"background-color:<%=datasets[i].color%>\">'
                        +'<% if (datasets[i].label) { %><%= datasets[i].label %><% } %>'
                        +'</span>'
                    +'</li>'
                +'<% } %>'
            +'</ul>'
    };

    var ctx = document.getElementById(chartId).getContext("2d");
    new Chart(ctx).Doughnut(data, options);

    var legendTemplate =  '<ul>'
                +'<% for (var i=0; i<datasets.length; i++) { %>'
                    +'<li>'
                        +'<span style=\"background-color:<%=datasets[i].color%>\">'
                        +'<% if (datasets[i].label) { %><%= datasets[i].label %><% } %>'
                        +'</span>'
                    +'</li>'
                +'<% } %>'
            +'</ul>';
    // Legend.js
    //      pass in: (parent id, data, chart, legendTemplate)
    legend(document.getElementById(chartId + '-legend'), data, chartId, "<%=label%>  $<%=value%>");
    //legend(document.getElementById(chartId + '-legend'), data, '', legendTemplate);
}// End drawChart

/**
 *
 *
 */
function getChargeData(mode) {
    // LOAD FROM URL 
    var url = 'categorize-exp.php' 
        + '?mode=' + mode;

    $.get( url, function( data ) {
        var jsonData = JSON.parse(data);
        // Use the category subtotals for the chart
        // Show charge details
        displayYearlyChargeData(jsonData.expenseCategories, jsonData.chargeData);
    });
}// End method getChargeData()

