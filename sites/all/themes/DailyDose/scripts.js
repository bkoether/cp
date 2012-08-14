// adding to the onload event
if (Drupal.jsEnabled) {
	$(document).ready(function(){
	
	//signup field
	 s = $('#email');
	 
	 s.focus(function(){
	 	if(s.val() == "Enter your email…"){
	 		s.val("");
	 	}
	 });
	 
	 s.blur(function(){
	 	if(s.val() == ""){
	 		s.val("Enter your email…");
	 	}
	 });

});
}	