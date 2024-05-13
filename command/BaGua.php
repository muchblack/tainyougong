<?php

namespace command;

use command\core;

class BaGua implements core
{
    private array $_guaName = [
        '+++' => 0, //天
        '++-' => 1, //澤
        '+-+' => 2, //火
        '+--' => 3, //雷
        '-++' => 4, //風
        '-+-' => 5, //水
        '--+' => 6, //山
        '---' => 7, //地
    ];

    private $discord;

    public function __construct($discord)
    {
        $this->discord = $discord;
    }

    public function run(): array
    {
        $oriBaGua = [];
        $chBaGua = [];
        $yiJing = json_decode(file_get_contents('./divination/Divination_chinese.json'), true);
        
        for ($i = 0; $i < 6; $i++) {
            $temp = $this->_getOne();
            switch ($temp) {
                case 13:
                    $oriBaGua[] = '+';
                    $chBaGua[] = '-';
                    $show[] = '+*';
                    break;
                case 17:
                    $oriBaGua[] = '-';
                    $chBaGua[] = '-';
                    $show[] = '-';
                    break;
                case 21:
                    $oriBaGua[] = '+';
                    $chBaGua[] = '+';
                    $show[] = '+';
                    break;
                case 25:
                    $oriBaGua[] = '-';
                    $chBaGua[] = '+';
                    $show[] = '-*';
                    break;
            }
        }

        //本卦上下卦
        $oriUpGua = $oriBaGua[3] . $oriBaGua[4] . $oriBaGua[5];
        $oriDownGua = $oriBaGua[0] . $oriBaGua[1] . $oriBaGua[2];
        //變卦上下卦
        $chUpGua = $chBaGua[3] . $chBaGua[4] . $chBaGua[5];
        $chDownGua = $chBaGua[0] . $chBaGua[1] . $chBaGua[2];

        //得出索引
        $oriUp = $this->_guaName[$oriUpGua];
        $oriDown = $this->_guaName[$oriDownGua];
        $chUp = $this->_guaName[$chUpGua];
        $chDown = $this->_guaName[$chDownGua];

        if (($oriUp == $chUp) && ($oriDown == $chDown))
        {
            $tmpResult = ['oriGua' => $yiJing[$oriUp][$oriDown]];
        }
        else
        {
            $tmpResult = [
                'oriGua' => $yiJing[$oriUp][$oriDown],
                'chGua' => $yiJing[$chUp][$chDown]
            ];
        }

        $result = $this->_guaFormat($tmpResult);

        return [
            'tts' => 2000,
            'frontMessage' => '柚巫女聽到了你的祈求，拿出了一把揲草...',
            'message' => $result
        ];
    }

    private function _guaFormat($gua): array
    {
        $oriGua = "[本卦]  ".$gua['oriGua']['combine']."\n";
        $oriGua .= "[古解]\n".$gua['oriGua']['short']."\n";
        $oriGua .= "[運勢]\n".$gua['oriGua']['yun']."\n";
        $oriGua .= "[現解]\n".$gua['oriGua']['desc']."\n";

        $format['oriGua'] = $oriGua;

        if(isset($gua['chGua']))
        {
            $chGua = "[變卦]  ".$gua['chGua']['combine']."\n";
            $chGua .= "[古解]\n".$gua['chGua']['short']."\n";
            $chGua .= "[運勢]\n".$gua['chGua']['yun']."\n";
            $chGua .= "[現解]\n".$gua['chGua']['desc']."\n";

            $format['chiGua'] = $chGua;
        }

        return $format;
        
    }


    private function _getOne(): float|int
    {
        $daYan = 49;
        $all = [] ;
        for ($i = 0; $i < 3; $i++)
        {
            $storage = [] ;
            //step1 先分堆
            $seed = mt_rand(5,8);
            $right = mt_rand((24-$seed), (25+$seed));
            $left = $daYan-$right;

            //step2 取數
            //step2.1 右邊取一隻
            $right = $right-1 ;
            $storage[] = 1 ;

            //step2.2 左邊取餘數
            if(($left % 4) == 0 )
            {
                //整除算4
                $storage[] = 4;
            }
            else
            {
                $storage[] = ($left % 4);
            }

            //step2.3 右邊取餘數
            if($right % 4 == 0 )
            {
                $storage[] = 4;
            }
            else
            {
                $storage[] = ($right % 4);
            }
            $all[] = array_sum($storage);
            $daYan = $daYan - array_sum($storage);
        }
        return array_sum($all);
    }
}
