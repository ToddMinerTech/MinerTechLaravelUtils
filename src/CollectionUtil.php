<?php

declare(strict_types=1);

namespace ToddMinerTech\DataUtils;

use ToddMinerTech\DataUtils\StringUtil;

/**
 * Class ArrUtil
 *
 * Various array editing, search, and comparison functions
 *
 * @package ToddMinerTech\MinerTechLaravelUtils
 */
class ArrUtil
{
    /**
     * addArrIfNew
     *
     * Inserts a value into an array only if it doesn't exist yet
     * 
     * @param string $inputStr New value to insert into array
     *
     * @return array Returns the array with any update needed
     */
    public static function addArrIfNew(string $newValue, array $inputArr): array
    {
        if(!in_array($newValue, $inputArr)) {
            $inputArr[] = $newValue;
        }
        return $inputArr;
    }
    
    /**
     * matchValueInObjectArray
     *
     * Searches and returns an object from within an array using defined criteria.
     * 
     * @param string $valueToMatch The value you are trying to match within the object attribute
     * 
     * @param string $attributeToMatch The attribute name you want to check the value of
     * 
     * @param array $arrayToSearch The array of objects you are trying to match
     *
     * @return object Returns the object if matched, or null if no match is found
     */
    public static function matchValueInObjectArray(string $valueToMatch, string $attributeToMatch, array $arrayToSearch): ?object
    {
        for($i = 0; $i < count($arrayToSearch); $i++) {
            if(!isset($arrayToSearch[$i]->$attributeToMatch)) {
                continue;
            }
            if(StringUtil::sSComp($arrayToSearch[$i]->$attributeToMatch, $valueToMatch)) {
                return $arrayToSearch[$i];
            }
        }
        return null;
    }
    
    /**
     * matchValueInObjectArrayIndex
     *
     * Same as matchValueInObjectArray but returns the index value instead.   
     * 
     * @param string $valueToMatch The value you are trying to match within the object attribute
     * 
     * @param string $attributeToMatch The attribute name you want to check the value of
     * 
     * @param array $arrayToSearch The array of objects you are trying to match
     *
     * @return object Returns the index of the object, or -1 if no match
     */
    public static function matchValueInObjectArrayIndex(string $valueToMatch, string $attributeToMatch, array $arrayToSearch): int|bool
    {
        for($i = 0; $i < count($arrayToSearch); $i++) {
            if(!isset($arrayToSearch[$i]->$attributeToMatch)) {
                continue;
            }
            if(StringUtil::sSComp($arrayToSearch[$i]->$attributeToMatch, $valueToMatch)) {
                return $i;
            }
        }
        return false;
    }
    
    /**
     * matchValueInObjectArrayClosure
     *
     * Searches and returns an object from within an array using an anonymous function.
     * 
     * @param string $matchCriteria An anonymous function that takes a comparable object returns bool value.  True if a record matches.
     * 
     * @param array $arrayToSearch The array of objects you are trying to match
     *
     * @return object Returns the object if matched, or null if no match is found
     */
    public static function matchValueInObjectArrayClosure(Closure $matchCriteria, array $arrayToSearch): ?object
    {
        for($i = 0; $i < count($arrayToSearch); $i++) {
            if($matchCriteria($arrayToSearch[$i])) {
                return $arrayToSearch[$i];
            }
        }
        return null;
    }

    /**
     * mapValueInObjectArray
     *
     * Wraps matchValueInObjectArray to provide a specific mapped output value from search criteria and array of objects.
     * 
     * @param string $valueToMatch The value you are trying to match within the object attribute
     * 
     * @param string $attributeToMatch The attribute name you want to check the value of
     * 
     * @param string $attributeToReturn The attribute name you want to return from the matched object
     * 
     * @param array $arrayToSearch The array of objects you are trying to match
     *
     * @return string Returns the mapped value if a match is found, otherwise returns the input value unchanged
     */
    public static function mapValueInObjectArray(string $valueToMatch, string $attributeToMatch, string $attributeToReturn, array $arrayToSearch): string
    {
        $matchedObject = self::matchValueInObjectArray($valueToMatch, $attributeToMatch, $arrayToSearch);
        if(!$matchedObject || !isset($matchedObject->$attributeToReturn)) {
            return $valueToMatch;
        }
        return $matchedObject->$attributeToReturn;
    }
}
