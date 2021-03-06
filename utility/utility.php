<?php
      function thousandsFormat($num) 
      {
            include 'connect.php';
            if($num>1000) 
            {
                  $x = round($num);
                  $x_number_format = number_format($x);
                  $x_array = explode(',', $x_number_format);
                  $x_parts = array('k', 'm', 'b', 't');
                  $x_count_parts = count($x_array) - 1;
                  $x_display = $x;
                  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                  $x_display .= $x_parts[$x_count_parts - 1];

                  return $x_display;
            }
            return $num;
      }

      function pullData($query)
      {
            include 'connect.php';
            $values = $db->prepare($query);
            $values->execute();
            $result = $values->fetchAll();

            return $result;
      }

      function switchTab()
      {
      }

      function generatePosts($posts)
      {
            foreach ($posts as $row) {
                  include 'posts.php';
            }
      }
?>