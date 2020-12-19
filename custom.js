        setInterval(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var x = document.getElementById('namerepace').innerHTML;

            if (urlParams != '') {
                document.getElementById('namerepace').innerHTML = urlParams.get('title') + " ";
            } else {

            }
        }, 1000);
        // Set the date we're counting down to
        var countDownDate = new Date("Jan 5, 2021 15:37:25").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds

            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (seconds < 10) {
                seconds = "0" + seconds;
            }
            if (hours < 10) {
                hours = "0" + hours;
            }
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            document.getElementById("demo").innerHTML = hours + " " +
                minutes + " " + seconds + " ";

            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);


        document.getElementById('div3').style.display = "none";
        document.getElementById('div2').style.display = "none";

        /*function showOrhide() {
            if (document.getElementById("firstBtn")) {

                document.getElementById('div1').style.display = "none";
                document.getElementById('div2').style.display = "block";
                return false;
            }
        }*/
		function showOrhide(){
			var hospitalized = document.getElementById("hospitalized").value;
			var attorney = document.getElementById("attorney").value;
			var temp = 0;
			if(hospitalized == ""){
				document.getElementById("hospitalized").style.border = "1px solid #ff0000";
				temp++;
			}else{
				document.getElementById("hospitalized").style.border = "1px solid";
			}
			if(attorney == ""){
				document.getElementById("attorney").style.border = "1px solid #ff0000";
				temp++;
			}else{
				document.getElementById("attorney").style.border = "1px solid";
			}
			if(temp == 0){
				if(document.getElementById("firstBtn")){
					document.getElementById('div1').style.display="none";
					document.getElementById('div2').style.display="block";
					return false;
				}
			}else{
				return false;
			}
		}
        /*function showOrhide1() {
            document.getElementById('div3').style.display = "none";
            document.getElementById('div1').style.display = "none";
            if (document.getElementById("secondbtn")) {

                document.getElementById('div2').style.display = "none";
                document.getElementById('div3').style.display = "block";
                return false;
            }
        }*/
		function showOrhide1(){
			var yes_no = document.getElementById("yes_no").value;
			var temp = 0;
			if(yes_no == ""){
				document.getElementById("yes_no").style.border = "1px solid #ff0000";
				temp++;
			}else{
				document.getElementById("yes_no").style.border = "1px solid";
			}
			if(temp == 0){
				document.getElementById('div3').style.display="none";
				document.getElementById('div1').style.display="none";
				if(document.getElementById("secondbtn")){
					document.getElementById('div2').style.display="none";
					document.getElementById('div3').style.display="block";
					return false;
				}
			}else{
				return false;
			}
		}
		function checkdata(){
		var name = document.getElementById("name").value;
		var lname = document.getElementById("lname").value;
		var state = document.getElementById("state").value;
		var zipcode = document.getElementById("zipcode").value;
		var phone = document.getElementById("phone").value;
		var email = document.getElementById("email").value;
		var description = document.getElementById("description").value;
		var temp = 0;
		if(name == ""){
			document.getElementById("name").style.border = "1px solid #ff0000";
			temp++;
		}else{
			document.getElementById("name").style.border = "1px solid";
		}
		if(lname == ""){
			document.getElementById("lname").style.border = "1px solid #ff0000";
			temp++;
		}else{
			document.getElementById("lname").style.border = "1px solid";
		}
		if(state == ""){
			document.getElementById("state").style.border = "1px solid #ff0000";
			temp++;
		}else{
			document.getElementById("state").style.border = "1px solid";
		}
		if(zipcode == ""){
			document.getElementById("zipcode").style.border = "1px solid #ff0000";
			temp++;
		}else{
			document.getElementById("zipcode").style.border = "1px solid";
		}
		if(phone == ""){
			document.getElementById("phone").style.border = "1px solid #ff0000";
			temp++;
		}else{
			document.getElementById("phone").style.border = "1px solid";
		}
		if(email == ""){
			document.getElementById("email").style.border = "1px solid #ff0000";
			temp++;
		}else{
			document.getElementById("email").style.border = "1px solid";
		}
		if(description == ""){
			document.getElementById("description").style.border = "1px solid #ff0000";
			temp++;
		}else{
			document.getElementById("description").style.border = "1px solid";
		}
		if(temp == 0){
			return true;
		}else{
			return false;
		}
		}
   		document.getElementById("firstBtn").onclick = showOrhide;
   		document.getElementById("secondbtn").onclick = showOrhide1;