<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Admin\ProjectController;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\UfRepositoryInterface;
use App\Repositories\Interfaces\EquipmentRepositoryInterface;
use App\Repositories\Interfaces\InstallationTypeRepositoryInterface;
use Mockery\MockInterface;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_returns_view()
    {
        $projectController = new ProjectController(
            Mockery::mock(ProjectRepositoryInterface::class)->named('InstallationTypeRepositoryInterface'),
            Mockery::mock(UfRepositoryInterface::class)->named('UfRepositoryInterface'),
            Mockery::mock(EquipmentRepositoryInterface::class)->named('EquipmentRepositoryInterface'),
            Mockery::mock(InstallationTypeRepositoryInterface::class)->named('InstallationTypeRepositoryInterface')
        );

        $response = $projectController->create();

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function test_create_returns_correct_view()
    {
        $projectController = new ProjectController(
            Mockery::mock(ProjectRepositoryInterface::class)->named('InstallationTypeRepositoryInterface'),
            Mockery::mock(UfRepositoryInterface::class)->named('UfRepositoryInterface'),
            Mockery::mock(EquipmentRepositoryInterface::class)->named('EquipmentRepositoryInterface'),
            Mockery::mock(InstallationTypeRepositoryInterface::class)->named('InstallationTypeRepositoryInterface')
        );

        $response = $projectController->create();

        $this->assertEquals('admin.projects.create', $response->getName());
    }

    public function test_create_passes_correct_data_to_view()
    {
        $projectRepository = Mockery::mock(ProjectRepositoryInterface::class)->named('ProjectRepositoryInterface');
        $projectRepository->shouldReceive('all')->andReturn(['client1', 'client2']);

        $ufRepository = Mockery::mock(UfRepositoryInterface::class)->named('UfRepositoryInterface');
        $ufRepository->shouldReceive('all')->andReturn(['uf1', 'uf2']);

        $equipmentRepository = Mockery::mock(EquipmentRepositoryInterface::class)->named('EquipmentRepositoryInterface');
        $equipmentRepository->shouldReceive('all')->andReturn(['equipment1', 'equipment2']);

        $installationTypeRepository = Mockery::mock(InstallationTypeRepositoryInterface::class)->named('InstallationTypeRepositoryInterface');
        $installationTypeRepository->shouldReceive('all')->andReturn(['installationType1', 'installationType2']);

        $projectController = new ProjectController(
            $projectRepository,
            $ufRepository,
            $equipmentRepository,
            $installationTypeRepository
        );

        $response = $projectController->create();

        $this->assertEquals(['clients' => ['client1', 'client2'], 'ufList' => ['uf1', 'uf2'], 'equipmentList' => ['equipment1', 'equipment2'], 'installationTypeList' => ['installationType1', 'installationType2']], $response->getData());
    }

    public function test_create_calls_all_method_on_repositories()
    {
        $projectRepository = Mockery::mock(ProjectRepositoryInterface::class)->named('ProjectRepositoryInterface');
        $projectRepository->shouldReceive('all')->once();

        $ufRepository = Mockery::mock(UfRepositoryInterface::class)->named('UfRepositoryInterface');
        $ufRepository->shouldReceive('all')->once();

        $equipmentRepository = Mockery::mock(EquipmentRepositoryInterface::class)->named('EquipmentRepositoryInterface');
        $equipmentRepository->shouldReceive('all')->once();

        $installationTypeRepository = Mockery::mock(InstallationTypeRepositoryInterface::class)->named('InstallationTypeRepositoryInterface');
        $installationTypeRepository->shouldReceive('all')->once();

        $projectController = new ProjectController(
            $projectRepository,
            $ufRepository,
            $equipmentRepository,
            $installationTypeRepository
        );

        $projectController->create();
    }

    public function test_create_handles_exceptions_thrown_by_repositories()
    {
        $projectRepository = Mockery::mock(ProjectRepositoryInterface::class)->named('ProjectRepositoryInterface');
        $projectRepository->shouldReceive('all')->andThrow(new \Exception('Test exception'));

        $ufRepository = Mockery::mock(UfRepositoryInterface::class)->named('UfRepositoryInterface');
        $ufRepository->shouldReceive('all')->andThrow(new \Exception('Test exception'));

        $equipmentRepository = Mockery::mock(EquipmentRepositoryInterface::class)->named('EquipmentRepositoryInterface');
        $equipmentRepository->shouldReceive('all')->andThrow(new \Exception('Test exception'));

        $installationTypeRepository = Mockery::mock(InstallationTypeRepositoryInterface::class)->named('InstallationTypeRepositoryInterface');
        $installationTypeRepository->shouldReceive('all')->andThrow(new \Exception('Test exception'));

        $projectController = new ProjectController(
            $projectRepository,
            $ufRepository,
            $equipmentRepository,
            $installationTypeRepository
        );

        $this->expectException(\Exception::class);

        $projectController->create();
    }

    public function testSuccessfulProjectCreation()
    {
        // Mock the project repository to return a project instance
        $projectRepository = Mockery::mock(ProjectRepositoryInterface::class);
        $projectRepository->shouldReceive('create')->andReturn(new Project());
        // Create a mock request with valid data
        $request = new StoreProjectRequest();
        $request->name = 'Test Project';
        $request->description = 'Test project description';
        $request->client_id = 1;
        $request->installation_type = 'Test installation type';
        $request->location_uf = 'SP';
        $request->equipment = ['Test equipment'];
        // Create a project controller instance with the mocked repository
        $projectController = new ProjectController($projectRepository);
        // Call the store method and assert the response
        $response = $projectController->store($request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertJsonFragment(['message' => 'Projeto cadastrado com sucesso!'], $response->getContent());
    }
    public function testFailedProjectCreationDueToDatabaseError()
    {
        // Mock the project repository to throw a QueryException
        $projectRepository = Mockery::mock(ProjectRepositoryInterface::class);
        $projectRepository->shouldReceive('create')->andThrow(new QueryException());
        // Create a mock request with valid data
        $request = new StoreProjectRequest();
        $request->name = 'Test Project';
        $request->description = 'Test project description';
        $request->client_id = 1;
        $request->installation_type = 'Test installation type';
        $request->location_uf = 'SP';
        $request->equipment = ['Test equipment'];
        // Create a project controller instance with the mocked repository
        $projectController = new ProjectController($projectRepository);
        // Call the store method and assert the response
        $response = $projectController->store($request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertJsonFragment(['message' => 'Erro ao cadastrar o projeto.'], $response->getContent());
    }
    public function testFailedProjectCreationDueToInternalServerError()
    {
        // Mock the project repository to throw a Throwable
        $projectRepository = Mockery::mock(ProjectRepositoryInterface::class);
        $projectRepository->shouldReceive('create')->andThrow(new Throwable());
        // Create a mock request with valid data
        $request = new StoreProjectRequest();
        $request->name = 'Test Project';
        $request->description = 'Test project description';
        $request->client_id = 1;
        $request->installation_type = 'Test installation type';
        $request->location_uf = 'SP';
        $request->equipment = ['Test equipment'];
        // Create a project controller instance with the mocked repository
        $projectController = new ProjectController($projectRepository);
        // Call the store method and assert the response
        $response = $projectController->store($request);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertJsonFragment(['message' => 'Erro ao cadastrar o projeto.'], $response->getContent());
    }

    public function test_update_project_success()
    {
        // Mock the project repository to return a project instance
        $projectRepository = Mockery::mock(ProjectRepository::class);
        $projectRepository->shouldReceive('findById')->andReturn(new Project());
        $projectRepository->shouldReceive('update')->andReturn(new Project());
        // Create a request instance with validated data
        $request = new Request(['name' => 'Test Project']);
        // Create a project instance
        $project = new Project();
        // Call the update method
        $response = $this->controller->update($request, $project);
        // Assert the response is a JSON response with the updated project data
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('Projeto atualizado com sucesso!', $response->getData()->message);
    }
    public function test_project_not_found()
    {
        // Mock the project repository to return null
        $projectRepository = Mockery::mock(ProjectRepository::class);
        $projectRepository->shouldReceive('findById')->andReturn(null);
        // Create a request instance with validated data
        $request = new Request(['name' => 'Test Project']);
        // Create a project instance
        $project = new Project();
        // Call the update method
        $response = $this->controller->update($request, $project);
        // Assert the response is a JSON response with a 404 error message
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals('Projeto não foi encontrado.', $response->getData()->message);
    }
    public function test_update_failure_with_query_exception()
    {
        // Mock the project repository to throw a QueryException
        $projectRepository = Mockery::mock(ProjectRepository::class);
        $projectRepository->shouldReceive('update')->andThrow(new QueryException());
        // Create a request instance with validated data
        $request = new Request(['name' => 'Test Project']);
        // Create a project instance
        $project = new Project();
        // Call the update method
        $response = $this->controller->update($request, $project);
        // Assert the response is a JSON response with an error message and a 422 status code
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertEquals('Erro ao editar o projeto.', $response->getData()->message);
    }
    public function test_update_failure_with_other_exception()
    {
        // Mock the project repository to throw a Throwable exception
        $projectRepository = Mockery::mock(ProjectRepository::class);
        $projectRepository->shouldReceive('update')->andThrow(new Throwable());
        // Create a request instance with validated data
        $request = new Request(['name' => 'Test Project']);
        // Create a project instance
        $project = new Project();
        // Call the update method
        $response = $this->controller->update($request, $project);
        // Assert the response is a JSON response with an error message and a 500 status code
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertEquals('Erro ao editar o projeto.', $response->getData()->message);
    }


    /**
     * @test
     */
    public function test_destroy_project_found_and_deleted_successfully()
    {
        // Arrange
        $projectId = 1;
        $project = new \App\Models\Project();
        $this->projectRepository->shouldReceive('findById')->with($projectId)->andReturn($project);
        $this->projectRepository->shouldReceive('delete')->with($project);
        // Act
        $response = $this->projectController->destroy($projectId);
        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.projects.index'), $response->getTargetUrl());
        $this->assertEquals('Projeto excluido com sucesso!', session('success'));
    }
    /**
     * @test
     */
    public function test_destroy_project_not_found()
    {
        // Arrange
        $projectId = 1;
        $this->projectRepository->shouldReceive('findById')->with($projectId)->andReturn(null);
        // Act
        $response = $this->projectController->destroy($projectId);
        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('admin.projects.index'), $response->getTargetUrl());
        $this->assertEquals('Projeto não encontrado.', session('error'));
    }
    /**
     * @test
     */
    public function test_destroy_deletion_fails_with_an_exception()
    {
        // Arrange
        $projectId = 1;
        $project = new \App\Models\Project();
        $this->projectRepository->shouldReceive('findById')->with($projectId)->andReturn($project);
        $this->projectRepository->shouldReceive('delete')->with($project)->andThrow(new \Exception('Deletion failed'));
        // Act
        $response = $this->projectController->destroy($projectId);
        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertEquals('Erro ao remover o projeto.', $response->getData()->message);
    }
}
