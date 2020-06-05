<?php

namespace Different\Dwfw\tests\Unit\Models;

use App\Models\User;
use Backpack\Settings\app\Models\Setting;
use Different\Dwfw\app\Models\Log;
use Different\Dwfw\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class SettingObserverTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->create());
        Artisan::call('db:seed', [
            '--class' => 'Different\\Dwfw\\database\\seeds\\DwfwSeeder',
        ]);
    }

    /** @test */
    function it_logs_updated_setting()
    {
        $setting = Setting::first();
        $setting->name = 'Foo Bar';
        $setting->save();
        $logs = Log::query()
            ->where([
                'event' => LOG::E_UPDATED,
                'entity_type' => Log::ET_SETTING,
                'entity_id' => $setting->id,
            ]);
        $this->assertEquals(1, $logs->count());
    }

}