var loDash = require('lodash');

//const dictionary = ['lack', 'hack', 'lick', 'sick', 'sock', 'mock'];
const dictionary = ["hot","dot","dog","lot","log"];
let wordStart = 'hot';
let wordEnd = 'dog';

let matchStart = matchEnd = position = 0;
let dictionaryNew = [];

loDash.each(dictionary, (val, key) => {
	if (matchStart == val)
	{
		position = key;
		matchStart = 1;
	}
	if (val == wordEnd)
	{
		matchEnd = key;
	}
});

if (matchEnd == 0)
{
	dictionary.push(wordEnd);
	matchEnd = loDash.size(dictionary) - 1;
}

// based on the wordEnd get all the values up until the wordEnd so we ignore the rest of the array
for (let xI = 0; xI <= matchEnd; xI++)
{
	dictionaryNew.push(dictionary[xI]);
}
let newDict = dictionaryNew;
if (matchStart == 0)
{
	newDict = loDash.unionBy([wordStart], dictionaryNew);
}

function matchWord(word_1, word_2) {

	let totalWords = word_1.length;

	let mismatch = 0;

	for (let xI = 0; xI < totalWords; xI++)
	{
		if (word_1[xI] != word_2[xI])
		{
			mismatch++;
		}
	}	
	if (mismatch == 1)
	{
		return true;
	}
	else
	{
		return false;
	}

}

let newArr = [];

let xArr = fetchMoreLinks(0, newDict, wordStart, [wordStart]);
if (loDash.size(xArr) > 0)
{
	newArr = xArr.slice(0);
}
// loop through the array to find the similar matches
function fetchMoreLinks(st, arr, word, newsArr) {
	let xTotal = loDash.size(arr);
	let xI = 0;
	let fArr = [];
	let tmpArr = newsArr.slice(0);
	let finalArr = [];

	for(xI = st; xI < xTotal; xI++) {
		fArr = tmpArr.slice(0);
		if ((xI+1) < xTotal)
		{
			if (matchWord(word, arr[xI + 1]))
			{
				fArr.push(arr[xI+1]);
				finalArr.push(fArr);
				let position = xI + 1;
				let xArr = fetchMoreLinks(position, arr, arr[xI+1], finalArr[loDash.size(finalArr) - 1]);
				
				if (loDash.size(xArr) > 0) {
					finalArr.push(xArr[loDash.size(xArr) - 1]);
				}
			}
		}
	}
	return finalArr;
}
var loop = 0;
// go through the final array and calculate the length of the individual array
function findshortestLen(arr, start, end)
{
	let len = 0;
	if (loDash.size(arr) > 0) {
		loDash.each(arr, (val, key) => {
			if (loDash.size(val) > 0) {
				if ((val[0] == start) && (val[loDash.size(val) - 1] == end)) {
					len = loDash.size(val);
				}
			}
		});
	}
	if (len > 0)
	{
		return len;
	}
}
lenCalc = findshortestLen(newArr, wordStart, wordEnd);

console.log("Shortest Path >> ", lenCalc);