<?php
// BASICS
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Los_Angeles');

require_once("expenseCategories.php");

//------------------------------------------------------------------------------
//  Name:     set
//  Purpose:  silently fails when trying to echo an empty string
//------------------------------------------------------------------------------
function set(& $var) {
   if (isset($var))
      return $var;
   else
      return "";
}

//------------------------------------------------------------------------------
//  Name:     pr
//  Purpose:  formats arrays into readable text
//------------------------------------------------------------------------------
function pr($data) {
   echo "<PRE>"; print_r($data); echo "</PRE>";
}

//------------------------------------------------------------------------------
//  Name:     stringExists
//  Purpose:  check for a needle in an array haystack
//------------------------------------------------------------------------------
function stringExists($description, $arrayTerms) {
    foreach($arrayTerms as $searchTerm) {
        if(stripos($description, $searchTerm) > -1) {
            return true;
        }
    }
    //Else
    return false;
}

//------------------------------------------------------------------------------
//  Name:     getParsedData
//  Purpose:  build up an array based on input CSV file array
//------------------------------------------------------------------------------
function getParsedData($files, $ignore) {
    $parsedData = [];
    $years = [];

    // Catch-all for PHP warnings
    set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
	    // error was suppressed with the @-operator
	    if (0 === error_reporting()) {
	        return false;
	    }

	    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	});

    // If CSV files found in directory
    if ($files) {
	    foreach ($files as $fileName) {
	        $row = 0;

	        try {
	        	fopen($fileName, "r");
	        	$parsedData['success'] = true;
	        	$parsedData['message'] = 'Data loaded successfully';


	        	if (file_exists($fileName) && (($handle = fopen($fileName, "r")) !== FALSE)) {

		            // Loop through CSV data in given file
		            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
		                $numCol = count($data);
		                $row++;

		                // by default, we'd like to save this row of data
		                $insert = 1;

		                // skip header row
		                if ($row == 1) {
		                    continue;
		                }

		                // Get rid of trailing account digits
		                $data[2] = str_replace('9721', '', set($data[2]));

		                // Convert date to YYYY-mm-dd
		                $dateFmt = date("Y-m-d", strtotime($data[1]));
		                $yyyy = date("Y", strtotime($data[1]));
		                $m = date("n", strtotime($data[1]));

		                if ($yyyy == '1969') {
		                    pr(" ********* ");
		                    pr($data);
		                }
		                // Strip year, insert into unique years array if necessary
		                // $years

		                // Remove commas, fill up to two decimals
		                $valueFmt = str_replace(",", "", trim(set($data[3])));
		                $valueFmt = floatval($valueFmt);

		                // Crop description at X chars, go lowercase
		                $description = substr(trim($data[2]), 0, 64);

		                // DO NOT SAVE - if description matches anything in ignored list
		                foreach($ignore as $ignoredTerm) {
		                    //  pr($ignoredTerm . ' -- '. $fields['description']);
		                    if (stripos($description, $ignoredTerm) > -1) {
		                        $insert = 0;
		                    }
		                }

		                // DO NOT SAVE - if the debit amount is blank
		                if ($valueFmt=="") {
		                   $insert = 0;
		                }

		                if ($insert == 1) {
		                    // Save to our formatted array, inserting as 3rd column
		                    $parsedData['charges'][$yyyy][$m][] = array(
		                        "date"          => $dateFmt,                        // Y-m-d date
		                        "originaldate"  => trim($data[1]),                  // original date
		                        "description"   => ucwords(strtolower($description)),
		                        "value"         => $valueFmt
		                    );
		                }

		            }// End while
		            fclose($handle);
		        }// End if -- file read

	        }// End try
	        catch (ErrorException $e) {
	        	$parsedData['success'] = false;
	        	$parsedData['message'] = $e->getMessage();
	        }// End catch


	    }
	}
	else {
		$parsedData['success'] = false;
	    $parsedData['message'] = "No CSV files found in directory";
	}

    // Remove rows we do not care for based on ignore list
    //      Organize charge data into top-down arrays (Year, then Month)
    /*
        [2014]  - [1]
                - [2]
                - ...
                - [12]
        [2015]  - [1]
                - ...
    */
                 /*
    foreach ($parsedData as $yyyy => $m) {
     // IF description matches one of the terms the "ignore" list,
        foreach($ignore as $ignoredTerm) {
            //  pr($ignoredTerm . ' -- '. $fields['description']);
            if (stripos($fields['description'], $ignoredTerm) > -1) {
                unset($parsedData[$key]);
            }
        }

        // Or if the debit amount is blank
        if ( $fields['value']=="") {
            unset($parsedData[$key]);
        }
    }*/
    return $parsedData;
}

//------------------------------------------------------------------------------
//  Name:     categorizePurchases
//  Purpose:  append purchase category to each array iten
//------------------------------------------------------------------------------
function categorizePurchases($expenseCategories, $terms, $data) {
    $dataCopy = $data;

    // YEARLY
    foreach ($data['charges'] as $year => $monthlyData) {
        // MONTHLY
        foreach($monthlyData as $month => $days) {

            // DAILY
            foreach($days as $index => $charge) {

                //
                // CATEGORIZE
                //      Search through list of expense constants (expenseCategories.php)
                //      until a category match is found
                foreach($expenseCategories as $key => $category) {
                    //pr($key);
                    if ($key != "unknown") {
                        // If found, break and move to next row of data
                        if (stringExists($charge['description'], $terms[$key]['terms'])) {
                            $dataCopy['charges'][$year][$month][$index]['label'] = $key;
                            // Ensure not to overwrite with else case!
                            break;
                        }
                    }
                    else {
                       $dataCopy['charges'][$year][$month][$index]['label'] = "unknown";
                    }

                         // Check for amount-specific stuff, like rent
                    if ($charge['value'] == "1600" || $charge['value'] == "1648") {
                        $dataCopy['charges'][$year][$month][$index]['label'] = TYPE_UTIL;
                    }
                }// End categorization loop

            }// Daily
        }// Monthly

    }// End loop through Years of data
    return $dataCopy;
}
?>
