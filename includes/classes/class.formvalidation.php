<?php
# =================================================================== #
#
# iMarc PHP Library
# Copyright 2002, iMarc, LLC
#
# @version: 1.4
# @last_update: 2003-01-01
# @description: Form Validation Functions
#
# @changes: v1.4 - Added isset() when validating (compatibale with PHP error notices)
# 
# =================================================================== #
/*
	METHODS:
		validate_fields() 	- Validates a comma-separated string of $required_fields
		create_error() 	- Private class function to handle errors
*/
# ------------------------------------------------------------------- #
# VALIDATOR CLASS
# ------------------------------------------------------------------- #
class validator {
	var $error, $error_message;		// (string) HTML formatted error message
	var $error_array = array();		// (array)	Error

	# ----------------------------------- #
	# FUNCTION: 	validate_fields
	# DESCRIPTION: 	Validates a comma-separated string of $required_fields
	#
	# ARGS: 		$required_fields	(string) comma separated string of required form field names
	# 
	# RETURNS:		TRUE if all form fields are not NULL, FALSE if at least one fields is NULL.
	# ----------------------------------- #
	function validate_fields($required_fields='') {
		if (!$required_fields) {
			return true;
		}
		$__errors = array();

		// Delete all spaces from the field names and place the them in an array.
		$__fields = explode (",", str_replace(" ", "", $required_fields));
		foreach ($__fields as $__current_field) {	
			if (trim($__current_field)) {
				if (strstr($__current_field, "||")) {
	
					/* * * *  "OR" fields * * * */
					
					// this_field||that_field - double pipe separated field names will check <this_field> or <that_field>
					$__error      = false;
					$__no_error   = false;
					$__sub_fields = explode("||", $__current_field);
		
					foreach ($__sub_fields as $__current_sub_field) {
						$__current_sub_field = trim($__current_sub_field);
						
						settype($_REQUEST[$__current_sub_field], "string");
						
						if (!$__no_error && isset($_REQUEST[$__current_sub_field]) && !strlen(trim($_REQUEST[$__current_sub_field]))) {
							$__error      = true;
						} else {
							$__no_error   = 1;
							$__error      = false;
						}
					}

					if ($__error) {
						$__errors[] = $__current_field;
					}
				} else {
					
					/* * * *  Regular fields * * * */
					
					// This separates regular single fields and makes them global variables
					$__current_field = trim($__current_field);				
					settype($_REQUEST[$__current_field], "string");

					if (isset($_REQUEST[$__current_field]) && !strlen(trim($_REQUEST[$__current_field]))) {
						$__errors[] = $__current_field;
					}
				}
			}
		}
		
		if (count($__errors)) {
			$this->create_error($__errors, "validate_fields");
			return FALSE;
		} else {
			return TRUE;
		}
	}

/* Private */
	# ----------------------------------- #
	# FUNCTION: 	create_error
	# DESCRIPTION: 	Creates error messages
	#
	# ARGS: 		$error		(mixed)  error message[s]
	# 				$type		(string) type of error
	# 
	# RETURNS:		VOID
	#				Sets $obj->error and $obj->error_array
	# ----------------------------------- #
	function create_error($error, $type='') {
		$this->error = ereg_replace("<br>$", "", $this->error);
		
		if ($type == "validate_fields") {
			$r = "<font color=\"#FF0000\"><b>Please fill in the following fields:</b></font><br>\n";
			foreach ($error as $v) {
				$i  = 1;
				$r .= "&nbsp;&nbsp;&nbsp;&#149;&nbsp;";
				$v_array = explode("||", $v);
				foreach ($v_array as $c) {
					if (trim($c)) {
						if ($i > 1) { $r .= " <b>or</b> "; }
						$missing_fields[] = $c;
						$r .= ucwords(eregi_replace("_", " ", $c));
						$i++;
					}
				}
				$r .= "<br>\n";
			}
			$this->error .= $r;
			$this->error_array['missing_fields'] = $missing_fields;
		
		} elseif ($type == "message") {
			if (!$this->error_array['message']) {
				$this->error .= "<b>The following errors occured:</b><br>\n";
			}
			$this->error .= "&nbsp;&nbsp;&nbsp;&#149;&nbsp;" . $error . "<br>\n";
			$this->error_array['message'][] = $missing_fields;
		}
		$this->error .= "<br>";
		$this->error_message = $this->error;
	}

    /**
     * Adds a custom header.
     * @return void
     */
    function AddCustomHeader($custom_header) {
        $this->CustomHeader[] = explode(":", $custom_header, 2);
    }
	 
	 /**
	  * Validates an email address
	  * Added: KJR 11/27/2006
	  * http://www.planet-source-code.com/vb/scripts/ShowCode.asp?txtCodeId=1316&lngWId=8
	 */
	function checkEmail($email) {
		if( (preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $email)) || (preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/',$email)) ) {
			$host = explode('@', $email);
			if (function_exists('checkdnsrr')) {
				if(checkdnsrr($host[1].'.', 'MX') ) return true;
				if(checkdnsrr($host[1].'.', 'A') ) return true;
				if(checkdnsrr($host[1].'.', 'CNAME') ) return true;
			} else {
				return true;
			}
		}
		return false;
	}
}

/*
<readme>
	
	Validator Class is a PHP object that can be used to validate 
	the presence of HTML form data. 
	
	By "validating", the function simply checks if a variable is 
	NOT NULL. The class is intended to be called AFTER the end-user 
	has submitted an HTML form. 
	
	The class is first initiated, then the validate_fields function 
	is called by passing the field names of all the required form 
	fields. If any of the variables (field names) are NULL the 
	function returns FALSE, along with an error message of which 
	fields are null. If all the variables are NOT NULL, the function 
	returns TRUE. 
	
	# --------------------------------------------------------------- #
	# VALIDATOR CLASS USAGE
	# --------------------------------------------------------------- #
	- Start a new instance of the object:
	  $my_validator = new validator();
	
	- Check for the presence of data in one variable named $my_variable
	  $my_validator->validate_fields("my_variable");
	
	- Check for the presence of data in three variables 
	  named $first_name, $last_name, and $email
	  $my_validator->validate_fields("first_name, last_name, email");
	
	- Check for the presence of data in at least one check box. There
	  are 3 checkboxes on the form ($ch_1, $ch_2, and $ch_3)
	  $my_validator->validate_fields("ch_1||ch_3||ch_3");
	
	- Check for the presence of data in at least one check box, 
	  AND each of 2 text fields:
	  $my_validator->validate_fields("ch_1||ch_3||ch_3, text_1, text_2");
	  
	- Printing Errors
		if (!$my_validator->validate_fields("last_name, email")) {
			echo $my_validator->error;
		} else {
			...
		}
	
	# --------------------------------------------------------------- #
	# VALIDATOR CLASS SET UP
	# --------------------------------------------------------------- #
	The only set up is to include this file on the page that you're 
	using it

</readme>

<license>

	Copyright (c) 2002, iMarc LLC
	All rights reserved.
	
	Redistribution and use in source and binary forms, with or without 
	modification, are permitted provided that the following conditions 
	are met:
	
	*	Redistributions of source code must retain the above copyright 
	    notice, this list of conditions and the following disclaimer.
	*	Redistributions in binary form must reproduce the above 
	    copyright notice, this list of conditions and the following 
	    disclaimer in the documentation and/or other materials 
	    provided with the distribution.
	*	Neither the name of iMarc LLC nor the names of its 
	    contributors may be used to endorse or promote products 
	    derived from this software without specific prior 
	    written permission.
	
	
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND 
	CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
	INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF 
	MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE 
	DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS 
	BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, 
	EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED 
	TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, 
	DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON 
	ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
	OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY 
	OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
	POSSIBILITY OF SUCH DAMAGE.

</license>

*/
?>