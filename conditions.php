<?php

add_filter('if_menu_conditions', 'if_menu_basic_conditions');

function if_menu_basic_conditions($conditions) {
	global $wp_roles;


	// User roles
	foreach ($wp_roles->role_names as $roleId => $role) {
		$conditions[] = array(
			'id'		=>	'user-is-' . $roleId,
			'name'		=>	sprintf(__('User is %s', 'if-menu'), $role),
			'condition'	=>	function() use($roleId) {
				global $current_user;
				return is_user_logged_in() && in_array($roleId, $current_user->roles);
			},
			'group'		=>	__('User', 'if-menu')
		);
	}


	// User state
	$conditions[] = array(
		'id'		=>	'user-logged-in',
		'name'		=>	__('User is logged in', 'if-menu'),
		'condition'	=>	'is_user_logged_in',
		'group'		=>	__('User', 'if-menu')
	);

	if (defined('WP_ALLOW_MULTISITE') && WP_ALLOW_MULTISITE === true) {
		$conditions[] = array(
			'id'		=>	'user-logged-in-current-site',
			'name'		=>	__('User is logged in for current site', 'if-menu'),
			'condition'	=>	function() {
				return current_user_can('read');
			},
			'group'		=>	__('User', 'if-menu')
		);
	}


	// Page type
	$conditions[] = array(
		'id'		=>	'front-page',
		'name'		=>	__('Front Page', 'if-menu'),
		'condition'	=>	'is_front_page',
		'group'		=>	__('Page type', 'if-menu')
	);

	$conditions[] = array(
		'id'		=>	'single-post',
		'name'		=>	__('Single Post', 'if-menu'),
		'condition'	=>	'is_single',
		'group'		=>	__('Page type', 'if-menu')
	);

	$conditions[] = array(
		'id'		=>	'single-page',
		'name'		=>	__('Page', 'if-menu'),
		'condition'	=>	'is_page',
		'group'		=>	__('Page type', 'if-menu')
	);


	// Devices
	$conditions[] = array(
		'id'		=>	'is-mobile',
		'name'		=>	__('Mobile', 'if-menu'),
		'condition'	=>	'wp_is_mobile',
		'group'		=>	__('Device', 'if-menu')
	);


	// Language
	$conditions[] = array(
		'id'		=>	'language-is-rtl',
		'name'		=>	__('Is RTL', 'if-menu'),
		'condition'	=>	'is_rtl',
		'group'		=>	__('Language', 'if-menu')
	);


	// User location
	$countries = '{"BD": "Bangladesh", "BE": "Belgium", "BF": "Burkina Faso", "BG": "Bulgaria", "BA": "Bosnia and Herzegovina", "BB": "Barbados", "WF": "Wallis and Futuna", "BL": "Saint Barthelemy", "BM": "Bermuda", "BN": "Brunei", "BO": "Bolivia", "BH": "Bahrain", "BI": "Burundi", "BJ": "Benin", "BT": "Bhutan", "JM": "Jamaica", "BV": "Bouvet Island", "BW": "Botswana", "WS": "Samoa", "BQ": "Bonaire, Saint Eustatius and Saba ", "BR": "Brazil", "BS": "Bahamas", "JE": "Jersey", "BY": "Belarus", "BZ": "Belize", "RU": "Russia", "RW": "Rwanda", "RS": "Serbia", "TL": "East Timor", "RE": "Reunion", "TM": "Turkmenistan", "TJ": "Tajikistan", "RO": "Romania", "TK": "Tokelau", "GW": "Guinea-Bissau", "GU": "Guam", "GT": "Guatemala", "GS": "South Georgia and the South Sandwich Islands", "GR": "Greece", "GQ": "Equatorial Guinea", "GP": "Guadeloupe", "JP": "Japan", "GY": "Guyana", "GG": "Guernsey", "GF": "French Guiana", "GE": "Georgia", "GD": "Grenada", "GB": "United Kingdom", "GA": "Gabon", "SV": "El Salvador", "GN": "Guinea", "GM": "Gambia", "GL": "Greenland", "GI": "Gibraltar", "GH": "Ghana", "OM": "Oman", "TN": "Tunisia", "JO": "Jordan", "HR": "Croatia", "HT": "Haiti", "HU": "Hungary", "HK": "Hong Kong", "HN": "Honduras", "HM": "Heard Island and McDonald Islands", "VE": "Venezuela", "PR": "Puerto Rico", "PS": "Palestinian Territory", "PW": "Palau", "PT": "Portugal", "SJ": "Svalbard and Jan Mayen", "PY": "Paraguay", "IQ": "Iraq", "PA": "Panama", "PF": "French Polynesia", "PG": "Papua New Guinea", "PE": "Peru", "PK": "Pakistan", "PH": "Philippines", "PN": "Pitcairn", "PL": "Poland", "PM": "Saint Pierre and Miquelon", "ZM": "Zambia", "EH": "Western Sahara", "EE": "Estonia", "EG": "Egypt", "ZA": "South Africa", "EC": "Ecuador", "IT": "Italy", "VN": "Vietnam", "SB": "Solomon Islands", "ET": "Ethiopia", "SO": "Somalia", "ZW": "Zimbabwe", "SA": "Saudi Arabia", "ES": "Spain", "ER": "Eritrea", "ME": "Montenegro", "MD": "Moldova", "MG": "Madagascar", "MF": "Saint Martin", "MA": "Morocco", "MC": "Monaco", "UZ": "Uzbekistan", "MM": "Myanmar", "ML": "Mali", "MO": "Macao", "MN": "Mongolia", "MH": "Marshall Islands", "MK": "Macedonia", "MU": "Mauritius", "MT": "Malta", "MW": "Malawi", "MV": "Maldives", "MQ": "Martinique", "MP": "Northern Mariana Islands", "MS": "Montserrat", "MR": "Mauritania", "IM": "Isle of Man", "UG": "Uganda", "TZ": "Tanzania", "MY": "Malaysia", "MX": "Mexico", "IL": "Israel", "FR": "France", "IO": "British Indian Ocean Territory", "SH": "Saint Helena", "FI": "Finland", "FJ": "Fiji", "FK": "Falkland Islands", "FM": "Micronesia", "FO": "Faroe Islands", "NI": "Nicaragua", "NL": "Netherlands", "NO": "Norway", "NA": "Namibia", "VU": "Vanuatu", "NC": "New Caledonia", "NE": "Niger", "NF": "Norfolk Island", "NG": "Nigeria", "NZ": "New Zealand", "NP": "Nepal", "NR": "Nauru", "NU": "Niue", "CK": "Cook Islands", "XK": "Kosovo", "CI": "Ivory Coast", "CH": "Switzerland", "CO": "Colombia", "CN": "China", "CM": "Cameroon", "CL": "Chile", "CC": "Cocos Islands", "CA": "Canada", "CG": "Republic of the Congo", "CF": "Central African Republic", "CD": "Democratic Republic of the Congo", "CZ": "Czech Republic", "CY": "Cyprus", "CX": "Christmas Island", "CR": "Costa Rica", "CW": "Curacao", "CV": "Cape Verde", "CU": "Cuba", "SZ": "Swaziland", "SY": "Syria", "SX": "Sint Maarten", "KG": "Kyrgyzstan", "KE": "Kenya", "SS": "South Sudan", "SR": "Suriname", "KI": "Kiribati", "KH": "Cambodia", "KN": "Saint Kitts and Nevis", "KM": "Comoros", "ST": "Sao Tome and Principe", "SK": "Slovakia", "KR": "South Korea", "SI": "Slovenia", "KP": "North Korea", "KW": "Kuwait", "SN": "Senegal", "SM": "San Marino", "SL": "Sierra Leone", "SC": "Seychelles", "KZ": "Kazakhstan", "KY": "Cayman Islands", "SG": "Singapore", "SE": "Sweden", "SD": "Sudan", "DO": "Dominican Republic", "DM": "Dominica", "DJ": "Djibouti", "DK": "Denmark", "VG": "British Virgin Islands", "DE": "Germany", "YE": "Yemen", "DZ": "Algeria", "US": "United States", "UY": "Uruguay", "YT": "Mayotte", "UM": "United States Minor Outlying Islands", "LB": "Lebanon", "LC": "Saint Lucia", "LA": "Laos", "TV": "Tuvalu", "TW": "Taiwan", "TT": "Trinidad and Tobago", "TR": "Turkey", "LK": "Sri Lanka", "LI": "Liechtenstein", "LV": "Latvia", "TO": "Tonga", "LT": "Lithuania", "LU": "Luxembourg", "LR": "Liberia", "LS": "Lesotho", "TH": "Thailand", "TF": "French Southern Territories", "TG": "Togo", "TD": "Chad", "TC": "Turks and Caicos Islands", "LY": "Libya", "VA": "Vatican", "VC": "Saint Vincent and the Grenadines", "AE": "United Arab Emirates", "AD": "Andorra", "AG": "Antigua and Barbuda", "AF": "Afghanistan", "AI": "Anguilla", "VI": "U.S. Virgin Islands", "IS": "Iceland", "IR": "Iran", "AM": "Armenia", "AL": "Albania", "AO": "Angola", "AQ": "Antarctica", "AS": "American Samoa", "AR": "Argentina", "AU": "Australia", "AT": "Austria", "AW": "Aruba", "IN": "India", "AX": "Aland Islands", "AZ": "Azerbaijan", "IE": "Ireland", "ID": "Indonesia", "UA": "Ukraine", "QA": "Qatar", "MZ": "Mozambique"}';
	$conditions[] = array(
		'id'		=>	'user-location',
		'name'		=>	__('User from country:', 'if-menu'),
		'options'	=>	json_decode($countries, true),
		'condition'	=>	function($item, $selectedOptions = []) {
			// TODO detect user country
			return in_array('GB', $selectedOptions);
		},
		'group'		=>	__('User', 'if-menu')
	);

	// Groups Plugin
	if (in_array('groups/groups.php',array_keys(get_plugins())) && class_exists('Groups_Group')) {
            $groups = Groups_Group::get_groups();
            foreach($groups as $group) {
                $group_id     = $group->group_id;
                $group_name   = $group->name;
                $conditions[] = array(
                    'id'        => 'gorup-is-'.$group_name.'-'.$group_id,
                    'name'      => __( sprintf('Group is %s' , $group_name), 'if-menu' ),
                    'condition' => function() use ($group_id) {
                            $groups_user = new Groups_User( get_current_user_id() );
                            return $groups_user->is_member($group_id);
                     },
                    'group'     => 'Groups'
                );
            }
	}

	return $conditions;
}
