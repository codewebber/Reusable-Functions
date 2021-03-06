<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FileContentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FileContentsTable Test Case
 */
class FileContentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FileContentsTable
     */
    public $FileContents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.file_contents'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FileContents') ? [] : ['className' => 'App\Model\Table\FileContentsTable'];
        $this->FileContents = TableRegistry::get('FileContents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FileContents);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
