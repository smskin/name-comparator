<?php

namespace SMSkin\NameComparator\Tests;

use PHPUnit\Framework\TestCase;
use SMSkin\NameComparator\NameComparator;

class NameComparatorTest extends TestCase
{
    public function testIsEqual()
    {
        $positive = [
            ['ADLINE','ADLINE'],
            ['IDOWU EBUNOLUWA','EBUNOLUWA IDOWU'],
            ['IDOWU EBUNOLUWA','IDOWU EBUNOLUWA'],
            ['IDOWU SARAH EBUNOLUWA', 'EBUNOLUWA IDOWU'],
            ['IDOWU EBUNOLUWA SARAH', 'SARAH, EBUNOLUWA IDOWU'],
            ['OLISEMEKA ADLINE','ADLINE AGU OLISEMEKA'],
            ['IDOWU EBUNOLUWA SARAH', 'SARAH, EBUNOLUWA IDOWU SERGEEVNA']
        ];

        $negative = [
            ['ADLINE','SERGEY'],
            ['ADLINE','OLISEMEKA ADLINE'],
            ['IDOWU EBUNOLUWA','SERGEY MIKHAYLOV'],
            ['IDOWU EBUNOLUWA','MIKHAYLOV SERGEY'],
            ['IDOWU SARAH EBUNOLUWA', 'MIKHAYLOV SERGEY SERGEEVICH'],
            ['IDOWU EBUNOLUWA SARAH', 'SERGEY, SERGEEVICH MIKHAYLOV'],
        ];

        foreach ($positive as $item) {
            $r = (new NameComparator($item[0],$item[1]))->isEqual();
            $this->assertSame( true, $r, 'Name1: '.$item[0].', Name2: '.$item[1]);
        }

        foreach ($negative as $item) {
            $r = (new NameComparator($item[0],$item[1]))->isEqual();
            $this->assertSame( false, $r, 'Name1: '.$item[0].', Name2: '.$item[1]);
        }
    }
}
