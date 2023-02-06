<?php

namespace boompearl\phpmvc;

use boompearl\phpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}