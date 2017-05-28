?php
namespace AppBundle\Model;



use Symfony\Component\Config\Definition\Exception\Exception;

class TranslationCarsSpecifications
{


    public function __construct()
    {

    }
    public function translateModel($plainModel){
        if(empty($plainModel))
            throw new Exception('Empty plainmodel',1);

        if(strlen($plainModel) != 6)
            throw new Exception('Plainmodel lenght != 5',2);

        $model = substr($this->plainModel,3);
        $wersjaWyposazenia = substr($this->plainModel, 3,1);
        $silnik = substr($this->plainModel,4,1);
        $skrzyniaBiegow = substr($this->plainModel, -1);

        $return = array();
        $return['model'] = $this->translatePlainModel($model);
        $return['wersjaWyposazenia'] = $this->translateWersjaWyposazenia();
        $return['silnik'] = $this->translateSilnik();
        $return['skrzyniaBiegow'] = $this->translateSkrzyniaBiegow();
        return $return;
    }
    public function translateIFA($IFA){
        if(empty($IFA))
            throw new Exception('Empty IFA',1);

        if(strlen($IFA) < 2)
            throw new Exception('IFA lenght < 2',2);

        $dataProdukcji = substr($IFA,2);

        return $dataProdukcji+1;
    }
    public function translateKolor($kolor){
        if(empty($kolor))
            throw new Exception('Empty kolor',1);

        if(strlen($kolor) < 2)
            throw new Exception('Kolor lenght < 2',2);

        $return = array();
        if(strlen($kolor) == 4){
            $kolorDachu = substr($kolor,2,2);
            $return['kolorDachu'] = $this->translatePlainKolor($kolorDachu);
        }
        $kolorNadwozia = substr($kolor,2);
        $return['kolorNadwozia'] = $this->translatePlainKolor($kolorNadwozia);

        return $return;
    }

    public function translateWnetrze($wnetrze){
        if(empty($wnetrze))
            throw new Exception('Empty wnetrze',1);

        if(strlen($wnetrze) != 2)
            throw new Exception('Wnetrze != 2',2);

        return $this->translatePlainWnetrze($wnetrze);
    }

    public function translatePakiety($pakiety){
        if(empty($pakiety))
            return null;
        $pakietyExplode = explode(" ", $pakiety);

        $return = array();
        foreach($pakietyExplode as $pakiet){
            $return[] = $this->translatePlainPakiet($pakiet);
        }
        return $return;
    }

    private function translatePlainPakiet($pakiet){
        switch ($pakiet){
            case "4A3":
                return "opcja 1";
                break;
            case "8GV":
                return "opcja 2";
                break;
            case "C42":
                return "opcja 3";
                break;
            case "NZ4":
                return "opcja 4";
                break;
            case "PDA":
                return "opcja 5";
                break;
            case "PF1":
                return "opcja 6";
                break;
            case "PK2":
                return "opcja 7";
                break;
            case "PKV":
                return "opcja 8";
                break;
            case "PLC":
                return "opcja 9";
                break;
            case "YOQ":
                return "opcja 10";
                break;
            case "8M1":
                return "opcja 11";
                break;
            case "C41":
                return "opcja 12";
                break;
            case "PJA":
                return "opcja 13";
                break;
            case "PK7":
                return "opcja 14";
                break;
            case "WQ1":
                return "opcja 15";
                break;
            case "3U3":
                return "opcja 16";
                break;
            case "3Y1":
                return "opcja 17";
                break;
            case "9T1":
                return "opcja 18";
                break;
            case "W03":
                return "opcja 19";
                break;
            case "1N7":
                return "opcja 20";
                break;
            case "4A4":
                return "opcja 21";
                break;
            case "KA2":
                return "opcja 22";
                break;
            case "PFC":
                return "opcja 23";
                break;
            case "PH2":
                return "opcja 24";
                break;
            case "PJU":
                return "opcja 25";
                break;
            case "PK9":
                return "opcja 26";
                break;
            case "PNC":
                return "opcja 27";
                break;
            case "PT3":
                return "opcja 28";
                break;
            case "PWB":
                return "opcja 29";
                break;
            case "PWD":
                return "opcja 30";
                break;
            case "RA3":
                return "opcja 31";
                break;
            case "RAG":
                return "opcja 32";
                break;
            case "4L6":
                return "opcja 33";
                break;
            case "6T2":
                return "opcja 34";
                break;
            case "C22":
                return "opcja 35";
                break;
            case "PJB":
                return "opcja 36";
                break;
            case "PW0":
                return "opcja 37";
                break;
            case "PW3":
                return "opcja 38";
                break;
            case "PWE":
                return "opcja 39";
                break;
            case "UG1":
                return "opcja 40";
                break;
            case "WPE":
                return "opcja 42";
                break;
            case "9Z3":
                return "opcja 43";
                break;
            case "C21":
                return "opcja 44";
                break;
            case "PH5":
                return "opcja 45";
                break;
            case "PK5":
                return "opcja 46";
                break;
            case "PSI":
                return "opcja 47";
                break;
            case "PW4":
                return "opcja 48";
                break;
            case "W5P":
                return "opcja 49";
                break;
            case "8GU":
                return "opcja 50";
                break;
            case "1D4":
                return "opcja 51";
                break;
            case "3Y3":
                return "opcja 52";
                break;
            case "PE2":
                return "opcja 53";
                break;
            case "PKL":
                return "opcja 54";
                break;
            case "PNG":
                return "opcja 55";
                break;
            case "PK1":
                return "opcja 56";
                break;
            case "6M3":
                return "opcja 57";
                break;
            case "3CX":
                return "opcja 58";
                break;
            case "PK4":
                return "opcja 59";
                break;
            case "PKC":
                return "opcja 60";
                break;
            case "PKH":
                return "opcja 61";
                break;
            case "C52":
                return "opcja 62";
                break;
            case "PDR":
                return "opcja 63";
                break;
            case "RAD":
                return "opcja 64";
                break;
            case "EA1":
                return "opcja 65";
                break;
            case "WPF":
                return "opcja 66";
                break;
            case "WPX":
                return "opcja 67";
                break;
            case "C17":
                return "opcja 68";
                break;
            case "RAH":
                return "opcja 69";
                break;
            case "C51":
                return "opcja 70";
                break;
            case "PDB":
                return "opcja 71";
                break;
            case "PHE":
                return "opcja 72";
                break;
            case "RAA":
                return "opcja 73";
                break;
            case "PJX":
                return "opcja 74";
                break;
            case "J0T":
                return "opcja 75";
                break;
            case "PE4":
                return "opcja 76";
                break;
            case "PK6":
                return "opcja 77";
                break;
            case "QV3":
                return "opcja 78";
                break;
            case "3N9":
                return "opcja 79";
                break;
            case "9E4":
                return "opcja 80";
                break;
            case "PLD":
                return "opcja 81";
                break;
            case "C16":
                return "opcja 82";
                break;
            case "WFD":
                return "opcja 83";
                break;
            case "C15":
                return "opcja 84";
                break;
            case "PH7":
                return "opcja 85";
                break;
            case "PJ2":
                return "opcja 86";
                break;
            case "PSC":
                return "opcja 87";
                break;
            case "WXD":
                return "opcja 88";
                break;
            case "WZE":
                return "opcja 89";
                break;
            case "3N7":
                return "opcja 90";
                break;
            case "6K2":
                return "opcja 91";
                break;
            case "EI9":
                return "opcja 92";
                break;
            case "KA1":
                return "opcja 93";
                break;
            case "PDJ":
                return "opcja 94";
                break;
            case "PWH":
                return "opcja 95";
                break;
            case "PWU":
                return "opcja 96";
                break;
            case "WFG":
                return "opcja 97";
                break;
            case "PT1":
                return "opcja 98";
                break;
            case "9S3":
                return "opcja 99";
                break;
            case "8T6":
                return "opcja 100";
                break;
            case "PR1":
                return "opcja 101";
                break;
            case "7X1":
                return "opcja 102";
                break;
            case "1KT":
                return "opcja 103";
                break;
            case "PDT":
                return "opcja 104";
                break;
            case "WPG":
                return "opcja 105";
                break;
            case "PWP":
                return "opcja 106";
                break;
            case "PGR":
                return "opcja 107";
                break;
            case "W2B":
                return "opcja 108";
                break;
            case "PN1":
                return "opcja 109";
                break;
            default:
                return null;
        }
    }
    private function translatePlainWnetrze($wnetrze)
    {
        switch ($wnetrze)
        {
            case "AB":
                return "ciemne szare";
                break;
            case "BL":
                return "ciemne grafitowe";
                break;
            case "BW":
                return "czerowne";
                break;
            case "EQ":
                return "niebieskie";
                break;
            case "EX":
                return "czarne";
                break;
            case "GG":
                return "żółte";
                break;
            case "GK":
                return "szare";
                break;
            case "HA":
                return "białe";
                break;
            case "LA":
                return "czarno-brązowe";
                break;
            default:
                return null;
        }
    }
    private function translatePlainKolor($kolor)
    {
        switch ($kolor){
            case "1Z1Z":
                return "czarny";
                break;
            case "2C2C":
                return "szary";
                break;
            case "3K3K":
                return "biały-mint";
                break;
            case "4K4K":
                return "JASNO-BRĄZOWY";
                break;
            case "8E8E":
                return "srebrny";
                break;
            case "8T8T":
                return "czerwony";
                break;
            case "8X8X":
                return "NIEBIESKI";
                break;
            case "9P9P":
                return "biały";
                break;
            case "B4B4":
                return "biały";
                break;
            case "F6F6":
                return "szary";
                break;
            case "G0G0":
                return "zółty";
                break;
            case "G2G2":
                return "czerowny";
                break;
            case "Z5Z5":
                return "niebieski";
                break;
            default:
                return null;
        }
    }
    private function translatePlainModel($model)
    {
        switch ($model){
            case "3V3":
                return "Superb Liftback";
            break;
            case "5E5":
                return "Octavia Kombi";
                break;
            case "NF1":
                return "Citigo";
                break;
            case "NH1":
                return "Rapid Liftback";
                break;
            case "NH3":
                return "Rapid Spaceback";
                break;
            case "NJ3":
                return "Fabia Hatchback";
                break;
            case "NJ5":
                return "Fabia Kombi";
                break;
            default:
                return null;
        }
    }

    private function translatePlainWersjaWyposazenia($wersjaWyposazenia)
    {
        switch ($wersjaWyposazenia)
        {
            case "1":
                return "Wersja 1 ";
            break;
            case "2":
                return "Wersja 2 ";
                break;
            case "3":
                return "Wersja 3 ";
                break;
            case "4":
                return "Wersja 4 ";
                break;
            default:
                return null;

        }
    }


    private function translatePlainSilnik($silnik)
    {
        switch ($silnik)
        {
            case "1":
                return "Silnik 1 ";
                break;
            case "2":
                return "Silnik 2 ";
                break;
            case "3":
                return "Silnik 3 ";
                break;
            case "4":
                return "Silnik 4 ";
                break;
            case "5":
                return "Silnik 5 ";
                break;
            case "6":
                return "Silnik 6 ";
                break;
            case "7":
                return "Silnik 7 ";
                break;
            case "8":
                return "Silnik 8 ";
                break;
            case "9":
                return "Silnik 9 ";
                break;
            case "A":
                return "Silnik 10 ";
                break;
            case "B":
                return "Silnik 11";
                break;
            case "C":
                return "Silnik 12";
                break;
            case "D":
                return "Silnik 13";
                break;
            case "E":
                return "Silnik 14";
                break;
            case "F":
                return "Silnik 15";
                break;
            case "G":
                return "Silnik 16";
                break;
            case "H":
                return "Silnik 17";
                break;
            case "I":
                return "Silnik 18";
                break;
            case "J":
                return "Silnik 19";
                break;
            case "K":
                return "Silnik 20";
                break;
            case "L":
                return "Silnik 21";
                break;
            case "M":
                return "Silnik 22";
                break;
            case "N":
                return "Silnik 23 ";
                break;
            case "O":
                return "Silnik 24 ";
                break;
            case "P":
                return "Silnik 25 ";
                break;
            case "R":
                return "Silnik 26 ";
                break;
            case "S":
                return "Silnik 27 ";
                break;
            case "T":
                return "Silnik 28 ";
                break;
            case "U":
                return "Silnik 29";
                break;
            case "V":
                return "Silnik 30 ";
                break;
            case "X":
                return "Silnik 31";
                break;
            case "Y":
                return "Silnik 32 ";
                break;
            case "Z":
                return "Silnik 33 ";
                break;
            case "Q":
                return "Silnik 34 ";
                break;
            default:
                return null;

        }
    }

    private function translatePlainSkrzyniaBiegow($skrzyniaBiegow)
    {
        switch ($skrzyniaBiegow)
        {
            case "Y":
                return "Skrzynia biegów  1 ";
                break;
            case "5":
                return "Skrzynia biegów  2 ";
                break;
            case "C":
                return "Skrzynia biegów  3 ";
                break;
            case "X":
                return "Skrzynia biegów  4 ";
                break;
            case "D":
                return "Skrzynia biegów  5 ";
                break;
            case "1":
                 return "Skrzynia biegów  6 ";
                 break;
            case "4":
                 return "Skrzynia biegów  7 ";
                 break;


            default:
                return null;

        }
    }

}