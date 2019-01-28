<?php

function isinstalled($package, $installedversions) {
     //bug code, clean this up   
    
    //end bug code
    global $error;
    if(stristr($package,"("))
    {
    //version checking
    $packagez=explode(" ",$package);

      if($installedversions[$packagez[0]])
       { 

          $operator=str_replace("(","",$packagez[1]);
          //installed, check version
          //bug code
          if($packagez[0]=="firmware" && ($operator=="<<" || $operator==">>"))
          {
              return true;
          }
          //end bug code
          
          $correctversion=str_replace(")","",$packagez[2]);
          if(advanced_version_compare($correctversion,$installedversions[$packagez[0]],$operator))
          {
           return true;   
          } else {
              
              return false;
          }

      } else { //not installed at all
          return false;
      }
    } else {
       //no version checking 
       if($installedversions[$package])
       {
           return true;
       } else {
           return false;
       }
    }
    
    
    
    return false;
}

function GetBetween($str, $str1, $str2) {
    $arr1 = explode($str1, $str); //BOOM!
    $arr2 = explode($str2, $arr1[1]);
    return $arr2[0];
}

function con($stringz, $needlz) {
    if (stristr($stringz, $needlz) !== false) {
        return true;
    } else {
        return false;
    }
}

function advanced_version_compare($version1, $version2, $operator) {
    $version1 = preg_replace('/\D/', '|', $version1);
    $version2 = preg_replace('/\D/', '|', $version2);
    $operator = str_replace("==", "=", str_replace("<<", "<=", str_replace(">>", ">=", $operator)));
    switch ($operator) {
        case "=":
            if ($version1 == $version2) {
                return true;
            } else {
                return false;
            }
            break;
        case ">=":
            if ($version1 == $version2) {
                return true;
            } else {
                $v1 = explode("|", $version1);
                $v2 = explode("|", $version2);
                for ($i = 0; $i < count($v1); $i++) {
                    if ($v1[i] < $v2[$i]) {
                        return true;
                    }
                }
                return false;
            }
            break;
        case "<=":
            if ($version1 == $version2) {
                return true;
            } else {
                $v1 = explode("|", $version1);
                $v2 = explode("|", $version2);
                for ($i = 0; $i < count($v1); $i++) {
                    if ($v1[i] > $v2[$i]) {
                        return true;
                    }
                }
                return false;
            }

            break;
    }
    return false;
}

?>
