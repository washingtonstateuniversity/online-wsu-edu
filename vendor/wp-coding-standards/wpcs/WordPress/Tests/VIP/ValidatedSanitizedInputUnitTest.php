<?php
/**
 * Unit test class for the ValidatedSanitizedInputSniff
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Shady Sharaf <shady@x-team.com>
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

class WordPress_Tests_VIP_ValidatedSanitizedInputUnitTest extends AbstractSniffUnitTest
{


	/**
	 * Returns the lines where errors should occur.
	 *
	 * The key of the array should represent the line number and the value
	 * should represent the number of errors that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getErrorList()
	{
		return array(
			5 => 3,
			7 => 1,
			10 => 1,
			20 => 1,
			33 => 3,
			65 => 1,
			79 => 1,
			80 => 1,
			81 => 1,
			82 => 1,
			85 => 1,
			90 => 1,
			93 => 1,
			96 => 1,
			100 => 2,
			101 => 1,
			104 => 2,
			105 => 1,
			114 => 2,
			);

	}//end getErrorList()


	/**
	 * Returns the lines where warnings should occur.
	 *
	 * The key of the array should represent the line number and the value
	 * should represent the number of warnings that should occur on that line.
	 *
	 * @return array(int => int)
	 */
	public function getWarningList()
	{
		return array();

	}//end getWarningList()


}//end class

?>
