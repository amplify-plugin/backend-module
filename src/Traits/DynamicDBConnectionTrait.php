<?php

namespace Amplify\System\Backend\Traits;

trait DynamicDBConnectionTrait
{
    /**
     * Get the name of the database connection for the model.
     *
     * This allows switchover between the primary/default connection
     * and a secondary “PIM” database at runtime.
     *
     * @return string|null
     *                     - 'pim_db' if `config('amplify.pim.pim_db_enabled')` is true.
     *                     - otherwise whatever the parent model’s getConnectionName()
     *                     returns (or null to use the default connection).
     */
    public function getConnectionName()
    {
        // If PIM database integration is enabled in config, use that.
        if (config('amplify.pim.pim_db_enabled')) {
            return 'pim_db';
        }

        // Otherwise defer to parent (or default).
        return parent::getConnectionName();
    }
}
