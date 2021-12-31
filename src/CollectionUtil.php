<?php

declare(strict_types=1);

namespace ToddMinerTech\LaravelUtils;

use Illuminate\Support\Collection;
use ToddMinerTech\DataUtils\StringUtil;

/**
 * Class CollectionUtil
 *
 * Various collection editing, search, and comparison functions
 *
 * @package ToddMinerTech\MinerTechLaravelUtils
 */
class CollectionUtil
{
    /**
     * addCollectionIfNew
     *
     * Inserts a value into an collection only if it doesn't exist yet
     * 
     * @param string $inputStr New value to insert into collection
     * 
     * @param ByRef Collection $inputCollection Collection to search
     *
     * @return bool Returns true if the new item was inserted, false if not
     */
    public static function addCollectionIfNew(string $newValue, Collection &$inputCollection): bool
    {
        if(!$inputCollection->contains($newValue)) {
            $inputCollection->push($newValue);
            return true;
        }
        return false;
    }
    
    /**
     * matchValueInObjectCollection
     *
     * Searches and returns an object from within an collection using defined criteria.
     * 
     * @param string $valueToMatch The value you are trying to match within the object attribute
     * 
     * @param string $attributeToMatch The attribute name you want to check the value of
     * 
     * @param collection $collectionToSearch The collection of objects you are trying to match
     *
     * @return object Returns the object if matched, or null if no match is found
     */
    public static function matchValueInObjectCollection(string $valueToMatch, string $attributeToMatch, Collection $collectionToSearch): ?object
    {
        for($i = 0; $i < count($collectionToSearch); $i++) {
            if(!isset($collectionToSearch[$i]->$attributeToMatch)) {
                continue;
            }
            if(StringUtil::sSComp($collectionToSearch[$i]->$attributeToMatch, $valueToMatch)) {
                return $collectionToSearch[$i];
            }
        }
        return null;
    }
    
    /**
     * matchValueInObjectCollectionIndex
     *
     * Same as matchValueInObjectCollection but returns the index value instead.   
     * 
     * @param string $valueToMatch The value you are trying to match within the object attribute
     * 
     * @param string $attributeToMatch The attribute name you want to check the value of
     * 
     * @param collection $collectionToSearch The collection of objects you are trying to match
     *
     * @return object Returns the index of the object, or -1 if no match
     */
    public static function matchValueInObjectCollectionIndex(string $valueToMatch, string $attributeToMatch, Collection $collectionToSearch): int|bool
    {
        for($i = 0; $i < count($collectionToSearch); $i++) {
            if(!isset($collectionToSearch[$i]->$attributeToMatch)) {
                continue;
            }
            if(StringUtil::sSComp($collectionToSearch[$i]->$attributeToMatch, $valueToMatch)) {
                return $i;
            }
        }
        return false;
    }
    
    /**
     * matchValueInObjectCollectionClosure
     *
     * Searches and returns an object from within an collection using an anonymous function.
     * 
     * @param string $matchCriteria An anonymous function that takes a comparable object returns bool value.  True if a record matches.
     * 
     * @param collection $collectionToSearch The collection of objects you are trying to match
     *
     * @return object Returns the object if matched, or null if no match is found
     */
    public static function matchValueInObjectCollectionClosure(Closure $matchCriteria, Collection $collectionToSearch): ?object
    {
        for($i = 0; $i < count($collectionToSearch); $i++) {
            if($matchCriteria($collectionToSearch[$i])) {
                return $collectionToSearch[$i];
            }
        }
        return null;
    }

    /**
     * mapValueInObjectCollection
     *
     * Wraps matchValueInObjectCollection to provide a specific mapped output value from search criteria and collection of objects.
     * 
     * @param string $valueToMatch The value you are trying to match within the object attribute
     * 
     * @param string $attributeToMatch The attribute name you want to check the value of
     * 
     * @param string $attributeToReturn The attribute name you want to return from the matched object
     * 
     * @param collection $collectionToSearch The collection of objects you are trying to match
     *
     * @return string Returns the mapped value if a match is found, otherwise returns the input value unchanged
     */
    public static function mapValueInObjectCollection(string $valueToMatch, string $attributeToMatch, string $attributeToReturn, Collection $collectionToSearch): string
    {
        $matchedObject = self::matchValueInObjectCollection($valueToMatch, $attributeToMatch, $collectionToSearch);
        if(!$matchedObject || !isset($matchedObject->$attributeToReturn)) {
            return $valueToMatch;
        }
        return $matchedObject->$attributeToReturn;
    }
}
