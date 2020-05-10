<?php

namespace SMSkin\NameComparator\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use SMSkin\NameComparator\NameComparator;

class NameComparatorTest extends TestCase
{
    public function testIsEqual()
    {
        $positive = [
            ['IDOWU','IDOWU'],
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
        $comparator = new NameComparator();
        foreach ($positive as $item) {
            $r = $comparator->isEqual($item[0],$item[1]);
            $this->assertSame( true, $r, 'Name1: '.$item[0].', Name2: '.$item[1]);
        }

        foreach ($negative as $item) {
            $r = $comparator->isEqual($item[0],$item[1]);
            $this->assertSame( false, $r, 'Name1: '.$item[0].', Name2: '.$item[1]);
        }
    }

    /**
     * @throws ReflectionException
     */
    public function testGetWordsFromName(){
        $name = 'MIKHAYLOV SERGEY SERGEEVICH';

        $comparator = new NameComparator();
        $reflector = new ReflectionClass( NameComparator::class );
        $method = $reflector->getMethod( 'getWordsFromName' );
        $method->setAccessible( true );
        $result = $method->invokeArgs( $comparator, [$name]);
        $this->assertEquals(['MIKHAYLOV','SERGEY','SERGEEVICH'], $result );
    }

    /**
     * @throws ReflectionException
     */
    public function testIsEqualStrings(){
        $comparator = new NameComparator();
        $reflector = new ReflectionClass( NameComparator::class );
        $method = $reflector->getMethod( 'isEqualStrings' );
        $method->setAccessible( true );
        $result = $method->invokeArgs( $comparator, ['IDOWU','IDOWU']);
        $this->assertSame( true, $result);

        $result = $method->invokeArgs( $comparator, ['MIKHAYLOV','SERGEY']);
        $this->assertSame( false, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testIsEqualArrays(){
        $comparator = new NameComparator();
        $reflector = new ReflectionClass( NameComparator::class );
        $method = $reflector->getMethod( 'isEqualArrays' );
        $method->setAccessible( true );

        $result = $method->invokeArgs( $comparator, [
            ['IDOWU','EBUNOLUWA'],
            ['IDOWU','EBUNOLUWA']
        ]);
        $this->assertSame( true, $result);
        $result = $method->invokeArgs( $comparator, [
            ['IDOWU','EBUNOLUWA'],
            ['EBUNOLUWA','IDOWU']
        ]);
        $this->assertSame( true, $result);
        $result = $method->invokeArgs( $comparator, [
            ['a','b'],
            ['a','c']
        ]);
        $this->assertSame( false, $result);
        $result = $method->invokeArgs( $comparator, [
            ['a','b'],
            ['c','d']
        ]);
        $this->assertSame( false, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testIsName2IsPartOfName1(){
        $comparator = new NameComparator();
        $reflector = new ReflectionClass( NameComparator::class );
        $method = $reflector->getMethod( 'isName2IsPartOfName1' );
        $method->setAccessible( true );

        $result = $method->invokeArgs( $comparator, [
            ['IDOWU','SARAH','EBUNOLUWA'],
            ['EBUNOLUWA','IDOWU']
        ]);
        $this->assertSame( true, $result);

        $result = $method->invokeArgs( $comparator, [
            ['IDOWU','SARAH','EBUNOLUWA'],
            ['EBUNOLUWA','YULIA']
        ]);
        $this->assertSame( false, $result);
    }

    /**
     * @throws ReflectionException
     */
    public function testGetMatchPercentage(){
        $comparator = new NameComparator();
        $reflector = new ReflectionClass( NameComparator::class );
        $method = $reflector->getMethod( 'getMatchPercentage' );
        $method->setAccessible( true );

        $result = $method->invokeArgs( $comparator, [
            ['IDOWU','SARAH','EBUNOLUWA'],
            ['EBUNOLUWA','IDOWU','SARAH']
        ]);
        $this->assertSame( 1.0, $result);

        $result = $method->invokeArgs( $comparator, [
            ['IDOWU','SARAH','EBUNOLUWA'],
            ['EBUNOLUWA','IDOWU']
        ]);
        $this->assertSame( 0.66666666666667, $result);

        $result = $method->invokeArgs( $comparator, [
            ['IDOWU','SARAH','EBUNOLUWA'],
            ['IDOWU']
        ]);
        $this->assertSame( 0.33333333333333, $result);

        $result = $method->invokeArgs( $comparator, [
            ['IDOWU','SARAH','EBUNOLUWA'],
            ['MIKHAYLOV']
        ]);
        $this->assertSame( 0.0, $result);

        $result = $method->invokeArgs( $comparator, [
            ['IDOWU','SARAH','EBUNOLUWA'],
            ['MIKHAYLOV', 'SERGEY']
        ]);
        $this->assertSame( 0.0, $result);
    }
}
