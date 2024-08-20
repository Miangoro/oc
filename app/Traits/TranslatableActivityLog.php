<?php
namespace App\Traits;

use Spatie\Activitylog\LogOptions;

trait TranslatableActivityLog
{
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName($this->getLogName())
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => $this->getEventDescription($eventName));
    }

    private function getEventDescription(string $eventName): string
    {
        $eventTranslations = [
            'created' => 'creó',
            'updated' => 'actualizó',
            'deleted' => 'eliminó',
            // Agrega más eventos según sea necesario
        ];

        $action = $eventTranslations[$eventName] ?? $eventName; // Usar la traducción o el nombre original
        return "El usuario " . auth()->user()->name . " {$action} un registro de " . $this->getLogName2() . " el " . now()->format('d/m/Y');
    }

    protected function getLogName(): string
    {
        return strtolower(class_basename($this));
    }
}
