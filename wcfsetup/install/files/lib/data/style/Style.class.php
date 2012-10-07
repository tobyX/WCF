<?php
namespace wcf\data\style;
use wcf\data\DatabaseObject;
use wcf\system\WCF;

/**
 * Represents a style.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2012 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	data.style
 * @category	Community Framework
 */
class Style extends DatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'style';
	
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'styleID';
	
	/**
	 * Returns the name of this style.
	 * 
	 * @return	string
	 */
	public function __toString() {
		return $this->styleName;
	}
	
	/**
	 * Returns the styles variables of this style.
	 * 
	 * @return	array<string>
	 */
	public function getVariables() {
		$variables = array();
		$sql = "SELECT		variable.variableName, variable.defaultValue, value.variableValue
			FROM		wcf".WCF_N."_style_variable variable
			LEFT JOIN	wcf".WCF_N."_style_variable_value value
			ON		(value.variableID = variable.variableID AND value.styleID = ?)
			ORDER BY	variable.variableID ASC";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->styleID));
		while ($row = $statement->fetchArray()) {
			$variables[$row['variableName']] = (isset($row['variableValue'])) ? $row['variableValue'] : $row['defaultValue'];
		}
		
		return $variables;
	}
}
