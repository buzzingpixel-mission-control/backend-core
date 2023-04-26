<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects\Persistence;

use Assert\Assert;
use MissionControlBackend\ActionResult;
use MissionControlBackend\Persistence\MissionControlPdo;
use Throwable;

use function count;
use function implode;

readonly class SaveProject
{
    public function __construct(
        private MissionControlPdo $pdo,
        private FindProjects $findProjects,
    ) {
    }

    public function save(ProjectRecord $record): ActionResult
    {
        $validationResult = $this->validateRecord($record);

        if (! $validationResult->success) {
            return $validationResult;
        }

        $statement = $this->pdo->prepare(implode(' ', [
            'UPDATE',
            $record->tableName(),
            'SET',
            $record->columnsAsUpdateSetPlaceholders(),
            'WHERE id = :id',
        ]));

        if (! $statement->execute($record->asParametersArray())) {
            return new ActionResult(
                false,
                $this->pdo->errorInfo(),
                $this->pdo->errorCode(),
            );
        }

        return new ActionResult();
    }

    private function validateRecord(ProjectRecord $record): ActionResult
    {
        $errors = [];

        try {
            Assert::that($record->title)->notEmpty(
                'Title must be provided',
            );
        } catch (Throwable $exception) {
            $errors[] = $exception->getMessage();
        }

        try {
            Assert::that($record->slug)->notEmpty(
                'Slug must be provided',
            );
        } catch (Throwable $exception) {
            $errors[] = $exception->getMessage();
        }

        $existingProject = $this->findProjects->findOneOrNull(
            (new FindProjectParameters())->withSlug(
                $record->slug,
            )->withNotId($record->id),
        );

        if ($existingProject !== null) {
            $errors[] = 'Slug must be unique';
        }

        return new ActionResult(
            count($errors) < 1,
            $errors,
        );
    }
}
