<?php

use TTP_Results\Installer;

require_once(__DIR__ . '/TestConfig.php');
require_once(TTP_RESULTS_SRCPATH . '/vendor/autoload.php');

class InstallerTest extends PHPUnit_Framework_TestCase {

	function testConstructor() {
		require_once(WP_PATH . '/wp-load.php');

		$page = array(
			'name' => 'test-page',
			'title' => __( 'Test', 'test' ),
			'tag' => '[testpage]'
		);
		
		$installer = new TTP_Results\Installer($GLOBALS['wpdb']);
	
		// Tag shouldn't exist
		$pageId = $installer->pageExistsByTag($page['tag']);
		$this->assertNull($pageId, 'pageId not null');
		
		// Create the page
		$pageId = $installer->ensurePageExists($page);
		$this->assertNotNull($pageId, 'pageId should not be null');
//		$this->assertInternalType('string', $pageId);

		// Check that it exists
		$pageId1 = $installer->pageExistsByTag($page['tag']);
		$this->assertEquals($pageId, $pageId1);
		
		// Delete the page
		$installer->removePage($page);
				
		// Tag shouldn't exist
		$pageId = $installer->pageExistsByTag($page['tag']);
		$this->assertNull($pageId, 'pageId not null');
	}
	
}



?>
