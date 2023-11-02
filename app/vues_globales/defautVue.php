<?php 
if (!empty($erreurs_a)) {
        echo '<ul>'."\n";
        foreach($erreurs_a as $e)
       	        {
                  echo ' <li>'.$e.'</li>'."\n";
                }
				echo '</ul>';
    }   