// Timer convenience functions to show and hide elements x ms after being triggered.

function timedShowElement(elem, timeout){
	var nelem = elem.startsWith('#') ? elem : '#' + elem;
	setTimeout($(nelem).show(), timeout);
}

function timedHideElement(elem, timeout) {
	var nelem = elem.startsWith('#') ? elem : '#' + elem;
	setTimeout($(nelem).hide(), timeout);

}