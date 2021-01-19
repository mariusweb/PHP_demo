<?php



class CalculationSystem {

    private $arrayOfNumbers;
    private $rezult = array();
    private $arrThird = array();
    

    public function __construct($arrayOfNumbers) {
        $this->arrayOfNumbers = $arrayOfNumbers;
    }

    private function convertArrayReturnSecond($string) {
        array_walk_recursive($this->arrayOfNumbers, function ($value) {
            array_push($this->rezult, $value);
        });
        if($string == "second"){
            return $this->rezult[1];
        } elseif ($string == "third") {
            $this->arrThird = array_slice($this->rezult, -3, 1, true);
            $this->arrThird = array_shift($this->arrThird);
            return $this->arrThird;
        }
        
        
    }

    public function binary() {
        echo 'Dvejetainis antras';
        echo '<br>';
        echo decbin($this->convertArrayReturnSecond("second"));
        echo"<br>";
        echo 'Dvejetainis trecias nuo galo';
        echo"<br>";
        echo decbin($this->convertArrayReturnSecond("third"));
        
    }

    public function octal() {
        echo 'Aštuntainė antras';
        echo '<br>';
        echo decoct($this->convertArrayReturnSecond("second"));
        echo"<br>";
        echo 'Aštuntainė trecias nuo galo';
        echo"<br>";
        echo"<br>";
        echo decoct($this->convertArrayReturnSecond("third"));
        
    }

    public function hexadecimal() {
        echo 'Šešioliktainė antras';
        echo '<br>';
        echo dechex($this->convertArrayReturnSecond("second"));
        echo"<br>";
        echo 'Šešioliktainė trecias nuo galo';
        echo"<br>";
        echo"<br>";
        echo dechex($this->convertArrayReturnSecond("third"));
        
    }

    public function decimal() {
        echo 'Dešimtaine antras';
        echo '<br>';
        echo $this->convertArrayReturnSecond("second");
        echo"<br>";
        echo 'Dešimtaine trecias nuo galo';
        echo"<br>";
        echo"<br>";
        print_r($this->convertArrayReturnSecond("third")) ;
        
    }

}
