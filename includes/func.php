<?php
//My Helper Functions
 
function query($query){
   global $con;
 
   return mysqli_query($con, $query);
}
 
function get_row($query){
   global $con;
 
   $result = mysqli_query($con, $query);
   while($row = mysqli_fetch_array($result)){
       return $row;
   }
 
   return FALSE;
}
function get_value($query, $key) {
   $row = get_row($query);
   if(empty($row)) {
       return FALSE;
   }
 
   if(empty($row[$key])) {
       return FALSE;
   }
 
   return $row[$key];
}
 
function escape($query){
   global $con;
 
   return mysqli_real_escape_string($con, $query);
}
 
function fetch($result){
   global $con;
 
   return @mysqli_fetch_array($result);
}
function num_rows($result){
   global $con;
 
   return mysqli_num_rows($result);
}
function generateToken($n) {
   $characters = '0123456789abcdefghijklmnopqrstuvwxuz';
   $randomString = '';
  
   for ($i = 0; $i < $n; $i++) {
       $index = rand(0, strlen($characters) - 1);
       $randomString .= $characters[$index];
   }
  
   return $randomString;
}
function clean($string){
   return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
function checkEmpty($str){
 $str = strip_tags($str);
 $str = escape($str);
 $check_emty = preg_replace('/\s+/', '', $str);
 if ($check_emty != ""){
   return 0;
 }else{
   return 1;
 }
}
function timeMessage($date){
       //Timestamp
           $date_time_now = date("Y-m-d H:i:s");
           $start_date = new DateTime($date);
           $end_date = new DateTime($date_time_now);
           $interval = $start_date->diff($end_date);
 
           //Start Time calculation rules
           if($interval->y >= 1) {
                       if($interval->y == 1)
                           $time_message = $interval->y . " yr"; //1 year ago
                       else
                           $time_message = $interval->y . " yrs"; //1+ year ago
           }
           else if ($interval-> m >= 1) {
               if($interval->d == 0) {
                   $days = " ago";
               }
               else if($interval->d == 1) {
                   $days = $interval->d . " d";
               }
               else {
                   $days = $interval->d . " dys";
               }
 
 
               if($interval->m == 1) {
                   $time_message = $interval->m . " mon";
               }
               else {
                   $time_message = $interval->m . " mons";
               }
           }
           else if($interval->d >= 1) {
               if($interval->d == 1) {
                   $time_message = "Yesterday";
               }
               else {
                   $time_message = $interval->d . " d";
               }
           }
           else if($interval->h >= 1) {
               if($interval->h == 1) {
                   $time_message = $interval->h . " hr";
               }
               else {
                   $time_message = $interval->h . " hrs";
               }
           }
           else if($interval->i >= 1) {
               if($interval->i == 1) {
                   $time_message = $interval->i . " min";
               }
               else {
                   $time_message = $interval->i . " mins";
               }
           }
           else {
               if($interval->s < 30) {
                   $time_message = "Just now";
               }
               else {
                   $time_message = $interval->s . " secs";
               }
           }
           //End Time calculation Rules
           return $time_message;
}
function parseDescription($description){
   // Parse links
   $pattern
       = '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}[^\s\\\\]+/u';
 
   // Get text
   $escaped = htmlspecialchars($description, ENT_HTML5, 'UTF-8', false);
 
   // Replace
   $description = preg_replace_callback($pattern,
       static function ($matches) {
           return '<a target="_blank" class="text-blue-600 hover:text-blue-500" href="'
               .$matches[0].'">'
               .$matches[0].'</a>';
       }, $escaped);
 
   // Replace line breaks
   return str_replace("\n", '<br />', $description);
}
function tokenToUser($token){
   $check_query = query("SELECT user FROM auths WHERE token = '$token'");
   if(num_rows($check_query) > 0){
       $fetch_auth = fetch($check_query);
       return $fetch_auth['user'];
   }else{
       return false;
   }
}

