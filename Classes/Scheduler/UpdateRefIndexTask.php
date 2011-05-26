<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 AOE media GmbH <dev@aoemedia.de>
*  			
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('scheduler') . 'class.tx_scheduler_task.php');
require_once PATH_tx_update_refindex . 'Classes/Typo3/RefIndex.php';

/**
 * scheduler-task to update refindex of TYPO3
 * 
 * @package update_refindex
 * @subpackage Typo3
 */
class Tx_UpdateRefindex_Scheduler_UpdateRefIndexTask extends tx_scheduler_Task {
	/**
	 * commma-separated list of tables
	 * @var string
	 */
	public $updateRefindexSelectedTables;
	/**
	 * @var Tx_UpdateRefindex_Typo3_RefIndex
	 */
	private $refIndex;

	/**
	 * execute the task
	 * @return boolean
	 */
	public function execute() {
		$shellExitCode = TRUE;
		try {
			$this->getRefIndex()->setSelectedTables( $this->getSelectedTables() )->update();
		} catch (Exception $e) {
			$shellExitCode = FALSE;
		}
		return $shellExitCode;
	}

	/**
	 * @return array
	 */
	public function getSelectedTables() {
		return explode(',', $this->updateRefindexSelectedTables);
	}

	/**
	 * @param array $selectedTables
	 */
	public function setSelectedTables(array $selectedTables) {
		$this->updateRefindexSelectedTables = implode(',', $selectedTables);
	}

	/**
	 * @return Tx_UpdateRefindex_Typo3_RefIndex
	 */
	protected function getRefIndex() {
		if($this->refIndex === NULL) {
			$this->refIndex = t3lib_div::makeInstance('Tx_UpdateRefindex_Typo3_RefIndex');
		}
		return $this->refIndex;
	}
}