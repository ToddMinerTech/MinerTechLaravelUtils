<?php

declare(strict_types=1);

namespace ToddMinerTech\MinerTechLaravelUtils;

use ToddMinerTech\MinerTechLaravelUtils\CollectionUtil;
use ToddMinerTech\MinerTechDataUtils\ResultObject;

class CollectionUtilTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test that we can successfully map a value to another
     */
    public function testMapValueInObjectArrayWithResult_FailWithSameValueWithMatch()
    {
        $data = [
            (object) [
                'idToMatch' => 'FindMe1',
                'valueToReturn' => 'FoundMe1'
            ],
            (object) [
                'idToMatch' => 'FindMe2',
                'valueToReturn' => 'FoundMe2'
            ],
        ];
        $collection = collect($data);
        
        $resultObject = CollectionUtil::mapValueInObjectCollectionWithResult('FindMe1', 'idToMatch', 'valueToReturn', $collection);
        
        $this->assertInstanceOf(ResultObject::class, $resultObject);
        $this->assertTrue($resultObject->isSuccessful);
        $this->assertEquals('FoundMe1', $resultObject->payload);
    }
    /**
     * Test that we will receive a fail status and our input string when no match is found
     */
    public function testMapValueInObjectArrayWithResult_FailWithSameValueWithoutMatch()
    {
        $data = [
            (object) [
                'idToMatch' => 'FindMe1',
                'valueToReturn' => 'FoundMe1'
            ],
            (object) [
                'idToMatch' => 'FindMe2',
                'valueToReturn' => 'FoundMe2'
            ],
        ];
        $collection = collect($data);
        
        $resultObject = CollectionUtil::mapValueInObjectCollectionWithResult('FindMe3', 'idToMatch', 'valueToReturn', $collection);
        
        $this->assertInstanceOf(ResultObject::class, $resultObject);
        $this->assertFalse($resultObject->isSuccessful);
        $this->assertEquals('FindMe3', $resultObject->payload);
    }
}
