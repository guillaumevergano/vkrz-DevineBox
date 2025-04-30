<?php
function createSlug($str)
{
  $str = removeEmoji($str);
  $str = mb_strtolower($str, 'UTF-8'); // Convert to lower case
  $str = preg_replace('/\s+/', '-', $str); // Replace spaces with -
  $str = preg_replace('/[^a-z0-9\-àáâãäåçèéêëìíîïðòóôõöùúûüýÿ]+/u', '', $str);
  $str = preg_replace('/\-\-+/', '-', $str); // Replace multiple - with single -
  $str = preg_replace('/^-+/', '', $str); // Trim - from start of text
  $str = preg_replace('/-+$/', '', $str); // Trim - from end of text
  return $str;
}

function removeAccents($str)
{
  $str = Normalizer::normalize($str, Normalizer::FORM_D);
  $str = preg_replace('/\p{Mn}/u', '', $str);

  return $str;
}

function removeEmoji($string)
{
  // Match Emoticons
  $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
  $clean_text = preg_replace($regexEmoticons, '', $string);

  // Match Miscellaneous Symbols and Pictographs
  $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
  $clean_text = preg_replace($regexSymbols, '', $clean_text);

  // Match Transport And Map Symbols
  $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
  $clean_text = preg_replace($regexTransport, '', $clean_text);

  // Match Miscellaneous Symbols
  $regexMisc = '/[\x{2600}-\x{26FF}]/u';
  $clean_text = preg_replace($regexMisc, '', $clean_text);

  // Match Dingbats
  $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
  $clean_text = preg_replace($regexDingbats, '', $clean_text);

  return $clean_text;
}
