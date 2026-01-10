<?php

namespace App\Tests\Infrastructure\UI\Http\Request\Task;

use App\Domain\Task\Enum\Difficulty;
use App\Infrastructure\UI\Http\Request\Task\TaskCreateRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskCreateRequestTest extends TestCase
{

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidator();
    }


    public function testValidDto(): void
    {
        $dto = new TaskCreateRequest(
            title: 'Test Title',
            description: 'Test Description',
            difficulty: Difficulty::EASY,
            idempotencyKey: 'idempotencyKey'
        );

        $violations = $this->validator->validate($dto);
        $this->assertCount(0, $violations);
    }


    /**
     * @throws \JsonException
     */
    public function testFromRequest()
    {
        $request = Request::create('/', 'POST', [], [], [], [], json_encode([
            'title' => 'Test Title',
            'description' => 'Test Description',
            'idempotencyKey' => '123e4567-e89b-12d3-a456-426614174000',
        ], JSON_THROW_ON_ERROR));

        $dto = TaskCreateRequest::fromRequest($request);
        $this->assertEquals('Test Title', $dto->title);
    }
}
