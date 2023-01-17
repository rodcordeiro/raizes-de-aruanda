<?php

function Ponto(int $index,array $ponto)
{
    $article = "<article class='ponto'>
    <hr/>

    <p class='ritmo'><span>$index.</span> ".$ponto['ritmo']."</p>
    <div class='lyric'><pre>".$ponto['ponto']."</pre></div>";

    if (preg_match("/.mp3/", $ponto['audio_link']) || preg_match("/.mp4/", $ponto['audio_link']) || preg_match("/.m4a/", $ponto['audio_link']) || preg_match("/.ogg/", $ponto['audio_link']) || preg_match("/.wma/", $ponto['audio_link'])) {
        $article.= "
            <audio controls>
                <source src='pontos/ ". $ponto['audio_link'] ."' type='audio/mp3'>
            </audio>
        ";
    }
    $article.= "</article>";
    echo $article;
}
