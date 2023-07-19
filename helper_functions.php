<?php
if(!function_exists('scrap_url'))
{
  function scrap_url($string_of_text, $name = '')
  {
    $redirectTo = 'redirect_to.php';
    $replacedUrl = "#";
    preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $string_of_text, $result);
    if (!empty($result)) {
        # Found a link.
        $url = $result['href'][0];
        // $affiliate = parse_url($url);
        // $affiliate = ucfirst($affiliate['host']);
        $replacedUrl =  $redirectTo . '?url='. $url . '&aff=' . $name;
    }
    return preg_replace('/<a(.*)href="([^"]*)"(.*)>/','<a$1href="'.$replacedUrl.'"$3>',$string_of_text);
  }
}
