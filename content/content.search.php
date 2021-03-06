<?php
/**
 * Copyright: Deux Huit Huit 2017
 * LICENCE: MIT https://deuxhuithuit.mit-license.org
 */

require_once(TOOLKIT . '/class.jsonpage.php');

class contentExtensionEntry_relationship_fieldSearch extends JSONPage
{
	public function view()
	{
		if (class_exists('FLang')) {
			try {
				FLang::setMainLang(Lang::get());
				FLang::setLangCode(Lang::get(), '');
			} catch (Exception $ex) { }
		}
		
		$section = General::sanitize($this->_context[0]);
		$sectionId = SectionManager::fetchIDFromHandle($section);
		$sectionId = General::intval($sectionId);
		$excludes = !isset($this->_context[1]) ? null : array_filter(
			array_map(
				array('General', 'intval'),
				explode(',', General::sanitize($this->_context[1]))
			),
			function ($item) {
				return $item !== -1;
			}
		);
		if (empty($excludes)) {
			$excludes = '';
		} else {
			$excludes = " AND `e`.`id` NOT IN (" . implode(',', $excludes) . ") ";
		}

		if ($sectionId < 1) {
			$this->_Result['status'] = Page::HTTP_STATUS_BAD_REQUEST;
			$this->_Result['error'] = __('No section id found');
			return;
		}

		$section = SectionManager::fetch($sectionId);

		if (empty($section)) {
			$this->_Result['status'] = Page::HTTP_STATUS_NOT_FOUND;
			$this->_Result['error'] = __('Section not found');
			return;
		}

		$query = General::sanitize($_GET['query']);
		$entries = array();
		$filterableFields = $section->fetchFilterableFields();
		if (empty($filterableFields)) {
			$this->_Result['status'] = Page::HTTP_STATUS_BAD_REQUEST;
			$this->_Result['error'] = __('Section not filterable');
			return;
		}

		$primaryField = $section->fetchVisibleColumns();
		if (empty($primaryField)) {
			$primaryField = current($filterableFields);
			reset($filterableFields);
		} else {
			$primaryField = current($primaryField);
		}

		foreach ($filterableFields as $fId => $field) {
			EntryManager::setFetchSorting($fId, 'ASC');
			$fQuery = $query;
			$joins = '';
			$where = $excludes;
			$opt = array_map(function ($op) {
				return trim($op['filter']);
			}, $field->fetchFilterableOperators());
			if (in_array('regexp:', $opt)) {
				$fQuery = 'regexp: ' . $fQuery;
			}
			$field->buildDSRetrievalSQL(array($fQuery), $joins, $where, false);
			$fEntries = EntryManager::fetch(null, $sectionId, 10, 0, $where, $joins, true, false);
			if (!empty($fEntries)) {
				$entries = array_merge($entries, $fEntries);
			}
		}

		EntryManager::setFetchSorting('system:id', 'ASC');
		if (!empty($entries)) {
			$entries = EntryManager::fetch(array_unique(array_map(function ($e) {
				return $e['id'];
			}, $entries)), $sectionId);
		}

		$entries = array_map(function ($entry) use ($primaryField) {
			return array(
				'value' => $entry->get('id') . ':' .
					$primaryField->prepareReadableValue(
						$entry->getData($primaryField->get('id')),
						$entry->get('id')
				),
			);
		}, $entries);

		$this->_Result['entries'] = $entries;
	}
}
