<?php
    include 'connect.php';
    function insertInto($table, ...$sqlParams)
    {
        $comma = "";
        $query = "INSERT INTO ".$table."(";

        foreach ($sqlParams as $param) {
            $query .= $comma.$param[0];
            $comma = ", ";
        }

        $query .= ") values (";
        $comma = "";
        $x = 0;

        foreach ($sqlParams as $param) {
            $query .= $comma.":param".$x;
            $comma = ", ";
            $x++;
        }
        $query .= ")";

        $statement = $db->prepare($query);
        $x = 0;

        foreach ($sqlParams as $param) {
            $statement->bindValue(':param'.$x, $param[1]);
            $x++;
        }
        $statement->execute();
        header('Location: ../index.php');
    }

    function selectFrom($query, ...$sqlParams)
    {
        include 'connect.php';
        $values = $db->prepare($query);
        
        if(count($sqlParams) > 0)
        {
            $x = 0;
            foreach ($sqlParams as $param) {
                $values->bindValue(":param".$x, $param[0]);
                $x++;
            }
        }

        $values->execute();
        $result = $values->fetch();

        return $result;
    }
?>