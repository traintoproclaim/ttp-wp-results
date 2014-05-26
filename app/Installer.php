<?php
namespace TTP_Results;

class Installer {
	/**
	 * @var array
	 */
	private $_pages;
	
	/**
	 * @var wpdb
	 */
	private $_db;
	
	function __construct($db) {
		$this->_db = $db;
		$this->_pages = array(
			'results' => array(
					'name' => 'results-page',
					'title' => __( 'Results', 'ttp_results' ),
					'tag' => '[ttpResults]'
			)
		);
		
	}

	function install() {
		foreach($this->_pages as $page) {
			$this->ensurePageExists($page);
		}
	}
	
	function uninstall() {
		foreach($this->_pages as $page) {
			$this->removePage($page);
		}
	}
	
	function pageExistsByTag($tag) {
		$sql = $this->_db->prepare(
			"SELECT ID"
			. " FROM " . $this->_db->posts
			. " WHERE post_content='%s'" 
			. " AND post_type != 'revision'"
			, $tag
		);
		$pageId = $this->_db->get_var($sql);
		return $pageId;
	}
	
	/**
	 * Ensures that the given pageId exists, creating it if necessary.
	 * @param array $page
	 * @param int $parentPageId
	 * @return int pageId
	 */
	function ensurePageExists($page, $parentPageId = 0) {
		$pageId = $this->pageExistsByTag($page['tag']);
		//if there's no page - create
		if (empty($pageId)) {
			$pageId = wp_insert_post( array(
				'post_title' 	=>	$page['title'],
				'post_type' 	=>	'page',
				'post_name'		=>	$page['name'],
				'comment_status'=>	'closed',
				'ping_status' 	=>	'closed',
				'post_content' 	=>	$page['tag'],
				'post_status' 	=>	'publish',
				'post_author' 	=>	1,
				'menu_order'	=>	0,
				'post_parent'	=>	$parentPageId
			));
		}
		return $pageId;
	}
	
	function removePage($page) {
		$this->_db->delete($this->_db->posts, array('post_content' => $page['tag']));
	}
	
}

?>