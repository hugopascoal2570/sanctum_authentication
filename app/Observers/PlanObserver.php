<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Plan;

class PlanObserver
{

    public function creating(Plan $plan)
    {
        $plan->url = Str::kebab($plan->name);
    }

    public function updating(Plan $plan)
    {
        $plan->url = Str::kebab($plan->name);
    }

    public function created(Plan $plan): void
    {
        //
    }

    public function updated(Plan $plan): void
    {
        //
    }

    public function deleted(Plan $plan): void
    {
        //
    }

    public function restored(Plan $plan): void
    {
        //
    }

    public function forceDeleted(Plan $plan): void
    {
        //
    }
}
