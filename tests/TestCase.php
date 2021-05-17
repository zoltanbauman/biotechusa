<?php
namespace Tests;

use Exception;
use phpmock\Mock;
use phpmock\MockBuilder;
use PHPUnit\Framework\TestCase as UnitTestCase;

abstract class TestCase extends UnitTestCase
{
    protected function getDateMocker($namespace, $dateText = '2021-05-22 10:00:00'): Mock
    {
        $builder = new MockBuilder();
        $builder->setNamespace($namespace)
            ->setName('date')
            ->setFunction(
                function() use ($dateText) {
                    return $dateText;
                }
            );
        $dateMock = $builder->build();
        try {
            $dateMock->enable();
        } catch (Exception $e) {
            $dateMock->disable();
            $dateMock->enable();
        }

        return $dateMock;
    }

}