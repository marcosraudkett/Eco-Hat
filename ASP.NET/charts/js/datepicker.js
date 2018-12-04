( function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define( [ "../widgets/datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}( function( datepicker ) {

datepicker.regional.fi = {
	closeText: "Close",
	prevText: "&#xAB;Previous",
	nextText: "Next&#xBB;",
	currentText: "Today",
	monthNames: [ "January","February","March","April","May","June",
	"July","August","September","October","November","December" ],
	monthNamesShort: [ "Jan","Feb","Mar","Apr","May","Jun",
	"Jul","Aug","Sep","Oct","Nov","Dec" ],
	dayNamesShort: [ "Su","Mo","Tu","We","Th","Fr","Sa" ],
	dayNames: [ "Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday" ],
	dayNamesMin: [ "Su","Mo","Tu","We","Th","Fr","Sa" ],
	weekHeader: "Wk",
	dateFormat: "d.m.yy",
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: "" };
datepicker.setDefaults( datepicker.regional.fi );

return datepicker.regional.fi;

} ) );