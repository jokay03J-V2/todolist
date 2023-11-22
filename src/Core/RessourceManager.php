<?php
class RessourceManager
{
    public string $ressourcePath = "/src/Ressources/";
    /**
     * Get url for serve a file
     */
    function get(string $filename)
    {
        return CONFIG["ressources"]["hostname"] . $this->ressourcePath . $filename;
    }
}
?>