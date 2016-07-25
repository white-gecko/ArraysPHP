<?php

namespace WhiteGecko\Tests\Arrays;

use PHPUnit\Framework\TestCase;
use WhiteGecko\Arrays;

class ArrayEqualTest extends TestCase
{
    public function testEqualEmpty()
    {
        $arrayA = array();
        $arrayB = array();
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualOneEmpty()
    {
        $arrayA = array();
        $arrayB = array('b');
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualOneEmptyOneAssoc()
    {
        $arrayA = array();
        $arrayB = array('b' => 'x');
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testEqualSequential()
    {
        $arrayA = array('a', 'b', 'c', 'hello', 'z', 'y', 'x');
        $arrayB = array('z', 'hello', 'y', 'a', 'x', 'c', 'b');
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayA));
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualSequential()
    {
        $arrayA = array('a', 'b', 'c', 'hello', 'z', 'y', 'x');
        $arrayB = array('hello', 'y', 'a', 'x', 'c', 'b');
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testEqualAssoc()
    {
        $arrayA = array('a' => 'a', 'm' => 'b', 'x' => 'c', 1 => 'hello', 5 => 'z', '7' => 'y', 'hello' => 'x');
        $arrayB = array(5 => 'z', 1 => 'hello', '7' => 'y', 'a' => 'a', 'hello' => 'x', 'x' => 'c', 'm' => 'b');
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayA));
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualAssocKey()
    {
        $arrayA = array('a' => 'a', 'm' => 'b', 'x' => 'c', 1 => 'hello', 5 => 'z', '7' => 'y', 'hello' => 'x');
        $arrayB = array(5 => 'z', 1 => 'hello', '9' => 'y', 'a' => 'a', 'hello' => 'x', 'x' => 'c', 'm' => 'b');
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualAssocValue()
    {
        $arrayA = array('a' => 'a', 'm' => 'b', 'x' => 'c', 1 => 'hello', 5 => 'z', '7' => 'y', 'hello' => 'x');
        $arrayB = array(5 => 'z', 1 => 'hello', '7' => 'y', 'a' => 'a', 'hello' => 'hello', 'x' => 'c', 'm' => 'b');
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualAssocMissing()
    {
        $arrayA = array('a' => 'a', 'm' => 'b', 'x' => 'c', 1 => 'hello', 5 => 'z', '7' => 'y', 'hello' => 'x');
        $arrayB = array(5 => 'z', 1 => 'hello', '7' => 'y', 'a' => 'a', 'hello' => 'x', 'm' => 'b');
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testEqualHybrid()
    {
        $arrayA = array('a' => 'a', 'm' => 'b', 'x' => 'c', 'hello', 'z', 'y', 'x');
        $arrayB = array('z', 'hello', 'y', 'a' => 'a', 'x', 'x' => 'c', 'm' => 'b');
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayA));
        $this->markTestIncomplete("There is no solution yet for comparing the associative values separate");
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testEqualRecursiveAssocSequence()
    {
        $arrayA = array(
            'a' => array('a', 'b', 'z', 'x'),
            'x' => 'c'
        );
        $arrayB = array(
            'x' => 'c',
            'a' => array('a', 'x', 'z', 'b')
        );
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayA));
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualRecursiveAssocSequence()
    {
        $arrayA = array(
            'a' => array('a', 'z', 'x'),
            'x' => 'c'
        );
        $arrayB = array(
            'x' => 'c',
            'a' => array('a', 'x', 'z', 'b')
        );
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testEqualRecursiveSequenceAssoc()
    {
        $arrayA = array(
            array('a' => 'a', 'm' => 'b', 'x' => 'c', 1 => 'hello', 5 => 'z', '7' => 'y', 'hello' => 'x'),
            'a'
        );
        $arrayB = array(
            'a',
            array(5 => 'z', 1 => 'hello', '7' => 'y', 'a' => 'a', 'hello' => 'x', 'x' => 'c', 'm' => 'b')
        );
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayA));
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualRecursiveSequenceAssoc()
    {
        $arrayA = array(
            array('a' => 'a', 'm' => 'b', 'x' => 'c', 1 => 'hello', 5 => 'z', '7' => 'y', 'hello' => 'x'),
            'a'
        );
        $arrayB = array(
            'a',
            array(5 => 'z', 1 => 'hello', '7' => 'y', 'a' => 'a', 'tree' => 'x', 'x' => 'c', 'm' => 'b')
        );
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testEqualRecursiveSequenceOfSeqArrays()
    {
        $arrayA = array(
            array('a', 'b', 'z', 'x'),
            array('a', 'x'),
            array('y', 'z')
        );
        $arrayB = array(
            array('a', 'x'),
            array('y', 'z'),
            array('a', 'x', 'z', 'b')
        );
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayA));
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualRecursiveSequenceOfSeqArrays()
    {
        $arrayA = array(
            array('a', 'b', 'z', 'x'),
            array('a', 'x'),
            array('y', 'z')
        );
        $arrayB = array(
            array('a', 'x'),
            array('y', 'tree'),
            array('a', 'x', 'z', 'b')
        );
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testEqualRecursiveSequenceOfAssocArrays()
    {
        $arrayA = array(
            array('a' => 'a', 'm' => 'b', 'x' => 'c', 1 => 'hello', 5 => 'z', '7' => 'y', 'hello' => 'x'),
            array('a' => 'x'),
            array('y' => 'z')
        );
        $arrayB = array(
            array('a' => 'x'),
            array('y' => 'z'),
            array(5 => 'z', 1 => 'hello', '7' => 'y', 'a' => 'a', 'hello' => 'x', 'x' => 'c', 'm' => 'b')
        );
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayA));
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testEqualRecursiveSequenceOfArrays()
    {
        $arrayA = array(
            array('a' => 'a', 'm' => 'b', 'x' => 'c', 1 => 'hello', 5 => 'z', '7' => 'y', 'hello' => 'x'),
            array('a'),
            array('x', 'y', 'z'),
            array()
        );
        $arrayB = array(
            array('a'),
            array(),
            array(5 => 'z', 1 => 'hello', '7' => 'y', 'a' => 'a', 'hello' => 'x', 'x' => 'c', 'm' => 'b'),
            array('x', 'z', 'y')
        );
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayA));
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testEqualHierarchical()
    {
        $arrayA = array(
            'a' => array('a', 'b', 'z', 'x'),
            'm' => array(
                'a' => 'x',
                'z' => array('a', 'c'),
                'x' => array(array('a' => 'b'), array('c' => 'x'))
            ),
            'x' => 'c'
        );
        $arrayB = array(
            'm' => array(
                'a' => 'x',
                'x' => array(array('c' => 'x'), array('a' => 'b')),
                'z' => array('a', 'c')
            ),
            'a' => array('a', 'b', 'z', 'x'),
            'x' => 'c'
        );
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayA));
        $this->assertTrue(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }

    public function testNotEqualHierarchical()
    {
        $arrayA = array(
            'a' => array('a', 'b', 'z', 'x'),
            'm' => array(
                'a' => 'x',
                'z' => array('a', 'c'),
                'x' => array(array('a' => 'b'), array('c' => 'x'))
            ),
            'x' => 'c'
        );
        $arrayB = array(
            'm' => array(
                'a' => 'x',
                'x' => array(array('c' => 'tree'), array(), array('a' => 'b')),
                'z' => array('a', 'c')
            ),
            'a' => array('a', 'b', 'z', 'x'),
            'x' => 'c'
        );
        $this->assertFalse(Arrays\arrayRecursiveEqual($arrayA, $arrayB));
    }
}
