(function ($) {

$(document).ready(function() {

	var qs = getUrlVars();

	if(qs["timestamp"]) {

        var timestamp = parseInt(qs["timestamp"].split("#")[0]) * 1000;

        var date = new Date(timestamp);

        var dateStr = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2);

        document.querySelector("#full_calendar_datepicker").value = dateStr;

	}

});

})( jQuery );

function datepicker_change(e) {

	var timestamp = e.srcElement.valueAsNumber.toString().substr(0,10);
	document.location.href = "?timestamp=" + timestamp + "#cliff-full-calendar";

}

function getUrlVars() {

    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

    for(var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }

    return vars;
}