<?php

$data = 'ALAAS/22/0001';

function iD($class)
{
  $data = 'ALAAS/22/0001';
  if ($class == 'ely') {
    $data = str_replace('ALAAS/', 'ALAAS/E/', $data);
  } elseif ($class == 'pry') {
    $data = str_replace('ALAAS/', 'ALAAS/P/', $data);
  } elseif ($class == 'jss') {
    $data = str_replace('ALAAS/', 'ALAAS/JS/', $data);
  } else {
    $data = str_replace('ALAAS/', 'ALAAS/SS/', $data);
  }

  return $data;
}

echo (iD('pry'));