<?php
// a console.log for PHP
/*unction console_log($output, $with_script_tags = true) {
  $js_code = 'console.log('.json_encode($output, JSON_HEX_TAG).');';
  if ($with_script_tags) {
      $js_code = '<script>'.$js_code.'</script>';
  }
  echo $js_code;
}*/
// duration values formatter needed into create.php
function duration_formatter($post_value) {
  strlen($post_value) === 1 ? $final_value = '0'.$post_value : $final_value = $post_value;
  return $final_value;
}
?>
