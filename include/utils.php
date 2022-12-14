<?php
function generate_csrf() {
  return md5(uniqid(mt_rand(), true));
}