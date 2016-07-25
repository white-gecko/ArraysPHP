<?php
namespace WhiteGecko\Arrays;

/**
 * This method is from https://secure.php.net/manual/en/function.array-diff.php#91756
 * by firegun at terra dot com dot br
 */
function arrayRecursiveEqual($aArray1, $aArray2)
{
    if (hasStringKeys($aArray1) != hasStringKeys($aArray2)) {
        return false;
    } elseif (hasStringKeys($aArray1)) {
        foreach ($aArray1 as $mKey => $mValue) {
            if (array_key_exists($mKey, $aArray2)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = arrayRecursiveEqual($mValue, $aArray2[$mKey]);
                    if (!$aRecursiveDiff) {
                        return false;
                    }
                } else {
                    if ($mValue != $aArray2[$mKey]) {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
    } else {
        foreach ($aArray1 as $mKey => $mValue) {
            if (!is_array($mValue)) {
                $pos = array_search($mValue, $aArray2);
                if (false === $pos) {
                    return false;
                }
                unset($aArray1[$mKey]);
                unset($aArray2[$pos]);
            }
        }
        foreach ($aArray1 as $mKey => $mValue) {
            if (is_array($mValue)) {
                $found = false;
                foreach ($aArray2 as $pos => $otherValue) {
                    if (is_array($otherValue)) {
                        $aRecursiveDiff = arrayRecursiveEqual($mValue, $otherValue);
                        if ($aRecursiveDiff) {
                            $found = true;
                            break;
                        }
                    }
                }
                if (!$found) {
                    return false;
                }
                unset($aArray1[$mKey]);
                unset($aArray2[$pos]);
            }
        }
        if (!empty($aArray1) && !empty($aArray2)) {
            return false;
        }
    }

    return true;
}

/**
 * This is ment to determine between the list of objects and the other hierarchical array structure
 * objects list, vs subject, predicate and structure in the object
 * This method is from http://stackoverflow.com/a/173479/414075 initially by Mark Amery
 */
function isAssoc(array $arr)
{
    return array_keys($arr) !== range(0, count($arr) - 1);
}

/**
 * This is another option to determine between the list of objects and the other hierarchical array structure
 * objects list, vs subject, predicate and structure in the object
 * This method is from http://stackoverflow.com/a/4254008/414075 initially by Captain kurO
 */
function hasStringKeys(array $array)
{
    return count(array_filter(array_keys($array), 'is_string')) > 0;
}
