<?php

namespace App\Tests\Unit\Http\Message;

use App\Http\Message\Request;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestTest
 * @package App\Tests\Unit\Http\Message
 */
class RequestTest extends TestCase
{
    /**
     * @dataProvider requestProvider
     * @param string $method
     * @param string $route
     * @param array $params
     */
    public function testGetters(string $method, string $route, array $params): void
    {
        $randomParamKey = \array_rand($params);

        $request = new Request($method, $route, $params);

        $this->assertSame($method, $request->getRequestMethod());
        $this->assertSame($route, $request->getRoute());
        $this->assertSame($params[$randomParamKey], $request->get($randomParamKey));
    }

    /**
     * @return array
     */
    public function requestProvider(): array
    {
        return [
            [Request::GET, '/', ['id' => 1]],
            [Request::POST, '/login', ['username' => 'test', 'password' => '123']],
        ];
    }
}