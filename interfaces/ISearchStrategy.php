<?php


interface ISearchStrategy {
    function getSQL($wordToSearchFor);
}

?>
