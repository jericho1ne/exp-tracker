<?php
require_once("common.php");

$mode = set($_GET["mode"]);

/*
	Expected CSV format -- Citibank-style (with array indices)

	0		1			2				 3		4
  	Status	Date		Description		 Debit  Credit
 	Cleared	11/02/2015	DEBIT PURCHASE	 11.85  ---

*/

$years = array('2015', '2014');
// $files = array('import/CHK_862_010115_121315.CSV', 'import/MC_359_010115_121315.CSV');

// Set the base directory where you'll be storing your CSV dumps
$directory = 'import';

// Grab files in reverse order (files first, directories last)
$files = scandir($directory, 1);

$csvList = [];
// Check file extensions, add to array if CSVs found
foreach($files as $file) {
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	if (strtolower($ext) === "csv") {
		$csvList[] = $directory . '/' .  $file;
	}
}

// In case one wants to manually test with a differently-formatted CSV
// $csvList = array('import/truncated.CSV');

// Read CSV file into array
$parsedData = getParsedData($csvList, $ignoreList);

// If all good
if ($parsedData['success']) {
	unset ($parsedData['success']);

	$message = $parsedData['message'];
	unset ($parsedData['message']);

	// Categorize each line item, appending category
	$newData = categorizePurchases($expenseCategories, $searchTerms, $parsedData);

	echo json_encode(
		array(
			"success" => true,
			"message" => $message,
			"expenseCategories" => $expenseCategories,
			"chargeData" => $newData['charges'],
			"years" => $years
		)
	);
}
// Problems, Houston...
else {
	echo json_encode(
		array(
			"success" => false,
			"message" => $parsedData['message']
		)
	);
}


//
// PREPARE JSON   ---------------------------------------------------------------
//


//
// LIMIT DATA BASED ON AJAX REQUEST MODE ---------------------------------------
// if ($mode && $mode=="monthly") {
// 	// echo "M";
// }
// else if ($mode && $mode=="yearly") {
// 	// echo "Y";
// }
// else {
// 	// show everything
// }



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
