// var booksCount = 0;  // number of books user has
// var laptop_brought = 0; // user has brought laptop or not 
function books(count, value) {
	// booksCount = count;
	// console.log("Books cont : "+ count);
	var i;
	var start=1;
	var temp=document.getElementById("container");
	
	var range=temp.childNodes.length-1;

	if(range>0) {

		var num_childs=temp.childNodes.length-value;
		console.log("Child Nodes : ");
		// for (var i = 1; i < num_childs; i++) {
		// 	console.log(temp.childNodes[i]);
		// };
		console.log("childNodes : "+num_childs);
		if(count>num_childs) {
			start=num_childs+1;
		}
		else if(count==num_childs)
		{
			start=num_childs+1;
		}
		else
		{
			start=count+1; // dont enter the loop
			
			var j;
			for(j=num_childs;j>count;j--)
			{
				var str="inp"+j;
				// selectedLi.slideUp("normal", function() { $(this).remove(); } );
				$("#"+str).slideUp("normal" , function () {
					$(this).remove();
				});
				// $("#"+str).slideUp(function () {
					// var deleted_child=document.getElementById(str);
					// console.log(deleted_child);
					// var parent=document.getElementById("container");
					// console.log(parent);
					// parent.removeChild(deleted_child);		
				// });
			}

		}

	}	

	console.log(start+ "   "+ count)
	for (  i = start; i <= count; i++) {
		// var inp1 = $("input");
		// var inp1=document.createElement("input");
		// var parent_div=document.getElementById("container");
		// parent_div.appendChild(inp1);
		// console.log('<input style="display:none;" placeholder="Book '+i+'" type="text" class="personal_books_fields" id="inp'+i+'" name="inp'+i+'" placeholder="Book '+i+'" required="true">');
		$('<input style="display: none;" placeholder="Book '+i+'" type="text" class="personal_books_fields" id="inp'+i+'" name="inp'+i+'" placeholder="Book '+i+'" required="true">')
				.appendTo($('#container')).slideToggle();

		// inp1.style.display = "none";
		// inp1.type="text";
		// inp1.name="inp"+i;
		// inp1.id="inp"+i;
		// inp1.className="personal_books_fields";
		// inp1.placeholder="Book "+i;
		// inp1.required="true";
		// $("#inp"+i).slideToggle(function (){
		// 	inp1.style.display = "block";
		// });
	}
}


function laptop_name () {
	// laptop_brought = 1;
	var laptop_brand = document.getElementById("laptop_brand");
	if(laptop_brand == null) {
		var inp1=document.createElement("input");
		inp1.style.display = "none";
		var parent_div=document.getElementById("laptop_container");
		parent_div.appendChild(inp1);
		inp1.type="text";
		inp1.name="laptop_brand";
		inp1.id="laptop_brand";
		inp1.placeholder = "Name"
		inp1.className="laptop_brand";
		inp1.required="true";
		$("#laptop_brand").slideToggle();
	} else {
		$("#laptop_brand").slideToggle(function () {
			var deleted_child=document.getElementById("laptop_brand");
			var parent=document.getElementById("laptop_container");
			parent.removeChild(deleted_child);		
		});
	}
}


var messageText = document.getElementById("messageText");
var messageImage = document.getElementById("messageImage");
var message = document.getElementById("message");

$(document).ajaxStart(function (data){
	message.style.display = "block";
	messageText.innerHTML = "Loading";
	messageImage.src ="img/loading.gif";
	// console.log(new Date().getTime());
	// console.log("Ajax Start ");
});
// $(document).ajaxStop(function (data) {
	// messageText.innerHTML = "Done";
	// messageImage.src ="img/complete.png";
	// console.log(new Date().getTime());
	// console.log("Ajax Stop ");
	// setTimeout(function () {
	// 	// document.location.href = "index.php";
	// },500);
// });


//operation is "in" or "out"
function checkBtnClick(operation){

	var laptop = document.getElementById("laptop").value;
	var notebooks = document.getElementById("notebooks").value;
	var personal_books = document.getElementById("personal_books").value;
	var code = document.getElementById("entry_num").innerHTML;
	var laptop_brand = null;
	var inp = [null, null, null, null, null];
	var laptop_brought = document.getElementById("laptop").checked;
	if(laptop_brought == true)
		laptop_brand = document.getElementById("laptop_brand").value;
	
	// var booksCount = document.getElementById("personal_books").innerHTML;
	for (var i = 1; i <=personal_books; i++) {
		var inpId = "inp"+i;
		inp[i] = document.getElementById(inpId).value;
		// console.log( i + "  " + inp[i]);		
	};
	// var laptop = document.getElementById("laptop").value;
	
	var data = {
		laptop : laptop,
		notebooks : notebooks,
		personal_books: personal_books,
		laptop_brand: laptop_brand,
		code : code,
		inp1: inp[1],
		inp2: inp[2],	
		inp3: inp[3],	
		inp4: inp[4]	
	};
	console.log(data);
	var type = "Checked In";
	var url ='ajax/check_in_storage.php'; 
	if(operation == "out") {
		type = "Checked Out";
		url ='ajax/check_out_storage.php';
	} else if(operation == "edit" ) {
		type = "Saved";
		url ='ajax/edit.php';
	}
	console.log(url);
	$.ajax({ // finding the predictions from input from user
		url: url,  
		type:'POST', 
		data:data,
	}).success(function(data) {
		messageText.innerHTML = type;
		messageImage.src ="img/complete.png";
		setTimeout(function () {
			document.location.href = "index.php";
		},500);	
	}).fail(function(data){
	
	});
}
// function onloadFunc() {
// 	$("#dialog").dialog();
// }