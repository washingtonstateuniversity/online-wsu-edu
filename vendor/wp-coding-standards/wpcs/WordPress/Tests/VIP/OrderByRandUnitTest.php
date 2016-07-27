<?php
/**
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 */
class WordPress_Tests_VIP_OrderByRandUnitTest extends AbstractSniffUnitTest {

		/**
		 * Returns the lines where errors should occur.
		 *
		 * The key of the array should represent the line number and the value
		 * should represent the number of errors that should occur on that line.
		 *
		 * @return array(int => int)
		 */
		public function getErrorList() {
			return array(
				4  => 1,
				5  => 1,
				6  => 1,
				9  => 1,
				11 => 1,
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
		public function getWarningList() {
			return array();

		} //end getWarningList()

}//end class
