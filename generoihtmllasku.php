<?php 

include_once("modules/tietokanta.php");
include_once("modules/lasku.php");
include_once("modules/varaus.php");
include_once("modules/asiakas.php");
include_once("modules/palvelu.php");
include_once("modules/varauksenpalvelut.php");

$tk = new Tietokanta;


function generoiHtmlLasku($laskuid)
{
    if (isset($laskuid)) {
        $tk = new Tietokanta;

        $lasku = $tk->HaeLaskunTiedot($laskuid);
        
        $varausid = $lasku->getVarausId();
        
        $varaus = $tk->HaeVaraus($varausid);
        $asiakas = $varaus->getAsiakas();
        $varauksenPalvelut = $tk->HaeVaraukseenKuuluvatPalvelut($varausid);
        $palvelut = [];
        $laskunVerotonSumma = 0;
        $alvnMaara = 0;
        foreach ($varauksenPalvelut as $vp){
            $p = $vp->getPalveluID();
            $palvelut[] = $p;
            $alv = ((($p->getHinta() / 100) * $p->getAlv()) * $vp->getLkm());
            $alvnMaara += $alv;
            $laskunVerotonSumma += ($p->getHinta() * $vp->getLkm());
        }

    }
    else
        die("Virhe luotaessa laskua");
    
    $html = '
    <link rel="stylesheet" type="text/css" href="styles/laskunmuotoilu.css">
    
    <div class="main-container">
    
        <div class="lasku-header">
            <h2>Lasku</h2>
        </div>
        
    
        <div class="logo">
    
        </div>
    
        <table class="perustiedot">
            <tr>
                <th></th>
                <th>Laskun päiväys</th>
                <th>Viivästyskorko</th>
            </tr>
            <tr>
                <td rowspan="7"><img src="images/village_people_logo.jpg"></td>
                <td>' . (date('d.m.Y', time())) . '</td>
                <td>5 %</td>
            </tr>
            <tr>
                <th>Laskunumero</th>
                <th>Asiakasnumero</th>
            </tr>
            <tr>
                <td>' . $lasku->getLaskuId() . '</td>
                <td>' . $lasku->getAsiakasId() . '</td>
            </tr>
            <tr>
                <th>Maksuehto</th>
                <th>Viitenumero</th>
            </tr>
            <tr>
                <td>14 päivää</td>
                <td>'. $lasku->getLaskuId() . $lasku->getAsiakasId() . '</td>
            </tr>
            <tr>
                <th colspan="2">Eräpäivä</th>
            </tr>
            <tr>
                <td colspan="2">' . (date('d.m.Y', time() + (60 * 60 * 24 * 14))) . '</td>
            </tr>
        </table>
    
        <div class="lisatietokentta">
            <p>Lisätietoa laskusta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut porta tempor dolor, ut vestibulum dui ullamcorper a. In sodales auctor aliquam. Proin fringilla eros tincidunt, suscipit enim in, porttitor arcu. Mauris lectus lectus, rutrum vitae lacus non, posuere luctus mauris. Morbi facilisis accumsan ex, sed egestas nibh lobortis sed. Nulla facilisi.</p>
        </div>
    
        <table class="erittely">
            <tr>
                <th>Palvelu</th>
                <th>Määrä</th>
                <th>Yks.</th>
                <th>à hinta</th>
                <th>Alv %</th>
                <th>Verollinen yht.</th>
            </tr>';
    
            foreach ($varauksenPalvelut as $vp){
                $p = $vp->getPalveluID();
                $html .= "<tr>";
                $html .= "<td>" . $p->getNimi() . "</td>\n";
                $kpl = $vp->getLkm();
                $html .= "<td>" . $kpl . "</td>\n";
                if ($p->getTyyppi() == 1) {
                    $html .= "<td>Yö</td>\n";
                } else {
                    $html .= "<td>kpl</td>\n";
                }
                $html .= "<td>" . number_format($p->getHinta(),2,","," ") . "</td>\n";
                $html .= "<td>" . number_format($p->getAlv(),2,","," ") . "</td>\n";
                $ahinta = $p->getHinta() + (($p->getHinta() / 100) * $p->getAlv());
                $html .= "<td>" . number_format(($kpl * $ahinta),2,","," ") . "</td>\n";
                $html .= "</tr>\n";
            }
    
            $html .= '
            <tr>
                <td class="empty"></td>
                <td class="empty"></td>
                <td class="empty"></td>
                <td class="empty"></td>
                <th>Veroton yhteensä</th>
                <td>'. number_format($laskunVerotonSumma,2,","," ") .'</td>
            </tr>
            <tr>
                <td class="empty"></td>
                <td class="empty"></td>
                <td class="empty"></td>
                <td class="empty"></td>
                <th>ALV yhteensä</th>
                <td>' . number_format($alvnMaara,2,","," ") . '</td>
            </tr>
            <tr>
                <td class="empty"></td>
                <td class="empty"></td>
                <td class="empty"></td>
                <td class="empty"></td>
                <th>Verollinen yhteensä</th>
                <td>' . number_format(($laskunVerotonSumma + $alvnMaara),2,","," ") . '</td>
            </tr>
        </table>
    
    
        <table class="maksutiedot">
            <tr>
                <th>IBAN</th>
                <th>BIC</th>
                <th>Eräpäivä</th>
            </tr>
            <tr>
                <td>FI49 5000 9420 0287 30</td>
                <td>OKOYFIHH</td>
                <td>' . (date('d.m.Y', time() + (60 * 60 * 24 * 14))) . '</td>
            </tr>
            <tr>
                <th colspan="2">Viitenumero</th>
                <th>Yhteensä EUR</th>
            </tr>
            <tr>
                <td colspan="2">' . $lasku->getLaskuId() . $lasku->getAsiakasId() . '</td>
                <td>' . number_format(($laskunVerotonSumma + $alvnMaara),2,","," ") . '</td>
            </tr>
        </table>
    
    </div>';

    return $html;
}

?>