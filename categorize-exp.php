<?php
require_once("common.php");

$mode = set($_GET["mode"]);

/*
  0			1			2				 3		4
  Status	Date		Description		 Debit  Credit
  Cleared	11/02/2015	DEBIT PURCHASE	 11.85  ---
*/

$years = array('2015', '2014');
// $files = array('import/CHK_862_010115_121315.CSV', 'import/MC_359_010115_121315.CSV');

$files = array('import/MC_359_010115_121615.CSV');
//$files = array('import/truncated.CSV');
// Read CSV file into array
$parsedData = getParsedData($files, $ignoreList);

// Categorize each line item, appending category
$newData = categorizePurchases($expenseCategories, $searchTerms, $parsedData);

//
// LIMIT DATA BASED ON AJAX REQUEST MODE ---------------------------------------


if ($mode && $mode=="monthly") {
	// echo "M";
}
else if ($mode && $mode=="yearly") {
	// echo "Y";
}
else {
	// show everything
}


//
// EXPENSE CATEGORY TOTALS -----------------------------------------------------
// 		Duplicate and extend top level categories constants array
//			in case we want to tally the subtotals in PHP
/*$expTotals = [];
foreach ($expenseCategories as $key => $val) {
	$expTotals[$key]["label"] = $key;
	$expTotals[$key]["value"] = 0;
	$expTotals[$key]["color"] = $val['color'];
	$expTotals[$key]["highlight"] = "#BEBEBE";	// "#747474";
}
// Aggregate by category in PHP - requires block above
foreach($newData as $key => $dataRow) {
	pr($key);


	foreach($expTotals as $labelIndex => $labelAndValue) {
		if ($dataRow['label'] == $labelAndValue['label']) {
			$expTotals[$labelIndex]['value'] += floatval($dataRow['value']);
		}
	}

}
pr($expTotals);

// Sort subtotals asceding
uasort($expTotals, function($a, $b) {
    return $a['value'] - $b['value'];
});

// Reverse order (descending)
$expTotals = array_reverse($expTotals);
*/

//
// DETAILED CHARGE DATA --------------------------------------------------------
// 		Sort individual charge data descending
function date_compare($a, $b) {
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t2 - $t1;
}
//usort($newData, 'date_compare');

//
// PREPARE JSON   ---------------------------------------------------------------
//

echo json_encode(
	array(
		//"subtotals" => $expTotals,
		"expenseCategories" => $expenseCategories,
		"chargeData" => $newData,
		"years" => $years,
	)
);


/*
$fp = fopen('export/expenses.json', 'w');
fwrite($fp, json_encode($expTotals));
fclose($fp);
*/

// FORMAT EXPECTED
// per https://github.com/nnnick/Chart.js/blob/master/samples/doughnut.html
/*
	[
		{
			value: 300,
			color:"#F7464A",
			highlight: "#FF5A5E",
			label: "Red"
		},
	]
*/

/*
// DUMP TO CSV
$fp = fopen('export/out.csv', 'w');
foreach ($parsedData as $fields) {
	fputcsv($fp, $fields);
}
fclose($fp);
*/


?>
