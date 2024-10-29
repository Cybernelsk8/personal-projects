<?php

namespace App\Providers;

use Core\Providers\ServiceProvider;
use Core\Validation\Rule;

class RuleServiceProvider implements ServiceProvider {
    public function registerServices() {
        Rule::loadDefaultRules();
    }
}