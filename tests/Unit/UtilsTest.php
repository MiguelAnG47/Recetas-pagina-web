<?php

namespace Tests\Unit;

use Tests\TestCase;

class UtilsTest extends TestCase
{
    public function test_formatear_lista()
    {
        $controller = new \App\Http\Controllers\SolicitudController();

        $this->assertEquals(
            'pollo, arroz',
            $this->invokeMethod($controller, 'formatearLista', [['pollo', 'arroz']])
        );
    }

    private function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
