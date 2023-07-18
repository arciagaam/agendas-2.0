<?php

function getTimetableCount($classSchedule) : int {
    return $classSchedule->max('timetable') ?? 0;
}

function filterClassSchedule($classSchedule, int $timetableNumber) {
    return $classSchedule->filter(function ($value) use ($timetableNumber) {
        return $value->timetable == $timetableNumber;
    });
}

function getTimetableDays($classSchedule, int $timetableNumber) : array {
    $_DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    $filteredClassSchedule = filterClassSchedule($classSchedule, $timetableNumber);

    $days = $filteredClassSchedule->map(function ($value) {
        return $value->day_id;
    });

    $returnDays = array();

    foreach($days->unique() as $day) {
        $pushedDays = (object) ['id' => $day, 'day' => $_DAYS[$day-1]];
        array_push($returnDays, $pushedDays);
    }
    
    return $returnDays;
}

function getTimetableRowColCount($classSchedule, int $timetableNumber) : array {
    $filteredClassSchedule = filterClassSchedule($classSchedule, $timetableNumber);

    return ['row' => $filteredClassSchedule->max('period_slot'), 'col' => getTimetableDays($classSchedule, $timetableNumber)];
}

function getCellData($classSchedule, int $timetableNumber, int $row, int $day_id) {
    $filteredClassSchedule = filterClassSchedule($classSchedule, $timetableNumber);

    $cellData = array();
    foreach($filteredClassSchedule as $value) {
        if($value->period_slot == $row && $value->day_id == $day_id) {
            array_push($cellData, $value);
        }
    }

    return $cellData[0] ?? null;

}