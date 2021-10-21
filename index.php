<?php
$pokeapi = "https://pokeapi.co/api/v2/pokemon/";
$pokemonid = $_GET["id"];
if(isset($pokemonid)){
    $pokemonid = strtolower($_GET["id"]);
}else{
    $pokemonid = "1";
}
$data = file_get_contents($pokeapi.$pokemonid.'/');
$pokemon = json_decode($data);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="main.css">
    <title>Get Pokemon </title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col" id= "main1"> 
                <!-- left box -->
                <div id= "left-box">
                    <div id="picture">
                        <?php
                            echo "<img src=".$pokemon->sprites->front_default."> <br>";
                        ?>
                        <!-- insert the img -->
                    </div>
                    <div id="input-campus">
                        <h3 style="text-align: center;"> ID </h3>
                        <?php
                            echo "<h3 style='text-align: center;' id='number'>".$pokemon->id."</h3><br>";
                        ?>                  
                        <form method="get">
                            <input type= text id = id name = id> 
                            <!-- <button type = click>Click</button> -->
                        </form>                  
                        <!-- insert an output that show the id of the pokemon and a input that I use to get a pokemon by id and name-->
                    </div>
                </div>
            </div>
            <div class="col" id="main2">
                <!-- right box -->
                <div id= "right-box">
                    <div id= "pokemon-name">
                        <?php
                            echo "<h1>".$pokemon->name."</h1><br>";
                        ?>
                        <!-- here I show the name of the pokemon -->
                    </div>
                    <div id= "pokemon-type">
                        <h2 class = 'title-types'> Type of Pokémon </h2>
                        <?php
                            $types = $pokemon->types;
                            $typesLength = count($types,1);
                            // echo $typesLength."<br>";
                            $typesArray = [];
                            for($i = 0; $i < $typesLength; $i++){
                                $element = $types[$i]->type->name;
                                array_push($typesArray, $element);
                                // print_r($typesArray);
                                echo "<img class = 'types' id = ''" .$element. "' src= 'img/".$element. ".png'>";
                                // echo "<li>".$types[$i]->type->name. "</li> <br>";                        
                            }
                        ?>
                    </div>
                    <div id= "pokemon-powers">
                        <h2 class='title'> Pokemon's power </h2>
                        <?php
                            for($i = 0; $i < count($pokemon->abilities); $i++){
                                echo "<li>".$pokemon->abilities[$i]->ability->name."</li>";
                            }
                        ?>
                        <!-- show the powers in a list -->
                    </div>
                    <div id= "movement">
                        <h2 class='title'> Pokemon's moves </h2>
                        <?php
                            $moves = $pokemon->moves;
                            $movesLength = count($moves,1);
                            // echo $movesLength."<br>";
                            if($movesLength < 4){
                                for($i = 0; $i < $movesLength; $i++){    
                                    echo "<li>".$moves[$i]->move->name. "</li>";
                                }
                            }if($movesLength > 4){
                                for($i = 0; $i < 4; $i++){    
                                    echo "<li>".$moves[$i]->move->name. "</li>";
                                }
                            }
                        ?>
                        <!-- show a list of movies in which the pokemon is -->
                     </div>
                    <div id= "evolution">
                        <h2 class = 'title-types'> Evolutions </h2>
                            <?php
                                $pokeapiEvolution = "https://pokeapi.co/api/v2/pokemon-species/";
                                $dataEvolution = file_get_contents($pokeapiEvolution.$pokemonid.'/');
                                $pokemonChain = json_decode($dataEvolution);
                                $url = $pokemonChain -> evolution_chain -> url;
                                // echo $url. "<br>";
                                
                                $urlEvolution = file_get_contents($url);
                                $dataEvolution = json_decode($urlEvolution);
                                
                                $evolutions = $dataEvolution->chain->evolves_to;
                                $evolutionsLength = count($evolutions);
                                // echo $evolutionsLength."<br>";
                                $evolutionsArray=[];
                                
                                
                                if($dataEvolution->chain){
                                    // echo $dataEvolution->chain->species->name."<br>";
                                    array_push($evolutionsArray,$dataEvolution->chain->species->name);
                                    // print_r($evolutionsArray);
                                }
                                if($dataEvolution->chain->evolves_to > 0){
                                    for($i = 0; $i < $evolutionsLength; $i++){
                                        // echo $dataEvolution->chain->evolves_to[$i]->species->name."<br>";
                                        array_push($evolutionsArray,$dataEvolution->chain->evolves_to[$i]->species->name);                                        
                                    }    
                                }
                                for($i = 0; $i < $evolutionsLength; $i++){
                                    if(count($dataEvolution->chain->evolves_to[0]->evolves_to) > 0){
                                        // echo $dataEvolution->chain->evolves_to[0]->evolves_to[$i]->species->name. "<br>";
                                        array_push($evolutionsArray,$dataEvolution->chain->evolves_to[0]->evolves_to[$i]->species->name);       
                                    }
                                }
                                // print_r($evolutionsArray);

                                for($i=0; $i < count($evolutionsArray); $i++){
                                    $pokemonimage = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$evolutionsArray[$i].'/');  
                                    // var_dump($pokemonimage);                             
                                    $images = json_decode($pokemonimage);
                                    // var_dump($images->sprites->front_default);
                                    echo "<img src=".$images->sprites->front_default. ">";
                                }
                            ?>
                        <!-- here I have 3 buttons that are images of the pokemon's evolution -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id = row2>

        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
