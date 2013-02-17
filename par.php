<?php
	header('Content-type: text/html; charset=utf-8');
    include_once('config.php');

vk_parse_wall();

/*
  Категории:
  1. Цитаты / Анекдоты
  2. Юмор
*/

//Вадик Лошар! АХАХА! =)

function vk_parse_wall(){
        
        $postCount = 150;         // Сколько постов парсить
        $groups = getGroups();    // Получаем группы
        $gCount = count($groups); // Получаем количество групп       
               
        for($l = 0; $l < $gCount; $l++){
             $postsOnGroup = $postCount / $gCount;  				// Узнаем сколько постов парсить из каждоый группы   
             $page = file_get_contents(trim($groups[$l]['url']));   // Получаем страничку 
             $mcount = countPostsInGroup($page);  					// Количество постов в группе
                         
             if($groups[$l]['parsed_count'] < ($mcount - 100)) {
                $offset = $mcount - $groups[$l]['parsed_count'];
                                               
                for($k = $postsOnGroup; $k > 0; $k = $k - 10){ 
                    $thisPage = file_get_contents(trim(''.$groups[$l]['url'].'?offset='.$offset.''));
                    preg_match_all('/class="cc">(.*)class="links[\n]*/Us',$thisPage,$firstContent);
                    
                                         
                    $countCc = count($firstContent);
                    
                    echo $countCc;
                                        
                for($h = 0; $h < $countCc; $h++){
                    
                    preg_match_all('/class="like i"><i><\/i><b>(.*)<\/b>[\n]*/Us',$firstContent[1][$h],$content1);
                           
                           if($content1[1][0] > 30) { 
                            
                             preg_match_all('/<div class="text">(.*)<\/div>[\n]*/Us',$firstContent[1][$h],$content);
                             
                             if(isset($content[1][0])){                               
                                
                             echo $content[1][0];
                             echo ' - ';
                             echo $content1[1][0];
                             echo ' - '.$groups[$l]['url'].'?offset='.$offset.'';
                             echo '<br />';                      
                                
                                
                             }

                            
                           }
 
		
	} 
                   $offset = $offset - 10;
                }
                
             }
             
                     
             
        } 	
}

function getGroups(){
  $sql = mysql_query('SELECT * FROM `groups`');
  if($sql && mysql_num_rows($sql) > 0){
   $count = mysql_num_rows($sql);
   $groups = array();
   
   for($i = 0; $i < $count; $i++){
    $result = mysql_fetch_array($sql);
    $groups[$i]['url']    = $result['group_url'];
    $groups[$i]['cat']    = $result['cat'];
    $groups[$i]['parsed_count'] = $result['parsed_count'];
   }
   
   return $groups;
  }
}

function countGroups(){
     $res = mysql_query("SELECT COUNT(*) FROM table_name");
     $row = mysql_fetch_row($res);
     $total = $row[0];
     return $total;
}


function countPostsInGroup($page){
    
        preg_match_all('/<h4><span>(.*) posts/',$page,$mcount);
        $mcount[1][0] = str_replace(',','',$mcount[1][0]);
        return $mcount[1][0];
        
}


function ccc(){
    
            $pa = 'http://vk.com/victoria_anne';
	

		
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    	preg_match_all('/<div class="cc">(.*)<\/div>[\n]*<div class="info">/Us',$page,$content);
		//print_r($content);
		$countMsg = count($content[1]);
		
		for($i = 0; $i < $countMsg; $i++){//echo $content[1][$i];
			//$all[1][$i] = iconv('Windows-1251','UTF-8',$all[1][$i]);
			preg_match_all('/<img src="[^"]+" data-photo="([^|]+)|[0-9|]+" \/>/', $content[1][$i],$photos); //echo $photos[1][0];
			preg_match_all('/<div class="text">(.*)/', $content[1][$i],$all);  
			$all[1][0] = str_replace('<a class="wall_post_more" onclick="hide(this, this.previousSibling);show(this.nextSibling);return false;">', '', $all[1][0]);
			$all[1][0] = str_replace('Показать полностью..</a>', '', $all[1][0]);
			$all[1][0] = str_replace('style="display: none"', '', $all[1][0]);
			$all[1][0] = str_replace('&#33;', '', $all[1][0]);
			$all[1][0] = str_replace('&quot;', '', $all[1][0]);
			$all[1][0] = str_replace('&#036;', '', $all[1][0]);
			$all[1][0] = str_replace('&#092;', '', $all[1][0]);
			$all[1][0] = str_replace('<br>', ' ', $all[1][0]);
			//$all[1][$i] = iconv('UTF-8','Windows-1251',$all[1][$i]);
			$all[1][0] = preg_replace('/[^\^]+Expand text../', '', $all[1][0]);
			preg_match_all('/<img src="(.*)" [^>]+>/Us',$all[1][0],$images);
			$all[1][0] = strip_tags($all[1][0]);
			//print_r($images);
			$countImages = count($images[1]);
			for($k = 0; $k < $countImages; $k++){
				 $all[1][0] = '<img src=\"'.$images[1][$k].'\">'.$all[1][0];
			}
			
			$allText = '<img src=\"'.$photos[1][0].'\"><br>'.$all[1][0];
			(isset($photos[1][0]) && $photos[1][0] != '') ? $allText = '<img src=\"'.$photos[1][0].'\"><br>'.$all[1][0] : $allText = $all[1][0];
			//echo $allText.'<br>';
			
			$checkContent = checkContent($allText);
			//print_r($checkContent);
			if($checkContent['COUNT(*)'] <= 0){
				$user = selectUser();
				$date = random_date();
				$action = '<a href="'.SITE_ADR.'members/'.$user['user_nicename'].'/" title="'.$user['display_name'].'">'.$user['display_name'].'</a> добавил(а) запись';
				$actionDB = '<a href=\"'.SITE_ADR.'members/'.$user['user_nicename'].'/\" title=\"'.$user['display_name'].'\">'.$user['display_name'].'</a> добавил(а) запись';
				$primatyLink = SITE_ADR.'members/'.$user['user_nicename'].'/';
				$sql = mysql_query('INSERT INTO `wp_bp_activity` (`user_id`,`component`,`type`,`action`,`content`,`primary_link`,`date_recorded`)
				VALUES ('.$user['ID'].',"activity","activity_update","'.$actionDB.'","'.$allText.'", "'.$primatyLink.'","'.$date.'") ');
				//echo mysql_error();
			} 
			
		} 
		//print_r($all[1]);
			#Выставляем задержку
			$sec = rand(19000,21000);
			usleep($sec*100); 
    
}

?>