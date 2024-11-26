<?php

namespace App\Services;

use App\Repositories\Interfaces\ConfigRepositoryInterface;
use App\Services\Interfaces\ConfigServiceInterface;

class ConfigService implements ConfigServiceInterface
{
    // private $configRepository;
    public function __construct(
        protected ConfigRepositoryInterface $configRepository
    ) {
        // $this->configRepository = $configRepository;
    }

    public function getDiscountCondition()
    {
        $config = $this->configRepository->getByName('discount_condition');
        $condition = json_decode($config->data);
        return $condition;
    }
}
