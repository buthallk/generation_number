<?php

namespace Tests\Http;

use App\Entities\EntityInterface;
use App\Entities\GenerationNumber;
use App\Http\Controllers\ShowGenerationNumberController;
use App\Http\Handlers\ShowGenerationNumberHandler;
use App\Http\Responses\Request;
use App\Http\Responses\ShowGenerationNumberResponse;
use App\Repositories\GenerationNumberRepositoryInterface;
use Monolog\Test\TestCase;

class ShowGenerationNumberTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @throws \JsonException
     */
    public function testItReturnsErrorResponseIfNoGenerationNumber(): void
    {
        $request = new Request([], [], '');
        $controller = new ShowGenerationNumberController($this->getShowGenerationNumberHandler());

        $response = $controller->index($request);
        $this->assertInstanceOf(ShowGenerationNumberResponse::class, $response);

        $this->expectOutputString(
            '{"success":true,"generationNumber":null,"errors":["The field \u00abid\u00bb is required ","The field \u00abid\u00bb must be a number","Generation with id :  not found"]}'
        );

        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsErrorResponseIfGenerationNumberFound(): void
    {
        $request = new Request(['id' => 25], [], '');
        $controller = new ShowGenerationNumberController($this->getShowGenerationNumberHandler());

        $response = $controller->index($request);
        $this->assertInstanceOf(ShowGenerationNumberResponse::class, $response);

        $this->expectOutputString('{"success":true,"generationNumber":null,"errors":["Generation with id : 25 not found"]}');
        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsSuccessfulResponse(): void
    {
        $id = 1;
        $request = new Request(['id' => $id], [], '');

        $generationNumber = new GenerationNumber('123');
        $generationNumber->setId($id);

        $generationNumberRepository = $this->getGenerationNumberRepository([$generationNumber]);
        $showGenerationNumberHandler = new ShowGenerationNumberHandler($generationNumberRepository);

        $controller = new ShowGenerationNumberController($showGenerationNumberHandler);
        $response = $controller->index($request);

        $json = $response->json();

        $this->assertInstanceOf(ShowGenerationNumberResponse::class, $response);
        $this->expectOutputString('{"success":true,"generationNumber":{"id":1,"generationId":"123"},"errors":[]}');

        $response->send();
    }

    private function getShowGenerationNumberHandler(): ShowGenerationNumberHandler
    {
        $generationNumberRepository = $this->getGenerationNumberRepository([]);
        return new ShowGenerationNumberHandler($generationNumberRepository);
    }

    private function getGenerationNumberRepository(array $generationNumbers): GenerationNumberRepositoryInterface
    {
        return new class($generationNumbers) implements GenerationNumberRepositoryInterface {

            public function __construct(private readonly array $generationNumbers)
            {

            }

            public function findOneBy(array $where): ?EntityInterface
            {
                $result = null;

                /** @var GenerationNumber $generationNumber */
                foreach ($this->generationNumbers as $generationNumber)
                {
                    $id = $where['id'] ?? null;
                    $generationId = $where['generationId'] ?? null;

                    if($id == $generationNumber->getId() || $generationId == $generationNumber->getGenerationId())
                    {
                        $result = $generationNumber;
                    }
                }

                return $result;
            }
        };
    }
}