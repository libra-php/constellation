<?php

declare(strict_types=1);

namespace Constellation\Tests\Container;

use PHPUnit\Framework\TestCase;
use Constellation\Container\Container;

class ContainerTest extends TestCase
{
    public function testContainerCanResolve(): void
    {
        $container = new Container();
        // Note: build must be called
        $class = $container->build()->get(ContainerConcreteStub::class);
        $this->assertInstanceOf(ContainerConcreteStub::class, $class);
        $class = $container->build()->get("Constellation\Tests\Container\ContainerConcreteStub");
        $this->assertInstanceOf(ContainerConcreteStub::class, $class);
    }

    public function testContainerAlias()
    {
        $container = new Container();
        $container->setDefinitions([
            "concrete.stub" => \DI\get(ContainerConcreteStub::class)
        ]);
        $class = $container->build()->get("concrete.stub");
        $this->assertInstanceOf(ContainerConcreteStub::class, $class);
    }

    public function testContainerInstance(): void
    {
        // Build only needs to be called once for static instance
        $class = Container::getInstance()->build()->get(ContainerConcreteStub::class);
        $this->assertInstanceOf(ContainerConcreteStub::class, $class);
    }


    public function testContainerDependencyInjection(): void
    {
        $foo = Container::getInstance()->get("Constellation\Tests\Container\Foo");
        $this->assertInstanceOf(Foo::class, $foo);
        $this->assertInstanceOf(Bar::class, $foo->getBar());
        $this->assertEquals('foobar', $foo->getBarName());
    }

    public function testContainerDefinitions()
    {
        $container = Container::getInstance();

        // Test constructor (DI\create) injections
        $container->setDefinitions([
            "Constellation\Tests\Container\Animal" => \DI\create()
                ->constructor(new Dog("Bingo")),
        ]);
        // We must rebuild when the definitions change
        $animal = $container->build()->get("Constellation\Tests\Container\Animal");
        $this->assertInstanceOf(Animal::class, $animal);
        $this->assertEquals('Bingo', $animal->getAnimalName());

        // Test constructor (DI\autowire) injections
        $container->setDefinitions([
            "Constellation\Tests\Container\Animal" => \DI\autowire()
                ->constructor(new Dog("Apollo")),
        ]);
        $animal = $container->build()->get("Constellation\Tests\Container\Animal");
        $this->assertInstanceOf(Animal::class, $animal);
        $this->assertEquals('Apollo', $animal->getAnimalName());

        // Test specific method/constructor parameters
        $container->setDefinitions([
            "Constellation\Tests\Container\Dog" => \DI\autowire()
                ->constructorParameter("name", "Leroy")
                ->methodParameter("setOwner", "name", "Jimmy"),
        ]);
        $dog = $container->build()->get("Constellation\Tests\Container\Dog");
        $this->assertInstanceOf(Dog::class, $dog);
        $this->assertEquals('Leroy', $dog->getName());
        $this->assertEquals('Jimmy', $dog->getOwner());

        // Test setter/method injections
        $container->setDefinitions([
            "Constellation\Tests\Container\Dog" => \DI\autowire()
                ->method("setOwner", "Bobby")
        ]);
        $dog = $container->build()->get("Constellation\Tests\Container\Dog");
        $this->assertInstanceOf(Dog::class, $dog);
        $this->assertEquals('Bobby', $dog->getOwner());

        // Test property injections
        $container->setDefinitions([
            "Constellation\Tests\Container\Dog" => \DI\autowire()
                ->property("owner", "William")
        ]);
        $dog = $container->build()->get("Constellation\Tests\Container\Dog");
        $this->assertInstanceOf(Dog::class, $dog);
        $this->assertEquals('William', $dog->getOwner());
    }

    public function testContainerEnvironmentVariables()
    {
        $container = new Container();
        // Note: EDITOR must be nvim!
        $container->setDefinitions([
            "Constellation\Tests\Container\Dog" => \DI\autowire()
                ->constructorParameter("name", \DI\env("EDITOR", "nvim"))
        ]);
        $dog = $container->build()->get("Constellation\Tests\Container\Dog");
        $this->assertInstanceOf(Dog::class, $dog);
        $this->assertEquals('nvim', $dog->getName());
    }

    public function testContainerStringExpression()
    {
        $container = new Container();
        $container->setDefinitions([
            "dog.name" => "Ash",
            "Constellation\Tests\Container\Dog" => \DI\autowire()
                ->constructorParameter("name", \DI\string("My dog {dog.name}"))
        ]);
        $dog = $container->build()->get("Constellation\Tests\Container\Dog");
        $this->assertInstanceOf(Dog::class, $dog);
        $this->assertEquals('My dog Ash', $dog->getName());
    }
}

class ContainerConcreteStub
{
}

class Foo
{
    private $bar;
    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }
    public function getBar()
    {
        return $this->bar;
    }
    public function getBarName()
    {
        return $this->bar->getName();
    }
}

class Bar
{
    private $name = "foobar";
    public function getName()
    {
        return $this->name;
    }
}

class Animal
{
    private AnimalInterface $animal;
    public function __construct(AnimalInterface $animal)
    {
        $this->animal = $animal;
    }
    public function getAnimalName()
    {
        return $this->animal->getName();
    }
}

class Dog implements AnimalInterface
{
    public $owner;
    private $name;
    public function __construct(string $name = 'Unknown')
    {
        $this->name = $name;
        $this->owner = "Unknown";
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getOwner(): string
    {
        return $this->owner;
    }
    public function setOwner(string $name)
    {
        $this->owner = $name;
    }
}

interface AnimalInterface
{
    public function getName(): string;
    public function getOwner(): string;
    public function setOwner(string $name);
}
