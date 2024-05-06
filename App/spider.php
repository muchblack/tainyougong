<?php
namespace App;

class Spider {
    public function run() {
        $file = file_get_contents(dirname(dirname(__FILE__)).'/divination/qianshi.txt');
        $fp = fopen(dirname(dirname(__FILE__)).'/divination/Divination_JP.json','w');
        $txt = explode('@@', $file);
        $qianshi = [];
        foreach( $txt as $item )
        {
            $contents = explode( '!!', $item );
            $qianshi[] = [
                'index' => $contents[0],
                'lucky' => $contents[1],
                'content' => $contents[2],
                'explain' => $contents[3],
                'result'=> $contents[4],
            ];
        }
        
        fwrite($fp,json_encode($qianshi,JSON_UNESCAPED_UNICODE));
        fclose($fp);
    }
}


/*
{
        "index": 3,
        "luck": "兇",
        "content":"愁惱損忠良\n青宵一炷香\n雖然防小過\n閑慮覺時長",
        "explain":"層層疊疊嘆氣與苦惱，被回報的事很少吧。\n就像向著天燒香祈禱般地，你的願望無法傳達天聽吧。\n雖這樣說，但就算只有一點點善行也好，作了可以逃離災厄吧。\n東想西想之間，似乎不知不覺就像過了很長的時間。等待時機的到來吧。",
        "result":"願望：難實現吧。\n疾病：雖然拖長，但是會治好吧。\n遺失物：難以找到吧。\n盼望的人：要花很久的時間吧。\n旅行：因為很壞，放棄吧。\n蓋新居搬家：勉勉強強地算好吧。\n結婚交往：要節制吧。"
    }
    */