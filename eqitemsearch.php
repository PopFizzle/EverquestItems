<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Everquest Item Search</title>
    </head>
    <body>
    Search for the full name or wildcard.  Wildcard searches are going to be slow. <br><br>
    Example: The Sword of Ssraeshza or Black Acrylia Bastard Sword<br><br>

        <form method="post" action="eqitemsearch.php">
            Item Name: <input type="text" name="ItemName"><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php

        // Check if a post was done and if so, then connect to the database
        if ($_SERVER['REQUEST_METHOD']=="POST") {

            $dbhost = 'localhost:3036';
            $dbuser = 'eqweb';
            $dbpass = '';
            $conn = mysql_connect($dbhost, $dbuser, $dbpass);

            if(! $conn ) {
                    die('Could not connect: ' . mysql_error());
                    echo 'error connecting to db';
            }

            //echo 'Connected successfully';
            mysql_select_db('everquest');

           // retrieve what you submitted and output to the screen
           $retrieveitem=$_POST["ItemName"];

           echo 'Looking for '.$retrieveitem;
           
           //$sql="SELECT Name FROM items WHERE name LIKE '%".$retrieveitem."%'";
           $sql="SELECT
                    i.ID,
                    i.Name,
                    i.Size,
                    i.Weight,
                    i.reqlevel as RequiredLvl,
                    i.itemtype as ItemType,
                    i.AC,
                    i.HP,
                    i.Mana,
                    i.endur as Endurance,
                    i.damage as BaseDmg,
                    i.elemdmgamt as MagicDmg,
                    i.Delay,
                    i.astr as STR,
                    i.asta as STA,
                    i.aint as 'INT',
                    i.awis as WIS,
                    i.adex as DEX,
                    i.mr  as Magic,
                    i.fr as Fire,
                    i.cr as Cold,
                    i.dr as Disease,
                    i.pr as Poison,
                    sn.name as Effect,
                    i.Lore
                 FROM items i
                 JOIN spells_new sn on i.proceffect = sn.id
                 WHERE
                    i.name LIKE '%".$retrieveitem."%'";

                   // Submit the query to the database
           $retval = mysql_query( $sql, $conn );

            if(! $retval ) {
                die('Could not get data: ' . mysql_error());
            }

            while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
            //echo $row[1]." ".$row[2]." ".$row[3]." ".$row[4]." ".$row[5];
            // each echo is a column in the select
            
            // Display the query results as an echo
            // more comments
            echo "Name: {$row['Name']} <br>".
                 "AC: {$row['AC']} / ".
                 "Size: {$row['Size']} / ",
                 "Weight: {$row['Weight']} / ",
                 "Required Lvl: {$row['RequiredLvl']} / ",
                 "Required Lvl: {$row['ItemType']} <br>",
                 "AC: {$row['AC']} /".
                 "HP: {$row['HP']} / ",
                 "Mana: {$row['Mana']} / ",
                 "Endurance: {$row['Endurance']} / ",
                 "Base Dmg: {$row['BaseDmg']} / ",
                 "Magic Dmg: {$row['MagicDmg']} / ",
                 "Delay: {$row['Delay']} <br> ",
                 "STR: {$row['STR']} / ",
                 "STA: {$row['STA']} / ",
                 "INT: {$row['INT']} / ",
                 "WIS: {$row['WIS']} / ",
                 "DEX: {$row['DEX']} <br>",
                 "Magic: {$row['Magic']} / ",
                 "Fire: {$row['Fire']} / ",
                 "Cold: {$row['Cold']} / ",
                 "Disease: {$row['Disease']} / ",
                 "Poison: {$row['Poison']} / ",
                 "Proc Effect: {$row['Effect']} / ",
                 "Lore: {$row['Lore']} <br>",
                 "--------------------------------<br>";
            }

            mysql_close($conn);

        }
        ?>

    </body>
</html>