<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class ProcessProdcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('ProcessProdcast job started: Fetching and updating users with status = 0.');

        $userIds = User::where('status', 1)->pluck('id');

        if ($userIds->isEmpty()) {
            Log::info('No users found with status = 0.');
            return; 
        }

        // update status to 0
        User::whereIn('id', $userIds)->update(['status' => 0]);

        Log::info('ProcessProdcast job completed: Updated users with status = 1 to status = 0.', [
            'updated_user_ids' => $userIds
        ]);
    }
    }

