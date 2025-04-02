<?php
namespace App\Traits;
use Illuminate\Support\Facades\Route;
trait WithEditUrl
{
    public function getEditUrlAttribute() {
        return Route::has("dashboard.{$this->getTable()}.edit") ? route("dashboard.{$this->getTable()}.edit", $this) : null;
    }
}
