<?php

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Models\ActivityLog;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

test('database seeder creates the configured administrator', function () {
    $this->seed();

    $admin = User::where('email', 'admin@gmail.com')->first();

    expect($admin)->not->toBeNull()
        ->and($admin->name)->toBe('admin')
        ->and($admin->role)->toBe(UserRole::Admin)
        ->and(Hash::check('admin', $admin->password))->toBeTrue();
});

test('projects support members, assigned tasks, comments, and activity logs', function () {
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $owner->id]);
    $project->members()->attach($member);
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'created_by_id' => $owner->id,
        'status' => TaskStatus::Todo,
        'priority' => TaskPriority::High,
    ]);
    $task->assignees()->attach([$owner->id, $member->id]);
    $comment = Comment::factory()->create([
        'task_id' => $task->id,
        'user_id' => $member->id,
    ]);
    $activity = ActivityLog::factory()->create([
        'project_id' => $project->id,
        'user_id' => $member->id,
        'metadata' => ['source' => 'test'],
    ]);

    expect($project->owner->is($owner))->toBeTrue()
        ->and($project->members->contains($member))->toBeTrue()
        ->and($task->assignees)->toHaveCount(2)
        ->and($task->status)->toBe(TaskStatus::Todo)
        ->and($task->priority)->toBe(TaskPriority::High)
        ->and($task->comments->contains($comment))->toBeTrue()
        ->and($activity->metadata)->toBe(['source' => 'test']);
});

test('deleting a member removes assignments but preserves authored records', function () {
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $project = Project::factory()->create(['owner_id' => $owner->id]);
    $project->members()->attach($member);
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'created_by_id' => $owner->id,
    ]);
    $task->assignees()->attach($member);
    $comment = Comment::factory()->create([
        'task_id' => $task->id,
        'user_id' => $member->id,
    ]);
    $activity = ActivityLog::factory()->create([
        'project_id' => $project->id,
        'user_id' => $member->id,
    ]);

    $member->delete();

    $this->assertDatabaseMissing('project_user', [
        'project_id' => $project->id,
        'user_id' => $member->id,
    ]);
    $this->assertDatabaseMissing('task_user', [
        'task_id' => $task->id,
        'user_id' => $member->id,
    ]);
    $this->assertDatabaseHas('comments', [
        'id' => $comment->id,
        'user_id' => null,
    ]);
    $this->assertDatabaseHas('activity_logs', [
        'id' => $activity->id,
        'user_id' => null,
    ]);
});

test('a project owner cannot be deleted before ownership is transferred', function () {
    $owner = User::factory()->create();
    Project::factory()->create(['owner_id' => $owner->id]);

    expect(fn () => $owner->delete())->toThrow(QueryException::class);
    expect(User::find($owner->id))->not->toBeNull();
});
