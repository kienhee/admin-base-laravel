<?php

namespace Config;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Admin
{
    public static $version_view = 1; // Tăng view mỗi khi thay đổi css or js
    /**
     * Get the admin asset URL with versioning.
     *
     * @param string $path  url assets
     * @return string
     */
    public static function asset_admin_url($path)
    {
        return asset("resources/admin/$path?ver=" . self::$version_view);
    }

    /**
     * Summary of handleSeedMigration
     * @param mixed $tableName
     * @param mixed $version
     * @param bool $isTruncate
     * @return bool
     */
    public static function SeedMigration($tableName, $version, $isTruncate = true)
    {
        if (empty($tableName) || empty($version)) {
            Log::error('Missing table name or version');
            return false;
        }

        $migrationName = "seed-{$tableName}";
        $record = DB::table('migrations')->where('migration', $migrationName)->first();

        if (!$record) {
            DB::table('migrations')->insert([
                'migration' => $migrationName,
                'batch' => $version,
            ]);
            return true;
        }

        if ($version <= $record->batch) {
            Log::error('Input version is not greater than current DB version');
            return false;
        }

        if ($isTruncate) {
            DB::table($tableName)->truncate();
        }

        DB::table('migrations')->where('migration', $migrationName)->update([
            'batch' => $version,
        ]);
        return true;
    }
}
