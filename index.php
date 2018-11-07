<?php
function convert($time, $format = '%02d:%02d') {
  if ($time < 1) { return; }
  $hours = floor($time / 60);
  $minutes = ($time % 60);
  return sprintf($format, $hours, $minutes);
}
function baytkod($start,$end,$type=array(),$igrone = array()){
  $startDate      = new DateTime($start);
  $endDate        = new DateTime($end);
  $periodInterval = new DateInterval( "PT1M" );
  $period         = new DatePeriod( $startDate, $periodInterval, $endDate );
  $count1 = 0;
  $count2 = 0;
  foreach($period as $date){
    if(in_array($date->format('l'), array('Sunday','Saturday')) || in_array($date->format('Y-m-d'), $igrone)){
      $startofday = clone $date;
      $startofday->setTime(explode(':',explode(' ',$start)[1])[0],explode(':',explode(' ',$start)[1])[1]);
      $endofday = clone $date;
      $endofday->setTime(explode(':',explode(' ',$end)[1])[0],explode(':',explode(' ',$end)[1])[1]);
     	$count2++;
    }else{
      $startofday = clone $date;
      $startofday->setTime($type[0],$type[1]);
      $endofday = clone $date;
      $endofday->setTime($type[2],$type[3]);
       if($date >= $startofday && $date < $endofday){
      	$count1++;
    	 }
    }
  }
  $data['count1'] = $count1;
  $data['count2'] = $count2;
  return $data;
}
$start  = '2018-10-07 15:31:00';
$end    = '2018-10-09 17:12:00';
$v1 = baytkod( $start, $end, array( "06","00", "20","00" ),array() )[count1];
$v2 = baytkod( $start, $end, array( "20","00", "23","59" ),array() )[count1];
$v3 = baytkod( $start, $end, array( "00","00", "04","00" ),array() )[count1];
$v4 = baytkod( $start, $end, array( "04","00", "06","00" ),array() )[count1];
$tatil = baytkod( $start, $end, array( "04","00", "06","00" ),array() )[count2];
echo $start.' <br>'.$end.'<br>'.'06:00--20:00 | '.convert($v1).'<br>'.'20:00--00:00 | '.convert($v2).'<br>'.'00:00--04:00 | '.convert($v3).'<br>'.'04:00--06:00 | '.convert($v4).'<br> Tatil Toplam | '.convert($tatil).' <br>Toplam : '.convert($v1+$v2+$v3+$v4+$tatil);
