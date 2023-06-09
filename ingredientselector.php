<!DOCTYPE html>
<html>
<head>
    <title>Ingredient Selector</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  
	   <style>
        /* Style the ingredient selector and sub-boxes */
        #ingredient-selector {
            border: 1px solid black;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
			
        }

        .category-box {
            border: 1px solid gray;
            padding: 5px;
            margin: 5px;
        }

        .ingredient-box {
            border: 1px solid gray;
            padding: 5px;
            margin: 5px;
        }

    </style>
</head>
<body>
    <?php
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "RecipeDB";
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query the database for all ingredients
        $sql = "SELECT Ingredient, FoodGroup FROM Ingredients";
        $result = $conn->query($sql);

        // Create an array of categories and their ingredients
        $categories = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $category = $row["FoodGroup"];
                $ingredient = $row["Ingredient"];
                if (!array_key_exists($category, $categories)) {
                    $categories[$category] = array();
                }
                array_push($categories[$category], $ingredient);
            }
        }
		
        // Display the ingredient selector with sub-boxes for each category
		echo "<form method='POST'>";
        echo "<div id='ingredient-selector' class='box has-background-warning'>";
        foreach ($categories as $category => $ingredients) {
            echo "<div class='category-box'>";
            echo "<h3 class='subtitle is-3'>$category</h3>";
            foreach ($ingredients as $ingredient) {
                echo "<div class='ingredient-box has-background-warning'>";
                echo "<label class='checkbox'>";
                echo "<input type='checkbox' name='ingredient[]' value='$ingredient'>";
                echo $ingredient;
                echo "</label>";
                echo "</div>";
            }
            echo "</div>";
        }
		echo "<button type='submit' class='button is-danger' name='addToFridge' value='true'>Add To Fridge</button>";
		echo "<button type='submit' class='button is-primary' name='searchRecipes' value='true'>Search Recipes</button>";
		echo "</div>";
		echo "</form>";

		 // Handle form submission
		 if ($_SERVER["REQUEST_METHOD"] == "POST") {

			 // Check if ADD TO FRIDGE  button was clicked
			 if (isset($_POST["addToFridge"])) {
			// Check if the ingredient array is set
          	if(isset($_POST["ingredient"])){
			$selectedIngredients = $_POST["ingredient"];
			
			foreach($selectedIngredients as $ingredient){
				echo"<h1>$ingredient</h1>";
				//insert into user/fridge table here
				//$sql = "INSERT INTO UserFridge (Ingredient) VALUES ('$ingredient')";
			 }}}
			
			 //chechk if SEARCH RECIPES button clicked
			if (isset($_POST["searchRecipes"])) {
			// Check if the ingredient array is set
		  if(isset($_POST["ingredient"])){
			$selectedIngredients = $_POST["ingredient"];
			foreach($selectedIngredients as $ingredient){
				echo"<h1>$ingredient</h1>";
			//make sql temp table here
		}
		  }
			
		}}
        // Close the database connection
        $conn->close();
    ?>
</body>
</html>
