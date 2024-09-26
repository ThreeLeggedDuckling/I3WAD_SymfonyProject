<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('timeAgo', [$this, 'timeAgo']),
        ];
    }

    public function timeAgo(DateTime $date):array
    {
        $now = new DateTime();

        // convert to array to add week property
        $timeDiff = (array) $now->diff($date);
        $timeDiff['w'] = floor($timeDiff['d']/7);
        $timeDiff['d'] = $timeDiff['d'] % 7;
        
        $units = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second'
        ];
        
        foreach($units as $k => $v){
            if($timeDiff[$k]){
                return [
                    'value' => $timeDiff[$k],
                    'unit' => $k,
                    'text' => "{$timeDiff[$k]} {$v}" . ($timeDiff[$k] > 1 ? 's' : '') . " ago"
                ];
            }
        }
    }
}