<?php
function getTomUlaNumbers() : void
{
    for($i = 1; $i < 101; $i++)
    {
        if($i % 3 == 0 && $i % 5 == 0)
            echo 'TomUla';
        else if($i % 3 == 0)
            echo 'Tom';
        else if($i % 5 == 0)
            echo 'Ula';
        else
            echo $i;

        echo "\n";
    }
}

getTomUlaNumbers();
?>
