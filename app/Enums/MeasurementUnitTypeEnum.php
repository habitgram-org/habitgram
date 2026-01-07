<?php

declare(strict_types=1);

namespace App\Enums;

enum MeasurementUnitTypeEnum: int
{
    // Distance
    case Meters = 1;
    case Kilometers = 2;

    // Reading
    case Pages = 3;

    // General
    case Times = 4;

    // Exercise - Bodyweight
    case PushUps = 5;
    case PullUps = 6;
    case Squats = 7;
    case Situps = 8;
    case Burpees = 9;
    case Planks = 10; // seconds

    // Exercise - Weight Training
    case Reps = 11;
    case Sets = 12;

    // Wellness
    case Steps = 13;
    case Calories = 14;
    case Glasses = 15; // water

    // Time-based
    case Minutes = 16;
    case Hours = 17;

    // Productivity
    case Tasks = 18;
    case Words = 19;
    case Lines = 20; // code
}
