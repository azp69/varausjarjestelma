<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<?php
    if ($_GET['palveluid'])
    {
        include_once("modules/tietokanta.php");
        include_once("modules/palvelu.php");
        // include_once("modules/toimipiste.php");
        include_once("modules/asiakas.php");
        $tk = new Tietokanta;
        $varauskalenteri = $tk->HaePalvelunVarauskalenteri($_GET['palveluid']);

        $kuukausi = $_GET['k'];
        $vuosi = $_GET['v'];
        /*
        echo "<table>\n";
        echo "<tr>\n";
        echo "<td>Ma</td><td>Ti</td><td>Ke</td><td>To</td><td>Pe</td><td>La</td><td>Su</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        $d=cal_days_in_month(CAL_GREGORIAN,10,2005);
        echo "There was $d days in October 2005";
        */

        ?>
    
        <?php
        
        if ($_GET['v'] && $_GET['k'] && $_GET['omavarausA'] && $_GET['omavarausL'])
        {
            $omatVaraukset = [];
            $omatVaraukset[] = $_GET['omavarausA'];
            $omatVaraukset[] = $_GET['omavarausL'];
            echo build_calendar($_GET['k'], $_GET['v'], $varauskalenteri, $_GET['palveluid'], $omatVaraukset);
        }
        else if ($_GET['v'] && $_GET['k'])
        {
            echo build_calendar($_GET['k'], $_GET['v'], $varauskalenteri, $_GET['palveluid']);
        }
        else
            echo build_calendar(5, 2019, $varauskalenteri, $_GET['palveluid']);
    }


    function build_calendar($month, $year, $varauskalenteri, $palveluid, $omatVaraukset) {
        // Create array containing abbreviations of days of week.
        $daysOfWeek = array('Ma','Ti','Ke','To','Pe','La','Su');
        $monthNames = array("Tammikuu", "Helmikuu", "Maaliskuu", "Huhtikuu", "Toukokuu", "Kesäkuu", "Heinäkuu", "Elokuu", "Syyskuu", "Lokakuu", "Marraskuu", "Joulukuu");

        // What is the first day of the month in question?
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
        // How many days does this month contain?
        $numberDays = date('t',$firstDayOfMonth);
        // Retrieve some information about the first day of the
        // month in question.
        $dateComponents = getdate($firstDayOfMonth-1);
        // What is the name of the month in question?
        $monthName = $monthNames[$month-1];
        // What is the index value (0-6) of the first day of the
        // month in question.
        $dayOfWeek = $dateComponents['wday'];
        
        $nextmonth = "";
        $prevmonth = "";
        $nextyear = "";
        $prevyear = "";

        if ($month == 1)
        {
            $prevmonth = 12;
            $prevyear = $year -1;
            $nextmonth = $month + 1;
            $nextyear = $year;
        }
        else if ($month == 12)
        {
            $prevmonth = $month - 1;
            $prevyear = $year;
            $nextmonth = 1;
            $nextyear = $year + 1;
        }
        else
        {
            $prevmonth = $month -1;
            $nextmonth = $month +1;
            $nextyear = $year;
            $prevyear = $year;
        }
        // Create the table tag opener and day headers
        $calendar = "<table style='margin-left:auto; margin-right:auto;'>";
        if (isset($omatVaraukset))
        {
            $calendar .= "<caption><a href='javascript:haeMajoituksenKalenteriKuukausiJaVuosi($palveluid, " . $prevmonth . ",$prevyear, \"$omatVaraukset[0]\", \"$omatVaraukset[1]\");'><<</a> $monthName $year <a href='javascript:haeMajoituksenKalenteriKuukausiJaVuosi($palveluid, " . $nextmonth . ",$nextyear, \"$omatVaraukset[0]\", \"$omatVaraukset[1]\");'>>></a></caption>";
        }
        else
        {
            $calendar .= "<caption><a href='javascript:haeMajoituksenKalenteriKuukausiJaVuosi($palveluid, " . $prevmonth . ",$prevyear);'><<</a> $monthName $year <a href='javascript:haeMajoituksenKalenteriKuukausiJaVuosi($palveluid, " . $nextmonth . ",$nextyear);'>>></a></caption>";
        }
        
        $calendar .= "<tr>";
        // Create the calendar headers
        foreach($daysOfWeek as $day) {
             $calendar .= "<th>$day</th>";
        } 
        // Create the rest of the calendar
        // Initiate the day counter, starting with the 1st.
        $currentDay = 1;
        $calendar .= "</tr><tr>";
        // The variable $dayOfWeek is used to
        // ensure that the calendar
        // display consists of exactly 7 columns.
        if ($dayOfWeek > 0) { 
             $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>"; 
        }
        
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
     
        while ($currentDay <= $numberDays) {
             // Seventh column (Saturday) reached. Start a new row.
             if ($dayOfWeek == 7) {
                  $dayOfWeek = 0;
                  $calendar .= "</tr><tr>";
             }
             
             $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
             
             $date = "$year-$month-$currentDayRel";

             $varattu = 0;
             
             foreach ($varauskalenteri as $varaus)
             {
                if ($omatVaraukset[0] <= $date && $omatVaraukset[1] >= $date)
                {
                    $calendar .= "<td id='$date' style='color:var(--main-primary-4); background-color: #0F0; border-color:var(--main-primary-1); border: 1px solid; width: 2em;'><a href='javascript:ValitsePaivaKalenterista(\"$palveluid\", \"$date\");'>$currentDay</a></td>";
                    $varattu = 1;
                    break;
                }
                else if ($varaus["varauksen_aloituspvm"] == $date)
                {
                    $calendar .= "<td id='$date' style='color:var(--main-primary-4); background-color: #F00; border-color:var(--main-primary-1); border: 1px solid; width: 2em;'><a href='javascript:ValitsePaivaKalenterista(\"$palveluid\", \"$date\");'>$currentDay</a></td>";
                    $varattu = 1;
                    break;
                }
                else if ($varaus["varauksen_lopetuspvm"] == $date)
                {
                    $calendar .= "<td id='$date' style='color:var(--main-primary-4); background-color: #F00; border-color:var(--main-primary-1); border: 1px solid; width: 2em;'><a href='javascript:ValitsePaivaKalenterista(\"$palveluid\", \"$date\");'>$currentDay</a></td>";
                    $varattu = 1;
                    break;
                }
                else if (($varaus["varauksen_aloituspvm"] < $date) && ($varaus["varauksen_lopetuspvm"] > $date)) // varauksen_lopetuspvm
                {
                    $calendar .= "<td id='$date' style='color:var(--main-primary-4); background-color: #C00; border-color:var(--main-primary-1); border: 1px solid; width: 2em;'>$currentDay</td>";
                    $varattu = 1;
                    break;
                }
             }

             
             if ($varattu == 0)
             {
                $calendar .= "<td id='$date' style='color:var(--main-primary-4); background-color: var(--main-primary-2); border-color:var(--main-primary-1); border: 1px solid; width: 2em;'><a href='javascript:ValitsePaivaKalenterista(\"$palveluid\", \"$date\");'>$currentDay</a></td>";
             }

             // Increment counters
    
             $currentDay++;
             $dayOfWeek++;
        }
        
        
        // Complete the row of the last week in month, if necessary
        if ($dayOfWeek != 7) { 
        
             $remainingDays = 7 - $dayOfWeek;
             $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>"; 
        }
        
        $calendar .= "</tr>";
        $calendar .= "</table>";
        return $calendar;
   }
   
?>