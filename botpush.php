<?php
session_start();
require "vendor/autoload.php";
// การตั้งเกี่ยวกับ bot
require_once 'bot_settings.php';
    
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Event;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
    // เชื่อมต่อกับ LINE Messaging API
    $httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
    $bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
    // คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
    $content = file_get_contents('php://input');
   
    // แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
    $events = json_decode($content, true);
    $accessToken = "cWOQxTGqlQcXRM6o/BakZa9VNahQ/Q5FV2UiqxH93G3Z/Qq1xTGEe4GnUEgcak5W3ks9QmV8SeMUDGbmy1d6yOUBTD71kHqM6sN7M7cHXAfKZ+PuvxINMKICGClKvXMAXvnTvNFHhVacks+qnUVbKwdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    //รับข้อความจากผู้ใช้
    $message = $events['events'][0]['message']['text'];
    $message = strtolower($message);
    //รับ id ของผู้ใช้
    $id = $events['events'][0]['source']['userId'];   
    
    $strUrl = "https://api.line.me/v2/bot/message/push";
    //เชื่อมต่อ mlab
    $api_key="vo4A7mc22PVnCfj2tHaQEqjiAuB0M0Ix";
	
    //colletion พูดคุยทั่วไป
    $url = 'https://api.mlab.com/api/1/databases/rup_db/collections/bot?apiKey='.$api_key.'';
    $json = file_get_contents('https://api.mlab.com/api/1/databases/rup_db/collections/bot?apiKey='.$api_key.'&q={"user":"'.$message.'"}');
    $data = json_decode($json);
    $isData = sizeof($data);
    //collection คำตอบ ใช่
    $url2 = 'https://api.mlab.com/api/1/databases/rup_db/collections/yes?apiKey='.$api_key.'';
    $json2 = file_get_contents('https://api.mlab.com/api/1/databases/rup_db/collections/yes?apiKey='.$api_key.'&q={"user":"'.$message.'"}');
    $data2 = json_decode($json2);
    $isData2 = sizeof($data2);
    //collection คำตอบ ไม่
    $url3 = 'https://api.mlab.com/api/1/databases/rup_db/collections/no?apiKey='.$api_key.'';
    $json3 = file_get_contents('https://api.mlab.com/api/1/databases/rup_db/collections/no?apiKey='.$api_key.'&q={"user":"'.$message.'"}');
    $data3 = json_decode($json3);
    $isData3 = sizeof($data3);

        if (strpos($message, 'สอนบอท') !== false) {
            $s_message = "A";
        }
        else if($isData > 0){
            $s_message = "B";
        }
   	 else if(strpos($message, 'เริ่มทดสอบ') !== false){
	    $s_message = "C";
	} 
	else if(strpos($message, 'สอนคำตอบ') !== false){
	    $s_message = "D";
	} 
	else {
		 
		$fileName = $id . ".txt";

		if(file_exists($fileName)) {
			$s_message = "C";
		} 
		 
	}



        switch ($s_message) {
            case "A":
			 if (strpos($message, 'สอนบอท') !== false) {
			    $x_tra = str_replace("สอนบอท","", $message);
			    $pieces = explode("|", $x_tra);
			    $_user=str_replace("[","",$pieces[0]);
			    $_system=str_replace("]","",$pieces[1]);
			     //Post New Data
			   $newData = json_encode(
				      array(
					'user' => $_user,
					'system'=> $_system
				      )
				    );
				$opts = array(
				   'http' => array(
				   'method' => "POST",
				   'header' => "Content-type: application/json",
				   'content' => $newData
			       )
			    );
			    $context = stream_context_create($opts);
			    $returnValue = file_get_contents($url,false,$context);

			 }
			
                    $textReplyMessage = "ขอบคุณที่สอนจ้า";
                    $textMessage = new TextMessageBuilder($textReplyMessage);
                    $stickerID = 41;
                    $packageID = 2;
                    $stickerMessage = new StickerMessageBuilder($packageID,$stickerID);
                    
                    $multiMessage = new MultiMessageBuilder;
                    $multiMessage->add($textMessage);
                    $multiMessage->add($stickerMessage);
                    $replyData = $multiMessage; 
		$response = $bot->replyMessage($replyToken,$replyData);
            break;
					
            case "B":
                if($isData >0){
                    foreach($data as $rec){
                        $textReplyMessage = $rec->system;
                        $textMessage = new TextMessageBuilder($textReplyMessage);   
                           
                        $multiMessage = new MultiMessageBuilder;
                        $multiMessage->add($textMessage);      
                        $replyData = $multiMessage; 
                        
                       }
                }
				else{
	  
					$textReplyMessage = "คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนบอท[คำถาม|คำตอบ]";
					$textMessage = new TextMessageBuilder($textReplyMessage); 
							
					$multiMessage = new MultiMessageBuilder;
					$multiMessage->add($textMessage);   
					$replyData = $multiMessage; 
				}
			$response = $bot->replyMessage($replyToken,$replyData);
						 
		    break;
			case "C":
			
			$fileName = $id . ".txt";
		
			
			if(filesize($fileName) == 0 ) {
				
				$myfile = fopen($fileName, "x+");
				
				$numQ = 2;
				$txtW = "1||0";
				$count = 0;
				fwrite($myfile, $txtW);
				fclose($myfile);
				
				$answer = $tmp[1] . $message . ",";
				
			} else {
				
				$myfile = fopen($fileName, "r");
				$txt = fread($myfile,filesize($fileName));
				fclose($myfile);

				$tmp = explode("|", $txt);
				$numQ = $tmp[0] + 2;
				
				$tmp[0] = $tmp[0] + 1;
				$tmp[1] = $tmp[1] . $message . ",";	
				
				$count = $tmp[2];
				
				if(strpos($message, 'ไม่ใช่') !== false){
					$count = $tmp[2];
				}	
				else{
					if($isData3 > 0 || strpos($message, 'ไม่') !== false){
						$count = $tmp[2];
					}
					else if($isData2 > 0 || strpos($message, 'ใช่') !== false){
						$count = $tmp[2] + 1;
					}
				}
				
				
				

				$myfile = fopen($fileName, "w");
				$txtW = $tmp[0] . "|" . $tmp[1] . "|" . $count;
				fwrite($myfile, $txtW);
				fclose($myfile);
				
			}
			
			if($tmp[0] <= 1){			
				$question = "คุณคิดว่า คุณสามารถทำให้ดีกว่านี้ได้";
			}
			
			if($tmp[0] == 2){			
				$question = "คุณจะไม่ทำสิ่งต่าง ๆ ถ้าคุณไม่มีเวลาพอที่จะทำมันให้เสร็จสมบูรณ์";
			}
			
			if($tmp[0] == 3){			
				$question = "คุณกลัวที่จะล้มเหลว เมื่อทำงานสำคัญหรืองานใหญ่";
			}
			
			if($tmp[0] == 4){			
				$question = "คุณพยายามทำสิ่งที่ดีที่สุด เพื่อให้ผู้อื่นประทับใจ";
			}
			
			if($tmp[0] == 5){			
				$question = "คุณจะโทษตัวเอง เมื่อคุณทำผิดพลาด";
			}
			
			if($tmp[0] == 6){			
				$question = "คุณพยายามควบคุมอารมณ์ตนเองตลอดเวลา";
			}
			
			if($tmp[0] == 7){			
				$question = "คุณจะอารมณ์เสียเมื่อสิ่งต่าง ๆ ไม่เป็นไปตามแผน";
			}
			
			if($tmp[0] == 8){			
				$question = "คุณรู้สึกไม่พอใจในคุณภาพงานของผู้อื่นบ่อยครั้ง";
			}
			
			if($tmp[0] == 9){			
				$question = "คุณรู้สึกว่ามาตรฐานของคุณไม่สูงเกินไป";
			}
			
			if($tmp[0] == 10){			
				$question = "คุณกลัวว่าคนอื่นจะคิดเล็กคิดน้อยกับฉันถ้าฉันทำงานผิดพลาด";
			}
			
			if($tmp[0] == 11){			
				$question = "คุณพยายามปรับปรุงตนเองตลอดเวลา";
			}
			
			if($tmp[0] == 12){			
				$question = "คุณจะไม่มีความสุขถ้าสิ่งที่คุณทำต่ำกว่ามาตรฐาน";
			}
			
			if($tmp[0] == 13){			
				$question = "บ้านและที่ทำงานต้องสะอาดและเรียบร้อยเสมอ";
			}
			
			if($tmp[0] == 14){			
				$question = "คุณรู้สึกว่าด้อยกว่าผู้อื่น ที่มีความฉลาดและประสบความสำเร็จมากกว่า";
			}
			
			if($tmp[0] == 15){			
				$question = "คุณต้องดูดีที่สุดเมื่ออยู่ในที่สาธารณะ";
			}
			
			if($tmp[0] == 16){
				$question = "ขอบอทวิเคราะห์แพรพ";
			}
	
			if($tmp[0] >= 16){			
				$myfile = fopen($fileName, "w");
				fwrite($myfile, "");
				
				fclose($myfile);
				unlink($fileName);
			}
	
			if($tmp[2] >= 5){
				$textReplyMessage = "คุณมีโอกาสเสี่ยงที่จะเป็นภาวะ Perfectionist นี่เป็นเพียงแบบทดสอบเริ่มต้น ควรไปพบจิตแพทย์เพื่อความแน่ใจ";
				$textMessage = new TextMessageBuilder($textReplyMessage); 
				
				$textReplyMessage2 = "คุณสามารถสอนคำตอบเพิ่มเติมเกี่ยวกับคำว่า 'ใช่' หรือ 'ไม่' โดยการพิมพ์ : สอนคำตอบ[คำที่ต้องการสอน|ใช่ หรือ ไม่]";
				$textMessage2 = new TextMessageBuilder($textReplyMessage2);
				
				$multiMessage = new MultiMessageBuilder;
				$multiMessage->add($textMessage);   
				$multiMessage->add($textMessage2);   
				$replyData = $multiMessage; 
				$response = $bot->pushMessage($id,$replyData);	
				
				$myfile = fopen($fileName, "w");
				fwrite($myfile, "");
				
				fclose($myfile);
				unlink($fileName);
						
			}
			else{
				
				if($tmp[0] >= 16){
					$textReplyMessage = "ยินดีด้วย คุณยังไม่มีภาวะเสี่ยงที่จะเป็นภาวะ Perfectionist นี่เป็นเพียงแบบทดสอบเริ่มต้น ควรไปพบจิตแพทย์เพื่อความแน่ใจ";
					$textMessage = new TextMessageBuilder($textReplyMessage); 
					
					$textReplyMessage2 = "คุณสามารถสอนคำตอบเพิ่มเติมเกี่ยวกับคำว่า 'ใช่' หรือ 'ไม่' โดยการพิมพ์ : สอนคำตอบ[คำที่ต้องการสอน|ใช่ หรือ ไม่]";
					$textMessage2 = new TextMessageBuilder($textReplyMessage2); 
					
					$multiMessage = new MultiMessageBuilder;
					$multiMessage->add($textMessage);   
					$multiMessage->add($textMessage2); 
					$replyData = $multiMessage; 
					$response = $bot->pushMessage($id,$replyData);
					
					$myfile = fopen($fileName, "w");
					fwrite($myfile, "");
					fclose($myfile);
					unlink($fileName);
				}
				else{
					$textReplyMessage = $question;
					$textMessage = new TextMessageBuilder($textReplyMessage); 

					$textReplyMessage2 = $txtW;
					$textMessage2 = new TextMessageBuilder($textReplyMessage2); 

					$multiMessage = new MultiMessageBuilder;
					$multiMessage->add($textMessage);   			
					$multiMessage->add($textMessage2); 

					$replyData = $multiMessage; 
					$response = $bot->pushMessage($id,$replyData);	
				}	
			}
			
			 break;
			
	
				
/*			
			if(isset($_SESSION['views'])){
			$_SESSION['views'] = $_SESSION['views']+ 1;
			}
			else{
			$_SESSION['views'] = 1;
			}
			$textReplyMessage = $_SESSION['views'];
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			
			 $multiMessage = new MultiMessageBuilder;
			$multiMessage->add($textMessage);   
			
			$replyData = $multiMessage; 
			$response = $bot->pushMessage($id,$replyData);

			
				
			
			for($count = 0 ; $count <15 ; $count++){
	        
		
    		if($count == 0){
			$textReplyMessage = "คุณคิดว่า คุณสามารถทำให้ดีกว่านี้ได้";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
		
		if($count == 1){
			$textReplyMessage = "คุณจะไม่ทำสิ่งต่าง ๆ ถ้าคุณไม่มีเวลาพอที่จะทำมันให้เสร็จสมบูรณ์";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 2){
			$textReplyMessage = "คุณกลัวที่จะล้มเหลว เมื่อทำงานสำคัญหรืองานใหญ่";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 3){
			$textReplyMessage = "คุณพยายามทำสิ่งที่ดีที่สุด เพื่อให้ผู้อื่นประทับใจ";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 4){
			$textReplyMessage = "คุณจะโทษตัวเอง เมื่อคุณทำผิดพลาด";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 5){
			$textReplyMessage = "คุณพยายามควบคุมอารมณ์ตนเองตลอดเวลา";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 6){
			$textReplyMessage = "คุณจะอารมณ์เสียเมื่อสิ่งต่าง ๆ ไม่เป็นไปตามแผน";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
			
		if($count == 7){
			$textReplyMessage = "คุณรู้สึกไม่พอใจในคุณภาพงานของผู้อื่นบ่อยครั้ง";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 8){
			$textReplyMessage = "คุณรู้สึกว่ามาตรฐานของคุณไม่สูงเกินไป";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 9){
			$textReplyMessage = "คุณกลัวว่าคนอื่นจะคิดเล็กคิดน้อยกับฉันถ้าฉันทำงานผิดพลาด";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 10){
			$textReplyMessage = "คุณพยายามปรับปรุงตนเองตลอดเวลา";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 11){
			$textReplyMessage = "คุณจะไม่มีความสุขถ้าสิ่งที่คุณทำต่ำกว่ามาตรฐาน";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 12){
			$textReplyMessage = "บ้านและที่ทำงานต้องสะอาดและเรียบร้อยเสมอ";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 13){
			$textReplyMessage = "คุณรู้สึกว่าด้อยกว่าผู้อื่น ที่มีความฉลาดและประสบความสำเร็จมากกว่า";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
				
		if($count == 14){
			$textReplyMessage = "คุณต้องดูดีที่สุดเมื่ออยู่ในที่สาธารณะ";
                	$textMessage = new TextMessageBuilder($textReplyMessage); 
			$textReplyMessage2 = $count;
                	$textMessage2 = new TextMessageBuilder($textReplyMessage2);
			
			$message = $events['events'][0]['message']['text'];
			
			$textReplyMessage3 = $message;
                	$textMessage3 = new TextMessageBuilder($textReplyMessage3);
		}
			
				
		
				
	       				
                $multiMessage = new MultiMessageBuilder;
                $multiMessage->add($textMessage);   
		$multiMessage->add($textMessage2);  
		$multiMessage->add($textMessage3);
                $replyData = $multiMessage; 
		$response = $bot->pushMessage($id,$replyData);
			}*/
			
		case "D":
			 if (strpos($message, 'สอนคำตอบ') !== false) {
			    $x_tra = str_replace("สอนคำตอบ","", $message);
			    $pieces = explode("|", $x_tra);
			    $_user=str_replace("[","",$pieces[0]);
			    $_system=str_replace("]","",$pieces[1]);
			     //Post New Data
			   
		           if($_system == "ใช่"){
			    $newData = json_encode(
				      array(
					'user' => $_user,
					'system'=> $_system
				      )
				    );
				$opts = array(
				   'http' => array(
				   'method' => "POST",
				   'header' => "Content-type: application/json",
				   'content' => $newData
			       )
			    );
			    $context = stream_context_create($opts);
			    $returnValue = file_get_contents($url2,false,$context);
			   }
		            else if($_system == "ไม่"){
				   $newData = json_encode(
				      array(
					'user' => $_user,
					'system'=> $_system
				      )
				    );
				$opts = array(
				   'http' => array(
				   'method' => "POST",
				   'header' => "Content-type: application/json",
				   'content' => $newData
			       )
			    );
			    $context = stream_context_create($opts);
			    $returnValue = file_get_contents($url3,false,$context);
			    }
			 }
			
                    $textReplyMessage = "ขอบคุณที่สอนจ้า";
                    $textMessage = new TextMessageBuilder($textReplyMessage);
                    $stickerID = 41;
                    $packageID = 2;
                    $stickerMessage = new StickerMessageBuilder($packageID,$stickerID);
                    
                    $multiMessage = new MultiMessageBuilder;
                    $multiMessage->add($textMessage);
                    $multiMessage->add($stickerMessage);
                    $replyData = $multiMessage; 
		    $response = $bot->replyMessage($replyToken,$replyData);
            break;
			
			
			
			
        default:
                    $answer = rand(1, 6);
			
		    if($answer == 1){
			    $default_answer = "งงจังเลย";
		    }
		    if($answer == 2){
			    $default_answer = "ไม่เข้าใจเลยอ่ะ";
		    }
		    if($answer == 3){
			    $default_answer = "พูดอีกทีได้ไหม";
		    }
		    if($answer == 4){
			    $default_answer = "ว่ายังไงนะ";
		    }
		    if($answer == 5){
			    $default_answer = "พูดใหม่ได้ไหม";
		    }
		    if($answer == 6){
			    $default_answer = "ฟังไม่ทันเลย";
		    }
		
		    $textReplyMessage = $default_answer;
                    $textMessage = new TextMessageBuilder($textReplyMessage); 
			
            
                    $textReplyMessage2 = "คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนบอท[คำถาม|คำตอบ]";
                    $textMessage2 = new TextMessageBuilder($textReplyMessage2); 
                        
                    $multiMessage = new MultiMessageBuilder;
                    $multiMessage->add($textMessage);   
		    $multiMessage->add($textMessage2);   
                    $replyData = $multiMessage; 
		   $response = $bot->replyMessage($replyToken,$replyData);
            break;                                         
	}
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}
// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
 /*
    if (strpos($message, 'สอนบอท') !== false) {
         if (strpos($message, 'สอนบอท') !== false) {
            $x_tra = str_replace("สอนบอท","", $message);
            $pieces = explode("|", $x_tra);
            $_user=str_replace("[","",$pieces[0]);
            $_system=str_replace("]","",$pieces[1]);
             //Post New Data
            $newData = json_encode(
              array(
                'user' => $_user,
                'system'=> $_system
              )
            );
        $opts = array(
           'http' => array(
           'method' => "POST",
           'header' => "Content-type: application/json",
           'content' => $newData
       )
    );
    $context = stream_context_create($opts);
    $returnValue = file_get_contents($url,false,$context);
    $arrayPostData['to'] = $id;
    $arrayPostData = array();
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = 'ขอบคุณที่สอนจ้า';
    $arrayPostData['messages'][1]['type'] = "sticker";
    $arrayPostData['messages'][1]['packageId'] = "2";
    $arrayPostData['messages'][1]['stickerId'] = "41";
    replyMsg($arrayHeader,$arrayPostData);
  
  }
}
 else{
  if($isData >0){
   foreach($data as $rec){
    $arrayPostData['to'] = $id;
    $arrayPostData = array();
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = $rec->system;
    replyMsg($arrayHeader,$arrayPostData);
    
   }
  }else{
    
    $arrayPostData['to'] = $id;
    $arrayPostData = array();
    $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = 'คุณสามารถสอนให้ฉลาดได้เพียงพิมพ์: สอนบอท[คำถาม|คำตอบ]';
    $arrayPostData['messages'][1]['type'] = "text";
    $arrayPostData['messages'][1]['text'] = $id;
    replyMsg($arrayHeader,$arrayPostData);
    
  }
}
    */
function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/push";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);
      curl_close ($ch);
   }
   exit;
?>
