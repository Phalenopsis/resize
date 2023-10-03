<?php
class Options
{
    private $shortOptions;
    private $longOptions;

    function __construct()
    {
        $this->shortOptions = $this->createShortOptions();
        $this->longOptions = $this->createLongOptions();
    }
    private function createShortOptions()
    {
        $shortOptions = "";
        $shortOptions .= "h::";
        //echo "from function" . $shortOptions; // test
        return $shortOptions;
    }

    private function createLongOptions()
    {
        $longOptions  = array(
            "resize:",
            "crop:",
            "h::",
            "help::"
        );
        return $longOptions;
    }

    public function getShortOptions()
    {
        return $this->shortOptions;
    }
    public function getLongOptions()
    {
        return $this->longOptions;
    }
}


/* used for tests

$option = new Options();

echo $option->getShortOptions();
echo $option->shortOptions; */
