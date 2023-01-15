<?php
return [
    'big_project_status' => [
        'all' => "All",
        'pending' => "Pending",
        'inprogress' => "Inprogress",
        'completed' => "Completed",
        'notyetstarted' => "Not yet started",
        'overdue' => "Over Due",
        'cancelled' => "Cancelled",
    ],
    'project_status' => [
        'all' => "All",
        'pending' => "Pending",
        'inprogress' => "Inprogress",
        'completed' => "Completed",
        'notyetstarted' => "Not yet started",
        'overdue' => "Over Due",
        'cancelled' => "Cancelled",
    ],
    'task_status' => [
        'all' => 'All',
        'pending' => 'pending',
        'inprogress' => 'Progress',
        'completed' => 'Completed',
        'notyetstarted' => "Not yet started",
        'overdue' => "Over Due",
        'cancelled' => "Cancelled",
    ],
    'sub_task_status' => [
        'all' => 'All',
        'pending' => 'pending',
        'inprogress' => 'Progress',
        'completed' => 'Completed',
        'notyetstarted' => "Not yet started",
        'overdue' => "Over Due",
        'cancelled' => "Cancelled",
    ],
    'sign' => ',',
    'status_color' => [
        'all' => "light",
        'pending' => 'secondary',
        'inprogress' => 'success',
        'completed' => 'primary',
        'notyetstarted' => 'dark',
        'overdue' => 'warning',
        'cancelled' => 'danger',
    ],
    'dates' => [
        'all' => 'All',
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'last7days' => 'Last 7 Days',
        'last30days' => 'Last 30 Days',
        'thismonth' => 'This Month',
        'lastyear' => 'Last Year'
    ],
    'cnt_per_big_project_page' => 12,
    'server_key' => env('FIREBASE_SERVER_KEY'),
    'kpi_types' => [
        '1' => 'Actual',
        '2' => 'Target',
//        '3' => 'Actual Cumulative',
//        '4' => 'Target Cumulative'
    ]

];
