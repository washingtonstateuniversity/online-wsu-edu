<?php
/**
 * WordPress_Sniffs_NamingConventions_ValidVariableNameSniff.
 *
 * Based on Squiz_Sniffs_NamingConventions_ValidVariableNameSniff:
 * @link https://github.com/squizlabs/PHP_CodeSniffer/blob/ed257ca0e56ad86cd2a4d6fa38ce0b95141c824f/CodeSniffer/Standards/Squiz/Sniffs/NamingConventions/ValidVariableNameSniff.php
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @author    Weston Ruter
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

if ( class_exists( 'PHP_CodeSniffer_Standards_AbstractVariableSniff', true ) === false ) {
	throw new PHP_CodeSniffer_Exception( 'Class PHP_CodeSniffer_Standards_AbstractVariableSniff not found' );
}

/**
 * WordPress_Sniffs_NamingConventions_ValidVariableNameSniff.
 *
 * Checks the naming of variables and member variables.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @author    Weston Ruter
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class WordPress_Sniffs_NamingConventions_ValidVariableNameSniff extends PHP_CodeSniffer_Standards_AbstractVariableSniff {

	/**
	 * PHP Reserved Vars.
	 *
	 * @var array
	 */
	public $php_reserved_vars = array(
		'_SERVER',
		'_GET',
		'_POST',
		'_REQUEST',
		'_SESSION',
		'_ENV',
		'_COOKIE',
		'_FILES',
		'GLOBALS',
		'http_response_header',
		'HTTP_RAW_POST_DATA',
		'php_errormsg',
	);

	/**
	 * List of member variables that can have mixed case.
	 *
	 * @var array
	 */
	public $whitelisted_mixed_case_member_var_names = array(
		'ID',
		'comment_ID',
		'comment_post_ID',
		'post_ID',
		'comment_author_IP',
	);

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param PHP_CodeSniffer_File $phpcs_file The file being scanned.
	 * @param int                  $stack_ptr  The position of the current token in the
	 *                                        stack passed in $tokens.
	 *
	 * @return void
	 */
	protected function processVariable( PHP_CodeSniffer_File $phpcs_file, $stack_ptr ) {
		$tokens  = $phpcs_file->getTokens();
		$var_name = ltrim( $tokens[ $stack_ptr ]['content'], '$' );

		// If it's a php reserved var, then its ok.
		if ( in_array( $var_name, $this->php_reserved_vars ) === true ) {
			return;
		}

		$obj_operator = $phpcs_file->findNext( array( T_WHITESPACE ), ( $stack_ptr + 1 ), null, true );
		if ( T_OBJECT_OPERATOR === $tokens[ $obj_operator ]['code'] ) {
			// Check to see if we are using a variable from an object.
			$var = $phpcs_file->findNext( array( T_WHITESPACE ), ($obj_operator + 1), null, true );
			if ( T_STRING === $tokens[ $var ]['code'] ) {
				$bracket = $phpcs_file->findNext( array( T_WHITESPACE ), ($var + 1), null, true );
				if ( T_OPEN_PARENTHESIS !== $tokens[ $bracket ]['code'] ) {
					$obj_var_name = $tokens[ $var ]['content'];

					// There is no way for us to know if the var is public or
					// private, so we have to ignore a leading underscore if there is
					// one and just check the main part of the variable name.
					$original_var_name = $obj_var_name;
					if ( substr( $obj_var_name, 0, 1 ) === '_' ) {
						$obj_var_name = substr( $obj_var_name, 1 );
					}

					if ( ! in_array( $obj_var_name, $this->whitelisted_mixed_case_member_var_names, true ) && self::isSnakeCase( $obj_var_name ) === false ) {
						$error = 'Variable "%s" is not in valid snake_case format';
						$data  = array( $original_var_name );
						$phpcs_file->addError( $error, $var, 'NotSnakeCaseMemberVar', $data );
					}
				}//end if
			}//end if
		}//end if

		// There is no way for us to know if the var is public or private,
		// so we have to ignore a leading underscore if there is one and just
		// check the main part of the variable name.
		$original_var_name = $var_name;
		if ( substr( $var_name, 0, 1 ) === '_' ) {
			$obj_operator = $phpcs_file->findPrevious( array( T_WHITESPACE ), ( $stack_ptr - 1 ), null, true );
			if ( T_DOUBLE_COLON === $tokens[ $obj_operator ]['code'] ) {
				// The variable lives within a class, and is referenced like
				// this: MyClass::$_variable, so we don't know its scope.
				$in_class = true;
			} else {
				$in_class = $phpcs_file->hasCondition( $stack_ptr, array( T_CLASS, T_INTERFACE, T_TRAIT ) );
			}

			if ( true === $in_class ) {
				$var_name = substr( $var_name, 1 );
			}
		}

		if ( self::isSnakeCase( $var_name ) === false ) {
			$error = 'Variable "%s" is not in valid snake_case format';
			$data  = array( $original_var_name );
			$phpcs_file->addError( $error, $stack_ptr, 'NotSnakeCase', $data );
		}

	}

	/**
	 * Processes class member variables.
	 *
	 * @param PHP_CodeSniffer_File $phpcs_file The file being scanned.
	 * @param int                  $stack_ptr  The position of the current token in the
	 *                                        stack passed in $tokens.
	 *
	 * @return void
	 */
	protected function processMemberVar( PHP_CodeSniffer_File $phpcs_file, $stack_ptr ) {

		$tokens = $phpcs_file->getTokens();

		$var_name     = ltrim( $tokens[ $stack_ptr ]['content'], '$' );
		$member_props = $phpcs_file->getMemberProperties( $stack_ptr );
		if ( empty( $member_props ) === true ) {
			// Couldn't get any info about this variable, which
			// generally means it is invalid or possibly has a parse
			// error. Any errors will be reported by the core, so
			// we can ignore it.
			return;
		}

		$error_data = array( $var_name );
		if ( ! in_array( $var_name, $this->whitelisted_mixed_case_member_var_names, true ) && self::isSnakeCase( $var_name ) === false ) {
			$error = 'Member variable "%s" is not in valid snake_case format.';
			$phpcs_file->addError( $error, $stack_ptr, 'MemberNotSnakeCase', $error_data );
		}

	}


	/**
	 * Processes the variable found within a double quoted string.
	 *
	 * @param PHP_CodeSniffer_File $phpcs_file The file being scanned.
	 * @param int                  $stack_ptr  The position of the double quoted
	 *                                        string.
	 *
	 * @return void
	 */
	protected function processVariableInString( PHP_CodeSniffer_File $phpcs_file, $stack_ptr ) {
		$tokens = $phpcs_file->getTokens();

		if ( preg_match_all( '|[^\\\]\${?([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)|', $tokens[ $stack_ptr ]['content'], $matches ) !== 0 ) {
			foreach ( $matches[1] as $var_name ) {
				// If it's a php reserved var, then its ok.
				if ( in_array( $var_name, $this->php_reserved_vars ) === true ) {
					continue;
				}

				if ( self::isSnakeCase( $var_name ) === false ) {
					$error = 'Variable "%s" is not in snake_case format';
					$data  = array( $var_name );
					$phpcs_file->addError( $error, $stack_ptr, 'StringNotSnakeCase', $data );
				}
			}
		}

	}

	/**
	 * Return whether the variable is in snake_case.
	 *
	 * @param string $var_name
	 * @return bool
	 */
	static function isSnakeCase( $var_name ) {
		return (bool) preg_match( '/^[a-z0-9_]+$/', $var_name );
	}
}//end class
