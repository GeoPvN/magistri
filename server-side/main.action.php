<?php
require_once('../includes/classes/core.php');
$action = $_REQUEST['act'];
$error	= '';
$data	= '';

switch ($action) {
	case 'incomming_call':
        $incomming_call_day = mysql_query(" SELECT 	COUNT(*) AS `day_count`,
                                                    DATE(call_datetime) AS `day`
                                            FROM 	`asterisk_incomming`
                                            WHERE  DATE(`call_datetime`) > DATE_ADD(DATE(NOW()), INTERVAL -7 DAY)
                                            AND    DATE(`call_datetime`) <= DATE(NOW())
                                            AND    disconnect_cause in (2,3,4)
                                            GROUP BY DATE(call_datetime)
                                            ORDER BY DATE(call_datetime) ASC");
        
        while ($incomming_call_day_res = mysql_fetch_assoc($incomming_call_day)){
            $record[] = intval($incomming_call_day_res[day_count]);
            $data['incomming_call_day_date'][] = $incomming_call_day_res[day];
        }
        
        
        $incomming_call_day_now = mysql_fetch_array(mysql_query("  SELECT 	COUNT(*) AS `day_count`,
                                                                            DATE(call_datetime) AS `day`
                                                                    FROM 	`asterisk_incomming`
                                                                    WHERE  DATE(`call_datetime`) = DATE(NOW())
                                                                    AND    disconnect_cause in (2,3,4)"));
        if($incomming_call_day_now[0] == ''){$day_now = 0;}else{$day_now = $incomming_call_day_now[0];}
        $data['incomming_call_day_now'][] = $day_now;
        $data['incomming_call_day'][] = (object)array('name'=>'');
        $data['incomming_call_day'][] = (object)array('data'=>$record);
        break;
    case 'outgoing_call':
        $outgoing_call_day = mysql_query("  SELECT 	COUNT(*) AS `day_count`,
                                                    DATE(call_datetime) AS `day`
                                            FROM 	`asterisk_outgoing`
                                            WHERE   DATE(`call_datetime`) > DATE_ADD(DATE(NOW()), INTERVAL -7 DAY)
                                            AND 	DATE(`call_datetime`) <= DATE(NOW()) AND LENGTH(phone) != 3
                                            GROUP BY DATE(call_datetime)
                                            ORDER BY DATE(call_datetime) ASC");
        
        while ($outgoing_call_day_res = mysql_fetch_assoc($outgoing_call_day)){
            $record[] = intval($outgoing_call_day_res[day_count]);
            $data['outgoing_call_day_date'][] = $outgoing_call_day_res[day];
        }
        
        $outgoing_call_day_now = mysql_fetch_array(mysql_query("  SELECT 	COUNT(*) AS `day_count`,
                                                        DATE(call_datetime) AS `day`
                                                FROM 	`asterisk_outgoing`
                                                WHERE   DATE(`call_datetime`) = DATE(NOW())
                                                AND LENGTH(phone) != 3"));
        if($outgoing_call_day_now[0] == ''){$day_now = 0;}else{$day_now = $outgoing_call_day_now[0];}
        $data['outgoing_call_day_now'][] = $day_now;
        $data['outgoing_call_day'][] = (object)array('name'=>'');
        $data['outgoing_call_day'][] = (object)array('data'=>$record);
        break;
 	case 'inner_call' :
 	    $inner_call_day = mysql_query(" SELECT 	COUNT(*) AS `day_count`,
                                    			DATE(call_datetime) AS `day`
                                        FROM 	`asterisk_outgoing`
                                        WHERE   DATE(`call_datetime`) > DATE_ADD(DATE(NOW()), INTERVAL -7 DAY)
                                        AND 	DATE(`call_datetime`) <= DATE(NOW()) AND LENGTH(phone) = 3
                                        GROUP BY DATE(call_datetime)
                                        ORDER BY DATE(call_datetime) ASC");
 	    
 	    while ($inner_call_day_res = mysql_fetch_assoc($inner_call_day)){
 	        $record[] = intval($inner_call_day_res[day_count]);
 	        $data['inner_call_day_date'][] = $inner_call_day_res[day];
 	    }
 	    
 	    $inner_call_day_now = mysql_fetch_array(mysql_query(" SELECT 	COUNT(*) AS `day_count`,
                                    			DATE(call_datetime) AS `day`
                                        FROM 	`asterisk_outgoing`
                                        WHERE   DATE(`call_datetime`) = DATE(NOW())
                                        AND LENGTH(phone) = 3"));
 	    if($inner_call_day_now[0] == ''){$day_now = 0;}else{$day_now = $inner_call_day_now[0];}
 	    $data['inner_call_day_now'][] = $day_now;
 	    $data['inner_call_day'][] = (object)array('name'=>'');
 	    $data['inner_call_day'][] = (object)array('data'=>$record);
        break;
    case 'answer_unanswer':
        $answer_unanswer = mysql_query("  SELECT 'ნაპასუხები' AS `answer`,COUNT(*) AS `answer_count`
                                                            FROM `asterisk_incomming`
                                                            WHERE disconnect_cause in (3,4)
                                                            AND   NOT ISNULL(disconnect_cause)
                                                            AND   DATE(`call_datetime`) = DATE(NOW())
                                                            UNION ALL
                                                            SELECT 'უპასუხო' AS `unanswer`,COUNT(*) AS `answer_count`
                                                            FROM `asterisk_incomming`
                                                            WHERE disconnect_cause = 2
                                                            
                                                            AND   DATE(`call_datetime`) = DATE(NOW())");
        while($res = mysql_fetch_assoc($answer_unanswer)){
            $count[] = intval($res[answer_count]);
        }
        
        $answer_unanswer_today = mysql_query("  SELECT 'ნაპასუხები' AS `answer`,COUNT(*) AS `answer_count`
                                                FROM `asterisk_incomming`
                                                WHERE disconnect_cause in (3,4)
                                                AND    NOT ISNULL(disconnect_cause)
                                                AND   DATE(`call_datetime`) = DATE(NOW())
                                                UNION ALL
                                                SELECT 'უპასუხო' AS `unanswer`,COUNT(*) AS `answer_count`
                                                FROM `asterisk_incomming`
                                                WHERE disconnect_cause = 2
                                                AND   DATE(`call_datetime`) = DATE(NOW())");
        while($res_today = mysql_fetch_assoc($answer_unanswer_today)){
            $count_today[] = intval($res_today[answer_count]);
        }
        $data['answer_unanswer'][] = array('name'=>'ზარი','data'=>array(array('ნაპასუხები', $count[0]),array('უპასუხო', $count[1])));
        $data['answer_unanswer_today'] = array('ans'=>$count_today[0],'unans'=>$count_today[1]);
        break;
    case 'sl':
        $sl_content = mysql_fetch_assoc(mysql_query("SELECT 	`sl_min`,
                                                				`sl_procent`
                                                     FROM 		`sl_content`"));
        $sl = mysql_fetch_assoc(mysql_query("SELECT     
                                    					ROUND((SUM(IF(asterisk_incomming.wait_time<$sl_content[sl_min], 1, 0)) / COUNT(*) ) * 100) AS `percent`,
                                    					COUNT(asterisk_incomming.wait_time ) AS `num`
                                             FROM       `asterisk_incomming`
                                             WHERE      DATE(asterisk_incomming.call_datetime) = DATE(NOW()) AND asterisk_incomming.disconnect_cause in (3,4)"));
        $data['sl']['min'] = $sl_content['sl_min'];
        $data['sl']['percent'] = $sl['percent'];
        $data['sl']['sl_procent'] = $sl_content['sl_procent'];
        break;
    case 'asa':
        $asa = mysql_fetch_assoc(mysql_query("  SELECT  TIME_FORMAT(SEC_TO_TIME(AVG(asterisk_incomming.wait_time)),'%i:%s') AS `wait_time_avg`,
                                        				TIME_FORMAT(SEC_TO_TIME(MIN(asterisk_incomming.wait_time)),'%i:%s') AS `wait_time_min`,
                                        				TIME_FORMAT(SEC_TO_TIME(MAX(asterisk_incomming.wait_time)),'%i:%s') AS `wait_time_max`
                                                FROM    `asterisk_incomming`
                                                WHERE   DATE(asterisk_incomming.datetime) = DATE(NOW())
                                                AND     asterisk_incomming.duration > 0"));
        $data['asa']['wait_time_avg'] = $asa['wait_time_avg'];
        $data['asa']['wait_time_min'] = $asa['wait_time_min'];
        $data['asa']['wait_time_max'] = $asa['wait_time_max'];
        break;
    case 'hold_avg_time':
        $hold_avg = mysql_fetch_assoc(mysql_query(" SELECT  TIME_FORMAT(SEC_TO_TIME(AVG(asterisk_incomming.wait_time)),'%i:%s') AS `wait_time_avg`,
                                            				TIME_FORMAT(SEC_TO_TIME(MIN(asterisk_incomming.wait_time)),'%i:%s') AS `wait_time_min`,
                                            				TIME_FORMAT(SEC_TO_TIME(MAX(asterisk_incomming.wait_time)),'%i:%s') AS `wait_time_max`
                                                    FROM    `asterisk_incomming`
                                                    WHERE   DATE(asterisk_incomming.datetime) = DATE(NOW())"));
        $data['hold_avg_time']['wait_time_avg'] = $hold_avg['wait_time_avg'];
        $data['hold_avg_time']['wait_time_min'] = $hold_avg['wait_time_min'];
        $data['hold_avg_time']['wait_time_max'] = $hold_avg['wait_time_max'];
        break;
    case 'live_operators':
        $in_busy = mysql_fetch_assoc(mysql_query("  SELECT COUNT(*) AS `in_busy`
                                                    FROM `asterisk_incomming`
                                                    WHERE DATE(asterisk_incomming.datetime) = DATE(NOW())
                                                    AND asterisk_incomming.disconnect_cause = 1
                                                    AND NOT ISNULL(dst_extension)"));
        $data['live_operators'][] = array('name'=>'თავის','data'=>array((4-intval($in_busy[in_busy]))));
        $data['live_operators'][] = array('name'=>'დაკავ','data'=>array(intval($in_busy[in_busy])));
        $data['live_operators'][] = array('name'=>'გამორთ','data'=>array(0));
        break;
    case 'live_calls':
        $in_talk = mysql_fetch_assoc(mysql_query("  SELECT COUNT(*) AS `in_talk`
                                                    FROM `asterisk_incomming`
                                                    WHERE DATE(asterisk_incomming.datetime) = DATE(NOW())
                                                    AND asterisk_incomming.disconnect_cause = 1
                                                    AND NOT ISNULL(dst_extension)"));
        $in_queue = mysql_fetch_assoc(mysql_query(" SELECT COUNT(*) AS `in_queue`
                                                    FROM `asterisk_incomming`
                                                    WHERE DATE(asterisk_incomming.datetime) = DATE(NOW())
                                                    AND ISNULL(asterisk_incomming.disconnect_cause)
                                                    AND ISNULL(dst_extension)"));
        
        $data['live_calls']['in_talk'] = $in_talk['in_talk'];
        $data['live_calls']['in_queue'] = $in_queue['in_queue'];
        break;
    case 'operator_answer':
        $operator = mysql_query("   SELECT  asterisk_incomming.dst_extension AS `name`,
                                            '0.jpg' AS `image`,
                                            COUNT(*) AS `ans`
                                    FROM `asterisk_incomming`
                                    WHERE DATE(asterisk_incomming.datetime) = DATE(NOW())
                                    AND asterisk_incomming.duration > 0
                                    GROUP BY asterisk_incomming.dst_extension");
        $ope = '<div class="row header">
                  <div class="cell">
                    ოპერატორი
                  </div>
                  <div class="cell" style="width: 95px;">
                    ნაპასუხები ზარი
                  </div>
                  
                </div>';
        while ($operator_res = mysql_fetch_assoc($operator)){
            $ope.='<div class="row">
                            <div class="cell">
                            <div style="width: 24px; height: 24px; background: url(\'media/uploads/file/'.$operator_res[image].'\');background-size: 24px 24px; background-repeat: no-repeat; float: left;"></div> <div style="margin-top: 5px; margin-left: 5px; float: left;">'.$operator_res[name].'</div>
                            </div>
                            <div class="cell align_right">
                            '.$operator_res[ans].'
                            </div>
                            </div>';
        }
        $data['operator_answer']=$ope;
        break;
    case 'operator_answer_dur':
        $operator_avg = mysql_query("   SELECT  asterisk_incomming.dst_extension AS `name`,
                                                '0.jpg' AS `image`,
                                                SEC_TO_TIME(SUM(asterisk_incomming.duration)) AS `total_duration`,
    				                            SEC_TO_TIME(AVG(asterisk_incomming.duration)) AS `duration_avg`
                                        FROM `asterisk_incomming`
                                        WHERE DATE(asterisk_incomming.datetime) = DATE(NOW())
                                        AND asterisk_incomming.duration > 0
                                        GROUP BY asterisk_incomming.dst_extension");
        $ope_avg = '<div class="row header">
                      <div class="cell">
                        ოპერატორი
                      </div>
                      <div class="cell" style="width: 75px;">
                        საუბ. ხ-ბა.
                      </div>
                      <div class="cell" style="width: 81px;">
                        საუბ. საშ. ხ-ბა
                      </div>
                    </div>';
        while ($operator_avg_res = mysql_fetch_assoc($operator_avg)){
            $ope_avg.='<div class="row">
                            <div class="cell">
                            <div style="width: 24px; height: 24px; background: url(\'media/uploads/file/'.$operator_avg_res[image].'\');background-size: 24px 24px; background-repeat: no-repeat; float: left;"></div> <div style="margin-top: 5px; margin-left: 5px; float: left;">'.$operator_avg_res[name].'</div>
                            </div>
                            <div class="cell align_right">
                            '.$operator_avg_res[total_duration].'
                            </div>
                            <div class="cell align_right">
                            '.$operator_avg_res[duration_avg].'
                            </div>
                            </div>';
        }
        $data['operator_answer_dur']=$ope_avg;
        break;
    default:
       $error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

?>
