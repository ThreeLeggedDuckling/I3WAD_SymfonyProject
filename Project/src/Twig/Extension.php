<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use App\Entity\Group;
use App\Entity\User;
use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters():array
    {
        return [
            new TwigFilter('wrap', [$this, 'textWrap']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('common', [$this, 'commonGroups']),
            new TwigFunction('timeAgo', [$this, 'timeAgo']),
        ];
    }

    public function commonGroups(User $user1, User $user2):array
    {
        $common = [];
        foreach($user1->getGroups() as $group){
            if($user2->getGroups()->contains($group)){
                $common[] = $group;
            }
        }

        return $common;
    }

    public function textWrap(string $text, int $size = 35):string
    {
        if(strlen($text) > $size){
            return substr($text, 0, $size) . ' ...';
        } else {
            return $text;
        }
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
        
        foreach($units as $key => $unit){
            if($timeDiff[$key]){
                return [
                    'value' => $timeDiff[$key],
                    'unit' => $key,
                    'text' => "{$timeDiff[$key]} {$unit}" . ($timeDiff[$key] > 1 ? 's' : '') . " ago"
                ];
            }
        }
    }
}