<?php

namespace SMSkin\NameComparator;

interface INameComparator
{
    public function isEqual(string $name1, string $name2): bool;
}