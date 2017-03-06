<?php

class Role extends \HXPHP\System\Model{
  static $has_many = array(
    array('users')
  );
}
