<?php

interface ICommand
{
    function onCommand($name, Request $request);
}

?>
