<?php
require_once "functions.php";
require_once "crop.php";
require_once "resize.php";

class ModImg
{
    private array $options;
    private string $noArgs = "Please hint php modimg.php -h to access help" . PHP_EOL;
    private string $help = 'use' . "\t" . 'php modimg.php --crop "margin"' . PHP_EOL .
        '=> crop all all .jpg images you have in actual directory and save them in news directories' . PHP_EOL .
        'use' . "\t" . 'php moding.php --resize "sizes you want"' . PHP_EOL .
        '=> resize all .jpg images you have in actual directory and save them in news directories' . PHP_EOL .
        'use' . "\t" . 'php modimg.php -- crop "margin" --resize "sizes you want"' . PHP_EOL .
        '=> crop all .jpg image and resize them in news directory';
    private string $version = "v. 0.0.2";
    private ?string $willCrop = null;
    private ?string $willResize = null;
    private string $directory = ".";

    function __construct($options)
    {
        $this->options = getopt($options->getShortOptions(), $options->getLongOptions());
        $this->parseOptions();
    }

    private function getOptions()
    {
        return $this->options;
    }

    public function getNoArgs()
    {
        return $this->noArgs;
    }
    public function getHelp()
    {
        return $this->help;
    }

    private function getVersion()
    {
        return 'modimg ' . $this->version . PHP_EOL . PHP_EOL;
    }

    public function parseOptions()
    {
        if (empty($this->getOptions())) {
            $this->exitHelpMessage($this->getNoArgs());
        }
        foreach ($this->getOptions() as $option => $value) {
            if ($option === "h") {
                $this->exitHelpMessage($this->getHelp()); // exit, sort de la boucle
            }
            if ($option === "crop") {
                $this->setWillCrop($value);
            }
            if ($option === "resize") {
                $this->setWillResize($value);
            }
        }
        if (!$this->getWillCrop() && !$this->getWillResize()) {
            $this->exitHelpMessage($this->getNoArgs());
        } else {
            $this->actions();
        }
    }

    private function exitHelpMessage($string)
    {
        $message = $this->getVersion();
        $message .= $string;
        exit($message);
    }

    private function setWillCrop($option)
    {
        $this->willCrop = $option;
    }

    private function setWillResize($option)
    {
        $this->willResize = $option;
    }

    private function getWillCrop()
    {
        return $this->willCrop;
    }
    private function getWillResize()
    {
        return $this->willResize;
    }

    private function verifyNumericArgs(?string $argsSent): ?array
    {
        if (!$argsSent) {
            return null;
        }
        $args = explode(" ", $argsSent);
        $argsInt = [];
        foreach ($args as $arg) {
            if (!is_numeric($arg)) {
                return null;
            } else {
                $argsInt[] = intval($arg);
            }
        }
        return $argsInt;
    }
    private function setCropDirectory()
    {
        $this->directory .= "/crop";
    }
    function getDirectory()
    {
        return $this->directory;
    }
    private function actions()
    {
        if ($this->willCrop) {
            $cropValues = $this->verifyNumericArgs($this->willCrop);
            if (count($cropValues) > 1) {
                $this->exitHelpMessage($this->getHelp());
            } else {
                cropAll(getJPGOnDir(getFilesOnDir($this->getDirectory())), $cropValues[0]);
                $this->setCropDirectory();
            }
        }
        if ($this->willResize) {
            $resizeValues = $this->verifyNumericArgs($this->willResize);
            resizeAll(getJPGOnDir(getFilesOnDir($this->getDirectory())), "W", $resizeValues);
        }
    }
}
