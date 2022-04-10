<?php

namespace App\CacheClients;

trait TestableCacheClientTrait
{
    /**
     * @return void
     */
    public function beforeTests(): void
    {
        $this->db->beginTransaction();
    }

    /**
     * @return void
     */
    public function afterTests(): void
    {
        $this->db->rollback();
    }
}