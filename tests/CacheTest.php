<?php

namespace Pravodev\Laramoud\Tests;

use PHPUnit\Framework\TestCase;
use Pravodev\Laramoud\Contracts\Module;

class CacheTest extends TestCase
{
    use Module;

    protected $value_for_cache = [
        'key' => [
            'value 1',
            'value 2',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        $this->cacheInit();
    }

    /**
     * Test get value from cached before cached file generated
     * expected is return null.
     *
     * @return void
     */
    public function testGetValueBeforeCachedShouldReturnNull()
    {
        $value = $this->cache->get('test');
        $this->assertNull($value);
    }

    public function testSetValueBeforeCachedAndAfterThatCachedFileShouldExists()
    {
        $filename = $this->cache->path().'test.php';
        $this->cache->set('test', $this->value_for_cache);
        $check = file_exists($filename);
        $this->assertTrue($check);
    }

    public function testSetValueAfterCachedShouldReturnTrueAndCachedShouldHaveThreeValue()
    {
        $set = $this->cache->set('test', 'key', [
            'value 3',
        ]);

        $this->assertTrue($set);
    }

    public function testGetValueAfterCachedAndReturnCachedFileHasThreeValue()
    {
        $cached = $this->cache->get('test');
        $this->assertEquals(count($cached['key']), 3);
    }

    public function testClearCachedFile()
    {
        $this->assertTrue($this->cache->clear('test'));
    }

    public function testCachedFileShouldNotExistAfterClear()
    {
        $check = \file_exists($this->cache->path().'test.php');
        $this->assertFalse($check);
    }
}
