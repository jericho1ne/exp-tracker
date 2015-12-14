<?php

$ignoreList = array(
	"",
	"ONLINE PAYMENT", 
	"PAYMENT THANK YOU", 
	"ONLINE PAYMENT, THANK YOU", 
	"ONLINE - TRANSFER",
);

// CONSTANTS
define("TYPE_GROC", "groceries");
define("TYPE_REST", "restaurant");
define("TYPE_SPRT", "sport");
define("TYPE_TRAN", "transit");

define("TYPE_ENTC", "entertainment");
define("TYPE_HOME", "home");
define("TYPE_COFF", "coffee");
define("TYPE_ELEC", "electronics");

define("TYPE_FLHT", "flighthotel");
define("TYPE_HEAL", "health");
define("TYPE_UTIL", "rent & utilities");
define("TYPE_BIZT", "business");

define("TYPE_UNKN", "unknown");
define("TYPE_CASH", "atm");
define("TYPE_FEES", "fee");
define("TYPE_OTHR", "other");

$expenseCategories = array(
	//TYPE_GROC, TYPE_REST, TYPE_SPRT, TYPE_TRAN,
	TYPE_GROC => array(
		"color" => "#CC9966"
	),
	TYPE_REST => array(
		"color" => "#CCCC66"
	),
	TYPE_SPRT =>array(
		"color" => "#33CCFF"
	),
	TYPE_TRAN => array(
		"color" => "#6699CC"
	),
	
	//TYPE_ENTC, TYPE_HOME, TYPE_COFF, TYPE_ELEC,
	TYPE_ENTC => array(
		"color" => "#CC6666"
	),
	TYPE_HOME => array(
		"color" => "#CAFF7A"
	),
	TYPE_COFF => array(
		"color" => "#8A5C2E"
	),
	TYPE_ELEC => array(
		"color" => "#CC6699"
	),
	
	//TYPE_FLHT, TYPE_HEAL, TYPE_UTIL, TYPE_BIZT,
	TYPE_FLHT => array(
		"color" => "#2E5C8A"
	),
	TYPE_HEAL => array(
		"color" => "#3D7AB8"
	),
	TYPE_UTIL => array(
		"color" => "#66CCCC"
	),
	TYPE_BIZT => array(
		"color" => "#F53D00"
	),

	//TYPE_UNKN, TYPE_CASH, TYPE_FEES, TYPE_OTHR
	TYPE_UNKN => array(
		"color" => "#CCCCCC"
	),
	TYPE_CASH => array(
		"color" => "#66CC66"
	),
	TYPE_FEES => array(
		"color" => "#6666CC"
	),
	TYPE_OTHR => array(
		"color" => "#dddddd"
	),
);

// Expense categories
$searchTerms = array(
	TYPE_GROC => array(
		'abbr' => TYPE_GROC,
		'name' => "Groceries",
		'terms' => array(
			"WHOLEFDS", 
			"BRISTOL", 
			"CO-OPPORTUNITY",
			"SUPERMARKE",
			"market",
			"tesco",
			"RALPHS",
			"Vons",
			"Trader Joe",
			"MENDOCINO FARMS",
			"FRANPRIX",
			"DIRK VAN DEN",
			"MITSUWA",
			"foodland",
			"SAFEWAY",
			"WALGREENS",
			"7-ELEVEN",
			"ALDI",
			"FresH AND WILD",
			"SAINSBURYS",
			"HEMA EVO",
		)
	),

	TYPE_REST => array(
		'abbr' => TYPE_REST,
		'name' => "Restaurants",
		'terms' => array(
			"RESTAURANT", 
			"Bistro", 
			"Burger", 
			"DELI AND TAPA",
			"SWEETGREEN", 
			"WINE BAR",
			"800 DEGREES",
			"BRICK AND MORTAR",
			"GALBI",
			"TWO BOOTS",
			"KOREAN BBQ",
			"Chomp",
			"LE PAIN QUOTIDIEN",
			"PANERA",
			"Sasaya",
			"Pizza",
			"Sushi",
			"TENDER GREENS",
			"Yogurt",
			"LE TIRE BOUCHON",
			"Bagels",
			"JUICE BAR",
			"JAMBA JUICE",
			"CARL'S JR",
			"DAICHAN",
			"THE ANCHOR VENICE",
			"IL TRAMEZZINO",
			"Grill",
			"Wokcano",
			"Grand View Liquor",
			"CUISINE",
			"ROCK & BREWS",
			"Gelato",
			"Kitchen",
			"MINIT STOP",
			"BOSSA NOVA PICO",
			"JIMMY JOHNS",
			"CONNIE & TEDS",
			"GORDON BIERSCH",
			"IN A BOX",
			"SIAM CHAN",
			"STEAK-N-SHAKE",
			"COCINA",
			"ROTI",
			"WAJI'S",
			"BLUE COW",
			"LUCYS LUNCHBOX",
			"T6 HOME TURF",
			"PLAN CHECK",
			"BUFFET",
			"BELLAGIO - JPM",
			"NAAN HUT",
			"BAY CITIES ITALIAN",
			"DFS GALLERIA",
			"TAMURA'S FINE WINE",
			"NOODLE",
			"MCDONALD'S",
			"SONNY MCLEANS",
			"BAR & REST",
			"EL SEGUNDO SOL",
			"THE BIG CATCH",
			"DENNY'S",
			"PUBLIC HOUSE",
			"REST&WINE",
			"SQ *DAIRY",
			"PICHET - B1"
		)
	),
	
	TYPE_SPRT => array(
		'name' => "Sports and Outdoors",
		'abbr' => TYPE_SPRT,
		'terms' => array(
			"CYNERGY", 
			"REI",
			"SPORTING GOODS",
			"Patagonia",
			"SPORTS",
			"SPORT",
			"Cycling",
			"Cycles",
			"Bike",
			"Boardriders",
			"CA PARKS",
			"NIKE",
			"HALFORDS FILIAAL",
			"EASTSIDE SPOR BISHOP",
			"RACEMILL",
			"ACTIVE.com",
			"JENSONUSA",
			"FOOT LOCKER",
			"MAUI TROPIX",
			"Tweewielers",
		)
	),

	TYPE_TRAN => array(
		'name' => "Transit",
		'abbr' => TYPE_TRAN,
		'terms' => array(
			"UBER",
			"LA TRANSIT",
			"LYFT", 
			"LA METRO",
			"RENT A CAR",
			"RENT-A-CAR",
			"SHELL OIL",
			"Parkin",
			"Gasoline",
			"CHEVRON",
			"Rail Link",
			"EUROSTAR",
			"EXXON",
			"SANTA MONICA BMW",
			"SM-DWNTWN STRUCT",
			"RAILWAY",
			"LUL TICKET",
		)
	),
	
	TYPE_ENTC => array(
		'abbr' => TYPE_ENTC,
		'name' => "Entertaiment & Cultural",
		'terms' => array(
			"AMC",
			"Echoplex",
			"the echo",
			"UCLA CENTRAL TICKET",
			"TicketfLy",
			"Townhouse",
			"The Regent",
			"Record Surplus",
			"PACIFIC PARK ADMISSION",
			"GOLDSTAR EVENTS",
			"TM *",
			"Wiltern",
			"Box off",
			"MUSEUM",
			"THE LANDMARK",
			"AXS TIX",
		)
	),
	
	TYPE_HOME => array(
		'name' => "Home & Self Improvement",
		'abbr' => TYPE_HOME,
		'terms' => array(
			"ORCHARD SUPPLY", 
			"LOWES", 
			"HOME DEPOT",
			"Target",
			"CENTRAL REST PRODUCTS",
		)
	),
	
	TYPE_COFF => array(
		'name' => "Coffee & Donuts",
		'abbr' => TYPE_COFF,
		'terms' => array(
			"THE REFINERY", 
			"ESPRESSO", 
			"COFFEE", 
			"STARBUCKS",
			"KREME",
			"COFFEE BEAN",
			"PEETS",
			"Donuts",
			"Bakery",
			"AMANDINE",
			"CAFFE",
			"CAFE",
			"HMSHOST AMSTERDAM",
			"PP*BASANTI",
		)
	),
	
	TYPE_ELEC => array(
		'name' => "Cameras & Electronics",
		'abbr' => TYPE_ELEC,
		'terms' => array(
			"Adorama", 
			"Amazon", 
			"CAMERA",
			"AMZ*Woot",
			"APPLE STORE",
			"APPLEONLINE",
		)
	),

	TYPE_FLHT => array(
		'name' => "Flights & Housing",
		'abbr' => TYPE_FLHT,
		'terms' => array(
			"Hotel", 
			"HOSTEL",
			"VIR AMER", 
			"Southwes",
			"EASYJET",
			"AirBnB",
			"JETPAK ALTERNATIVE",
			"TAROM",
			"BRITISH",
			"LODGE",
			"ORBITZ",
			"ASTOR HYDE PARK",
			"Hawaiian",
			'BANANA BUNGALOW',
			"TRAVEL",
			"UNITED",
			"ALASKA AIR",
			"HI SF",
			"ALITALIA",
		)
	),

	TYPE_HEAL => array(
		'name' => "Health & Medical",
		'abbr' => TYPE_HEAL,
		'terms' => array(
			"Health", 
			"HEALING",
			"Massage", 
			"THERAPY", 
			"MASSGE PLACE", 
			"RICHARD HABR DDS"
		)
	),
	
	TYPE_UTIL => array(
		'name' => "Utilities & Recurring",
		'abbr' => TYPE_UTIL,
		'terms' => array(
			"T-MOBILE", 
			"MNTLY SRVC CHGE", 
			"TIME WARNER CABLE",
			"TELEPH",
			"T MOBILE",
			"LADWP",
			"EE LIMITED",
		)
	),

	TYPE_BIZT => array(
		'name' => "Business & Tech",
		'abbr' => TYPE_BIZT,
		'terms' => array(
			"NAME.COM",
			"THE LAW ALLIAN",
			"BARASCH",
			"COLOFT",
			"SUBLIMEHQ",
			"NEXTSPACE",
			"SKR*ENVATO.COM",
			"ROPOT DEVELOPMENT",
			"UCLA BRUINCARD",
		)
	),

	/*
	TYPE_EXCH => array(
		'name' => "Transfers",
		'abbr' => TYPE_EXCH,
		'terms' => array("ONLINE - TRANSFER")
	),
	*/

	TYPE_CASH => array(
		'name' => "ATM & Cash Withdrawal",
		'abbr' => TYPE_CASH,
		'terms' => array(
			"ATM Withdrawal"
		)
	),

	TYPE_FEES => array(
		'name' => "Fees & Violations",
		'abbr' => TYPE_FEES,
		'terms' => array(
			"INTEREST CHARGED",
			"MEMBERSHIP FEE",
		)
	),
	
	TYPE_OTHR => array(
		'name' => "Other Expenses",
		'abbr' => TYPE_OTHR,
		'terms' => array(
			"AAHS GIFT",
			"SALON AND SP",
			"POST OFFICE",
			"UCLA STORE",
			"SAKS FIFTH AVENUE",
			"H&M",
			"MACY'S",
			"MARKS & SPENCER",
			"Debit Purchase",
			"Other Decrease",
			"Debit Pin Purchase",
		)		
	),
);

?>