<?php
        // Create connection to the database
       
        $link = mysqli_init(); 
                        
        mysqli_real_connect_caesar($link);

        if (mysqli_connect_errno()) {
                $result = mysqli_connect_error();
                $result = json_encode($result);
                echo $result;
                exit;
        }

        mysqli_set_charset($link,"utf8");

// SWITCH -----------------------------------------------------------------------------
        $request_method = $_SERVER["REQUEST_METHOD"];
        switch ($request_method) {
                case 'GET':
                        // IN CASE OF GET

                        // Give back the current state of the game
                        // These are: 
                        //              No match with given id
                        //              No opponent
                        //              Opponent is waiting to join
                        //              Your turn (Send back the table)
                        //              Opponents turn
                        //              Opponent won
                        //              You won
                        //              Drawn
                        //              Invalid properties
                        //              You don't have permisson to this match


                        // To perform this request the sender
                        // must send the device name, and an gameid for the game

                        break;
                
                case 'POST':
                        // IN CASE OF POST

                        // The POST request stands for making a move
                        // To perform it, the sender must send a name, a gameid
                        // and a move.

                        // The answear could be:
                        //              OK (sending back tha table)
                        //              Not your turn
                        //              You can't place there
                        //              The game is over
                        //              The game does not exist
                        //              Invalid properties
                        //              You don't have permission to this match
                        break;

                case 'DELETE':
                        // Generates a gameid that not exist
                        break;

                case 'PUT':
                        // IN CASE OF PUT

                        // This method stands for making a new game, or joing to one.
                        // Required a name and a game id

                        // Possinle answears:
                        //              Full
                        //              Joined 
                        //              Created


                        $putdata = fopen("php://input", "r");
                        $data = "";
                        while ($Sdata = fread($putdata, 1024)){
                                $data .= $Sdata;
                                // echo $Sdata . "\n";
                        }
                        fclose($putdata);

                        $data = json_decode($data, true);

                        // Check for name
                        if (!isset($data["name"])) {
                            $response .= "You must send name.\n";
                            echo $response;
                            break;
                        }

                        // check for gameid
                        if (!isset($data["gameid"])) {
                            $response .= "You must send gameid.\n";
                            echo $response;
                            break;
                        }

                        $gameid = $data["gameid"];
                        $name = $data["name"];

                        $sql = "SELECT player1, player2, state FROM tictactoe WHERE gameid = {$gameid};";
                        
                        $result = mysqli_query($link, $sql);
                        $result  = mysqli_fetch_assoc($result);

                        
                        if ($result == null) {
                            // Creat session
                            $sql = "INSERT INTO tictactoe (gameid, player1) VALUES ('{$gameid}', '{$name}');";
                            // var_dump($sql);
                            $result = mysqli_query($link, $sql);
                            echo json_encode("Created");
                        
                        } elseif (($result["player1"] != "") and ($result["player2"] != "")) {
                            // SEssion is full
                            echo json_encode("Full");
        
                        } elseif (($result["player1"] != $name) and ($result["player2"] == "")) {
                            // Jon into session
                            
                            include_once 'libs/randomStarter.php';
                            $starter = randomStarter();

                            include_once 'libs/getEmptyMap.php';
                            $table = getEmptyMap(3,3);

                            if (is_numeric($table)) {
                                echo "Hiba történt a pálya létrehozása közben";
                                $starter = "Error";
                            }

                            $sql = "UPDATE tictactoe SET player2 = '{$name}', state = '{$starter}', table = '{$table}' WHERE gameid = '{$gameid}'";
                            mysqli_query($link, $sql);
                            echo json_encode("Joined");
                        
                        } elseif (($result["player1"] == $name) and ($result["player2"] == "")) {
                            echo json_encode("Already exist");
                        
                        } else {
                            echo json_encode("Something is wrong. Please contact me: martin77szabo@gmail.com");
                        }

                        break;
                        
        }
    mysqli_close($link);
?>
