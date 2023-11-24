<?php
class RessourceManager
{
    /**
     * css files should be used on the header
     */
    private array $cssFiles = [];
    /**
     * Base path ressource
     */
    public string $ressourcePath = "/src/Ressources/";
    /**
     * Get url for serve a file
     */
    function get(string $fileName)
    {
        return CONFIG["ressources"]["hostname"] . $this->ressourcePath . $fileName;
    }

    /**
     * Add css file
     */
    function css(string $fileName)
    {
        array_push($this->cssFiles, $fileName);
    }

    /**
     * Get all css files
     */
    function getCSS()
    {
        return $this->cssFiles;
    }
}
?>