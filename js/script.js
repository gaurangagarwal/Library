var predications = document.getElementById("predictions");
var pointsTo = -1; // currently pointing to which predictions

$("#input").keydown(function(e) {
	var value = document.getElementById("input").value; // it has only last character
	var keyCode = e.keyCode; // new character added to input fiedl
	if(keyCode >= 48 && keyCode <=57) { // if a number 
		value += keyCode;
	} else if(keyCode >= 65 && keyCode<=90 ) { //  a character
		value = value + String.fromCharCode(keyCode + 32);    		
	}  else if(keyCode == 38 || keyCode == 40){ // up and down arrow
		moveInPredictions(keyCode);
		return;			
	} else if(keyCode==8) { // backspace key poressed
		pointsTo = -1;
	} else if(keyCode == 13){ /// enter key is pressed	
		if(pointsTo == -1) {   // user has not selected any prediction
			if(predictions.childNodes.length == 1) {  // only one prediction
				var location = predictions.childNodes[0].childNodes[0].href;	
				window.location.assign(location);					
			} else {  // more than one prediction or no prediction
				alert("Please select a valid name");
			}
		} else { // user has selected a predition
			var location = predictions.childNodes[pointsTo].childNodes[0].href;	
			window.location.assign(location);
		}
	}  else { // any other key is pressed 
		return;
	}
	var data = {
		value : value
	};
	console.log(data);    	
	$.ajax({ // finding the predictions from input from user
         url: 'ajax/find.php',  
         type:'POST', 
         data:data,
  	}).success(function(data) {
  		var predictions = $.parseJSON(data);
  		// console.log(predictions.length);
  		writePredictions(predictions);	
  	}).fail(function(data){

  	});
});



function moveInPredictions(keyCode) { // use up,down arrow keys to move  between predictions 
	var moveTo  = pointsTo + (keyCode -39); // down arrow => 1 and upArrow=> -1
	
	var len = predictions.childNodes.length;
	for (var i = 0; i < len; i++) {
		predictions.childNodes[i].style.backgroundColor = "#677077";			
	}
	moveTo = moveTo%len;
	if(moveTo >= 0) {
		predictions.childNodes[moveTo].style.backgroundColor = "#f2b632";
		pointsTo = moveTo;
	}		
}

// factor of two has been added because we first get name of person and then it code
function writePredictions(str) { // attaching predictions to the HTML input field
	while(predictions.childNodes.length >0) {// removing old predictions
		predictions.removeChild(predictions.childNodes[0]);
	}

	var len = 20;
	if(str.length/2 < 20) // reducing number of predictions to 10
		len = str.length;  // string has both code and name of a person so array becomes double of size
	for(var i =0; i < len; i+=2) {
		var liNode = document.createElement("li");
		var aNode = document.createElement("a");
		aNode.href = "check_in.php?code="+str[i+1]; // i+1 means code of person
		var predictionStr = str[i] + " - " + str[i+1];
		aNode.innerHTML = predictionStr;	 // name -  code
		liNode.appendChild(aNode);
		predictions.appendChild(liNode);
	}
}
function moreBtnClick() {
	var moreBtn =document.getElementById("moreBtn");
	if(moreBtn.innerHTML == "less..") {
		moreBtn.innerHTML= "more..";
	} else {
		moreBtn.innerHTML= "less..";
	}
	// var more= document.getElementById("more");
	// more.style.display = "block"; 
	$("#more").slideToggle();	
}