<?php

namespace App\Nova\Metrics;

use App\Models\Device;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class DevicePerDay extends Trend
{
    public $name = 'Device Per Hari';
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $device = Device::query();

        if ($area = $request->user()['area']) {
            $device->where('last_known_area', 'like', "%$area%");
        }

        return $this->countByDays($request, $device);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            7 => '1 Minggu',
            14 => '2 Minggu',
            30 => '1 Bulan',
            60 => '2 Bulan',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'device-per-day';
    }
}
