<?php

declare(strict_types=1);

namespace MissionControlBackend\Projects;

use MissionControlBackend\ActionResult;
use MissionControlBackend\Projects\Persistence\CreateProject;
use MissionControlBackend\Projects\Persistence\FindProjectParameters;
use MissionControlBackend\Projects\Persistence\FindProjects;
use MissionControlBackend\Projects\Persistence\ProjectRecord;
use MissionControlBackend\Projects\Persistence\SaveProject;

readonly class ProjectRepository
{
    public function __construct(
        private SaveProject $saveProject,
        private CreateProject $createProject,
        private FindProjects $findProjects,
    ) {
    }

    public function createProject(NewProject $project): ActionResult
    {
        return $this->createProject->create(
            ProjectRecord::fromNewEntity($project),
        );
    }

    public function saveProject(Project $project): ActionResult
    {
        return $this->saveProject->save(
            ProjectRecord::fromEntity($project),
        );
    }

    public function findOneById(string $id): Project
    {
        return Project::fromRecord(
            $this->findProjects->findOne(
                (new FindProjectParameters())->withId($id),
            ),
        );
    }

    public function findOneByIdOrNull(string $id): Project|null
    {
        $record = $this->findProjects->findOneOrNull(
            (new FindProjectParameters())->withId($id),
        );

        if ($record === null) {
            return null;
        }

        return Project::fromRecord($record);
    }

    public function findAll(
        FindProjectParameters|null $parameters = null,
    ): ProjectCollection {
        $records = $this->findProjects->findAll($parameters);

        /** @phpstan-ignore-next-line */
        return new ProjectCollection($records->map(
            static fn (ProjectRecord $record) => Project::fromRecord(
                $record,
            ),
        ));
    }
}
