<!DOCTYPE html>
<?php global $rarr,$found,$conn,$query,$sql,$result,$qarr,$j,$i,$newquery,$newreply; ?>
<html>
	<head>
		<title>Simplest Chat Bot</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" />
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
  <style>
		body,html{
			margin: 0;
			background: #7F7FD5;
			background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
			background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
		}
		.card{
			height: 500px;
			border-radius: 15px !important;
			background-color: rgba(0,0,0,0.4) !important;
			margin-top: 40px;
			margin-bottom: 50px;
		}
		.type_msg{
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color:white !important;
			height: 65px !important;
			overflow-y: auto;
		}
		.send_btn{
			border-radius: 0 15px 15px 0 !important;
			background-color: rgba(0,0,0,0.3) !important;
			border:0 !important;
			color: white !important;
			cursor: pointer;
		}
		.msg_cotainer{
			margin-top: auto;
			margin-bottom: auto;
			margin-left: 10px;
			border-radius: 25px;
			background-color: #82ccdd;
			padding: 10px;
			position: relative;
			min-width: 120px;
			min-height: 40px;
			max-width: 60%;
		}
		.notif {
			padding: 20px;
			color: white;
			opacity: 1;
			transition: opacity 0.35s;
			margin-bottom: 20px;
			border-radius: 6px;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			background-color: #4CAF50;
			width: 50%;
		}
		.closebtn {
			color: white;
			font-weight: bold;
			float: none;
			font-size: 22px;
			line-height: 20px;
			cursor: pointer;
			transition: 0.35;
			float: right;
		}
		.closebtn:hover {
			color: black;
		}
  </style>
	</head>

	<body>
		<center>
			<?php
      
      //your server database information here
			$server = "";
			$user = "";
			$pass = "";
			$db = "";
			
				if ($_SERVER["REQUEST_METHOD"]=="POST") {
					$conn = new mysqli($server, $user, $pass, $db);
					if (isset($_POST["send"])) {
						$query = $_POST["query"];
						$sql = "SELECT query,reply FROM mechanism";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							$qarr = array();
							$rarr = array();
							$j = 0;
								while($row = $result->fetch_assoc()) {
									$qarr[$j] = $row["query"];
									$rarr[$j] = $row["reply"];
									$j++;
									$found = false;
								}
								for ($i=0; $i < $j ; $i++) {
									if(strstr($query,$qarr[$i])!=false){
										$found = true;
										break;
									}
								}
							}
							else {
									echo "<h3 style=\"margin-top:25px;\">The Database is Completely Empty. Kindly start Trainig !!</h3>";
							}
							if(!$found) {
		            echo "<h3 style=\"margin-top:25px;\">I dont know the answer. Please tell me !</h3>";
		            echo "<form name=\"newentry\" action=\"index.php\" method=\"post\">";
		            echo "<input type=\"text\" name=\"newquery\" placeholder=\"New Query Word\" value=\"\" />";
		            echo "<input type=\"text\" name=\"newreply\" placeholder=\"New Reply..\" value=\"\" />";
		            echo "<input type=\"submit\" name=\"submit\" value=\"Submit\" /></form>";
		          }
						}
						elseif (isset($_POST["submit"])) {
			        $newquery = $_POST["newquery"];
			        $newreply = $_POST["newreply"];
			        $sql = "INSERT INTO mechanism (query,reply) VALUES ('$newquery', '$newreply')";
			        if ($conn->query($sql) === TRUE) {
			          echo "<div class=\"notif\" style=\"margin-top: 25px;\"><span class=\"closebtn\">&times;</span>";
			          echo "New Response Added <strong>Successfully !!</strong></div>";
			        }
			        else {
			            echo "Error: " . $sql . "<br>" . $conn->error;
			        }
			     	}
					}
					?>

    	<div class="col-xl-6">
    		<div class="card">
    			<div class="card-body">
    				<div class="d-flex">
    					<div class="msg_cotainer">
								<h5 id="rep"></h5>
    					</div>
    				</div>
    			</div>
					<form action="index.php" method="post" name="mechanism">
	    			<div class="card-footer">
	    				<div class="input-group">
	    					<input type="text" name="query" class="form-control type_msg" placeholder="Type your message..." autofocus />
	    					<div class="input-group-append">
	    						<button class="input-group-text send_btn" type="submit" name="send"><i class="fas fa-location-arrow"></i></button>
	    					</div>
	    				</div>
	    			</div>
					</form>
    		</div>
    	</div>


			<?php
	      if ($_SERVER["REQUEST_METHOD"]=="POST") {
	        if (isset($_POST["send"])) {
	          if ($found) {
	            echo "<script type=\"text/javascript\">\n\n";
	            echo "\nwindow.addEventListener(\"load\", myInit, true); \nfunction myInit(){\n";
	            echo "\ntypeWriter();";
	            echo "\n}\nvar txt =\"" . $rarr[$i] . "\";";
	            echo "\nvar pointer = 0;";
							echo "\nvar def=false;\n";
	          }
	       }
					$conn->close();
	     }
			if (!$found || !isset($_POST["send"])) {
			 echo "<script type=\"text/javascript\">";
			 echo "\nwindow.addEventListener(\"load\", myInit, true); \nfunction myInit(){\n";
			 echo "\ntypeWriter();";
			 echo "\n}\nvar pointer = 0;";
			 echo "\nvar def=true;\n";
			}
	   ?>

	      function typeWriter(){
					if (def && document.getElementById("rep").innerHTML==""){
						document.getElementById("rep").innerHTML = "Welcome <b>!</b> I am Bit-Assist.<br /> How may I help you...<b>?</b>";
					}
					else if(!def){
						if (pointer < txt.length) {
		          document.getElementById("rep").innerHTML += txt.charAt(pointer);
		          pointer++;
		          setTimeout(typeWriter, 55);
		        }
					}
	      }
	    </script>

		</center>
	</body>
</html>
