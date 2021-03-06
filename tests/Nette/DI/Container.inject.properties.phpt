<?php

/**
 * Test: Nette\DI\ContainerBuilder and injection into properties.
 *
 * @author     David Grudl
 * @package    Nette\DI
 */

use Nette\DI;



require __DIR__ . '/../bootstrap.php';



class Test1
{
	/** @inject @var stdClass */
	public $varA;

	/** @var stdClass @inject */
	public $varB;

}

class Test2 extends Test1
{
	/** @var stdClass @inject */
	public $varC;

}



$builder = new DI\ContainerBuilder;
$builder->addDefinition('one')
	->setClass('stdClass');


// run-time
$code = implode('', $builder->generateClasses());
file_put_contents(TEMP_DIR . '/code.php', "<?php\n$code");
require TEMP_DIR . '/code.php';

$container = new Container;

$test = new Test2;
$container->callInjects($test);
Assert::true( $test->varA instanceof stdClass );
Assert::true( $test->varB instanceof stdClass );
Assert::true( $test->varC instanceof stdClass );
