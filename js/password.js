function validate () {
	
	var pass1=document.forms["pass"]["password"].value;
	var pass2=document.forms["pass"]["password1"].value;

if(pass1==pass2)
	return true;
else
	return false;


}