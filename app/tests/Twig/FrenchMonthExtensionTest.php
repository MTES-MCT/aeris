<?php

namespace App\Tests\Twig;

use PHPUnit\Framework\TestCase;
use App\Twig\FrenchMonthExtension;

class FrenchMonthExtensionTest extends TestCase
{
    public function monthfrDataProvider(){
        return [
            [\DateTime::createFromFormat('j-M-Y', '01-January-2018'),   'Jan.&nbsp;2018'],
            [\DateTime::createFromFormat('j-M-Y', '15-Feb-2009'),       'Fév.&nbsp;2009'],
            [\DateTime::createFromFormat('j-M-Y', '30-March-2007'),     'Mars&nbsp;2007'],
            [\DateTime::createFromFormat('j-M-Y', '12-April-2034'),     'Avr.&nbsp;2034'],
            [\DateTime::createFromFormat('j-M-Y', '04-May-1997'),       'Mai&nbsp;1997'],
            [\DateTime::createFromFormat('j-M-Y', '7-June-2016'),       'Juin&nbsp;2016'],
            [\DateTime::createFromFormat('j-M-Y', '4-July-2009'),       'Jui.&nbsp;2009'],
            [\DateTime::createFromFormat('j-M-Y', '8-August-2010'),     'Août&nbsp;2010'],
            [\DateTime::createFromFormat('j-M-Y', '21-September-2011'), 'Sep.&nbsp;2011'],
            [\DateTime::createFromFormat('j-M-Y', '25-October-2012'),   'Oct.&nbsp;2012'],
            [\DateTime::createFromFormat('j-M-Y', '7-November-2013'),   'Nov.&nbsp;2013'],
            [\DateTime::createFromFormat('j-M-Y', '19-December-2014'),  'Déc.&nbsp;2014']
        ];
    }

    /**
     * @dataProvider monthfrDataProvider
     */
    public function testMonthfr($date, $expectedOutput) {
        $extension = new FrenchMonthExtension();

        $this->assertEquals($extension->monthfr($date), $expectedOutput);
    }
}