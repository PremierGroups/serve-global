<?php

use Stillat\Numeral\Languages\Language_faIR;

class Language_faIRTest extends LanguageTestBase
{
    protected function getLangInstance()
    {
        return new Language_faIR;
    }

    protected $formatTests = [
        [10000,'0,0.0000','10،000.0000'],
        [10000.23,'0,0','10،000'],
        [-10000,'0,0.0','-10،000.0'],
        [10000.1234,'0.000','10000.123'],
        [-10000,'(0,0.0000)','(10،000.0000)'],
        [-0.23,'.00','-.23'],
        [-0.23,'(.00)','(.23)'],
        [0.23,'0.00000','0.23000'],
        [1230974,'0.0a','1.2\u0645\u06cc\u0644\u06cc\u0648\u0646'],
        [1460,'0a','1\u0647\u0632\u0627\u0631'],
        [-104000,'0a','-104\u0647\u0632\u0627\u0631'],
        [1,'0o','1\u0627\u0645'],
        [52,'0o','52\u0627\u0645'],
        [23,'0o','23\u0627\u0645'],
        [100,'0o','100\u0627\u0645'],
        [1,'0[.]0','1']
    ];

    protected $currencyTests = [
        [1000.234,'$0,0.00','\ufdfc\u0031\u060c\u0030\u0030\u0030\u002e\u0032\u0033'],
        [-1000.234,'($0,0)','(\ufdfc\u0031\u060c\u0030\u0030\u0030)'],
        [-1000.234,'$0.00','-\ufdfc\u0031\u0030\u0030\u0030\u002e\u0032\u0033'],
        [1230974,'($0.00a)','\ufdfc\u0031\u002e\u0032\u0033\u0645\u06cc\u0644\u06cc\u0648\u0646']
    ];

    protected $percentageTests = [
        [1,'0%','100%'],
        [0.974878234,'0.000%','97.488%'],
        [-0.43,'0%','-43%'],
        [0.43,'(0.000%)','43.000%']
    ];

    protected $unformatTests = [
        ['10,000.123',10000.123],
        ['(0.12345)',-0.12345],
        ['(\u00a3\u0031\u002e\u0032\u0033\u0645\u06cc\u0644\u06cc\u0648\u0646)',-1230000],
        ['\u0031\u0030\u0647\u0632\u0627\u0631',10000],
        ['\u0031\u0030\u0647\u0632\u0627\u0631-',-10000],
        ['23\u0627\u0645',23],
        ['\u00a310,000.00',10000],
        ['-76%',-0.76],
        ['2:23:57',8637]
    ];

}