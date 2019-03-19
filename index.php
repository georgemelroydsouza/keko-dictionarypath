<?php
/**
 * Function to find the shortest path given a dictionary of words and start and end.
 */

$dictionary = array('lack', 'hack', 'lick', 'sick', 'sock', 'mock');
$dictionary = array('moan', 'loan', 'same', 'worn', 'shon', 'born');

$start = "CAT";
$end  = "BUT";

$start = 'dorn';
$end = 'worn';

$matchStart = 0;
$matchEnd = 0;
$position = 0;
foreach ($dictionary as $key => $Val)
{
	if ($start == $Val)
	{
		$position = $key;
		$matchStart = 1;
	}
	if ($Val == $end)
	{
		$matchEnd = $key;
	}
}

for ($xI = 0; $xI <= $matchEnd; $xI++)
{
	$dictionarynew[] = $dictionary[$xI];
}
$newDict = $dictionarynew;
if ($matchStart == 0)
{
	$newDict = array_merge(array($start), $dictionarynew);
}

function match_word($word1, $word2)
{
	$total = strlen($word1);
	$mismatch = 0;
	for ($xI = 0; $xI < $total; $xI++)
	{
		if ($word1[$xI] != $word2[$xI])
		{
			$mismatch++;
		}
	}
	if ($mismatch == 1)
	{
		return true;
	}
	else {
		return false;
	}
}

$newArr = array();
$xArr = fetchmorelinks(0, $newDict, $start, array($start));
if (is_array($xArr))
{
	$newArr[] = $xArr;
}


function fetchmorelinks($st, $arr, $word, $newArr)
{
	$xTotal = sizeof($arr);
	$xI=0;
	$fArr = array();
	$tmpArr = $newArr;
	$finalArr = array();
	for ($xI = $st; $xI < $xTotal; $xI++)
	{	
		$tmp = sizeof($fArr);	
		$fArr = $tmpArr;
		if (($xI + 1) < $xTotal)
		{
			if (match_word($word, $arr[$xI+1]))
			{
				array_push($fArr, $arr[$xI+1]);
				array_push($finalArr, $fArr);
				$position = $xI + 1;
				$xArr = fetchmorelinks($position, $arr, $arr[$xI+1], $finalArr[sizeof($finalArr) - 1]);
				if (is_array($xArr))
				{
					if (sizeof($xArr) > 0)
					{
						$finalArr[sizeof($finalArr)] = $xArr;
					}
				}
			}
		}
	}
		
	return $finalArr;
}

function findshortestLen($arr, $start, $end)
{
	$len = 0;
	foreach ($arr as $Val)
	{
		if (is_array($Val))
		{
			if (sizeof($Val) > 0)
			{
				if (($Val[0] == $start) && ($Val[sizeof($Val) - 1] == $end))
				{
					$len = sizeof($Val);
				}
				else
				{
					$len = findshortestLen($Val, $start, $end);
					if ($len > 0)
					{
						return $len;
					}
				}
			}
		}
	}
	if ($len > 0)
	{
		return $len;
	}
}
$lenCalc = findshortestLen($newArr, $start, $end);

echo "Shortest Path >> " . $lenCalc;

?>