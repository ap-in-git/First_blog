<?php
function redirect_to($location="") {
    if($location!=NULL)
    { header("location:{$location}");}
    }
    
function output_message($message="") {
    if(!empty($message)){
       return "<div class=\"message\">{$message}</div>";
    }else{
        return "<div class=\"message\"></div>";
    }
}

function __autoload($classname){
        $classname= strtolower($classname);
        $path= LIB_PATH.DS."{$classname}.php";
        if($path){
            require_once("$path");
        }else{
            die("the file {$classname}.php could not be found");
        }
        
       }
       
function include_layout_template($template=""){
           include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);}
    
 
  function limit_text($text, $len) {
        if (strlen($text) < $len) {
            return $text;
        }
        $text_words = explode(' ', $text);
        $out = null;


        foreach ($text_words as $word) {
            if ((strlen($word) > $len) && $out == null) {

                return substr($word, 0, $len) . "...";
            }
            if ((strlen($out) + strlen($word)) > $len) {
                return $out . "...";
            }
            $out.=" " . $word;
        }
        return $out;
    }
function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

