<?php
        // Create connection to database
       
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


                        break;
                        
        }
    mysqli_close($link);
?>
