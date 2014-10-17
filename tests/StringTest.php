<?php

use Utility\String;

class StringTest extends \PHPUnit_Framework_TestCase
{
    public function providerRemoveWhitespace()
    {
        return array(
            array("   &nbsp;", '&nbsp;'), // 0
            array('666  ', '666'),
            array('107, quai du docteur Dervaux,92600  ', '107,quaidudocteurDervaux,92600'),
            array('Espace  demerde', 'Espacedemerde'),
            array("On veut	garder les
                retours à la
                ligne mais pas les  espaces",
                "Onveutgarderles
retoursàla
lignemaispaslesespaces")
        );
    }

    public function providerRandString()
    {
		return array (
			array('', true, ''), // 0
			array(true, true, ''),
			array('test', true, ''),
			array(2.5, true, ''),
			array(-4, true, ''),
			array(2, false, ''), // 5
			array(12, false, ''),
			array(15, false, ''),
			array(15, false, '0123456789'),
			array(30, false, 'abc'),
			array(20, false, '012345çàé'),
			array(7, false, 'ù%3~'),
			array(50, false, 'aBcDeFgHiJkLmNoPqRsTuVwXyZ')
		);
	}

    public function providerIsPositiveInt()
    {
		return array(
			array('test', false), // 0
			array(true, false),
			array('2e4', false),
			array(-47.12, false),
			array(0, false),
			array(12.5, false), // 5
			array('471845', true),
			array(7484, true),
			array(899, true),
			array(125, true)
		);
	}

    public function providerIsNumber()
    {
		return array(
			array('test', false), // 0
			array(false, false),
			array(null, false),
			array('2e4', false),
			array('a35', false),
			array('-187417840', true), // 5
			array('471845', true),
			array(-47.12, true),
			array(7484, true),
			array(0, true),
			array(0.1818, true), // 10
			array(array('error', 'test', 'not a number'), false),
			array(array('error', 'test', 8), false),
			array(array(19,  5.2, 8.7), true),
			array(array(19, 'e7', 8.7), false)
		);
	}

    public function providerSlugify()
    {
		return array(
			array(false, null), // 0
			array(null, null),
			array(-47.12, null),
			array(7484, null),
			array(new \stdClass(), null),
			array('test', 'test'), // 5
			array('Êtes-vous fait pour être le prochain développeur de notre agence ?', 'etes-vous-fait-pour-etre-le-prochain-developpeur-de-notre-agence'),
			array('0123456789', '0123456789'),
			array('	927 • Entidad aseguradora, ¿estás preparada para combatir el fraude?', '927-entidad-aseguradora-estas-preparada-para-combatir-el-fraude'),
			array('     PMI : Qué vale su Gestión de Producción
                (GPAO) ?', 'pmi-que-vale-su-gestion-de-produccion-gpao'),
            array('', ''),
		);
	}

    /**
	 * @covers String::removeWhitespace
	 * @dataProvider providerRemoveWhitespace
	 */
    public function testRemoveWhitespace($value, $expected)
    {
        $this->assertSame($expected, String::removeWhitespace($value));
    }

    /**
	 * @covers String::randString
	 * @dataProvider providerRandString
	 */
	public function testRandString($value, $expectingFalse, $allowedChars)
    {
		if ($expectingFalse) {
			$this->assertFalse(String::randString($value));
		} else {
			if ($allowedChars) {
				$result = String::randString($value, $allowedChars);
				$this->assertRegExp('/^['.$allowedChars.']+$/', $result);
			} else {
				$result = String::randString($value);
				$this->assertRegExp('/^[a-zA-Z0-9]+$/', $result);
			}

			$this->assertEquals($value, mb_strlen($result, 'utf8'));
		}
	}

    /**
	 * @covers String::isPositiveInt
	 * @dataProvider providerIsPositiveInt
	 */
	public function testIsPositiveInt($value, $expected)
    {
		$this->assertSame($expected, String::isPositiveInt($value));
	}

    /**
	 * @covers String::isNumber
	 * @dataProvider providerIsNumber
	 */
	public function testIsNumber($strValue, $bExpected)
    {
		$this->assertSame($bExpected, String::isNumber($strValue));
	}

    /**
	 * @covers String::slugify
	 * @dataProvider providerSlugify
	 */
	public function testSlugify($strValue, $bExpected)
    {
		$this->assertSame($bExpected, String::slugify($strValue));
	}
}
