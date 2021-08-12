<?php
if (isset($data)){
    $system = $data['resource'][0];
    $uptime = $system['uptime'];
    $cpu_cores = $system['cpu-count'];
    $cpuLoad = $system['cpu-load'];

    $total_memory = $system['total-memory'];
    $free_memory = $system['free-memory'];
    $total_memory_formated = formatBytes($total_memory);
    $free_memory_formated = formatBytes($free_memory);
    $freeMP = ($free_memory/$total_memory) * 100;
    $freeMP = round($freeMP,2);
    $usedMP = 100 - $freeMP;

    $freeHDD = $system['free-hdd-space'];
    $totalHDD = $system['total-hdd-space'];
    $freeHDDFormated = formatBytes($freeHDD);
    $totalHDDFormated = formatBytes($totalHDD);
    $freeHDDPercent = ($freeHDD/$totalHDD) * 100;
    $freeHDDPercent = round($freeHDDPercent,2);
    $usedHDDPercent = 100 - $freeHDDPercent;

    $health = $data['health'][0];
    $voltage = $health['voltage'];
    $temperature = $health['temperature'];
}

function formatBytes($size, $precision = 2){
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}
?>
<div class="col-lg-6 col-md-6 col-sm-12">
    <div class="panel-heading dropup">
        <i class="fa fa-server fa-fw"></i>
        System status
    </div>
    <div class="bs-example" data-example-id="simple-list-group">
        <ul class="list-group">
            <li class="list-group-item">CPU Cores <div>{{@$cpu_cores}}</div></li>
            <li class="list-group-item">Uptime<div id="dashboard_status_load_average" style="">{{@$uptime}}</div></li>
            <li class="list-group-item">CPU usage
                <div class="progressBarHolder">
                    <div class="progress progress-free" id="dashboard_status_cpu_usage_progress">
                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" style="width:{{@$cpuLoad}}%;">
                            <span class="progress-value" id="dashboard_status_cpu_usage">{{@$cpuLoad}} %</span>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">Memory: {{@$total_memory_formated}} (Free {{@$freeMP}} %)
                <div class="progressBarHolder">
                    <div class="progress" id="dashboard_status_memory_progress">
                        <div class="progress-bar progress-bar-warning progress-bar-striped" title="2.62 GB" role="progressbar" style="width: {{@$usedMP}}%;">
                            Used
                        </div>
                        <div class="progress-bar progress-bar-success progress-bar-striped" title="1.22 GB" role="progressbar" style="width: {{@$freeMP}}%;">
                            Free
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">I/O Wait
                <div class="progressBarHolder">
                    <div class="progress progress-free" id="dashboard_status_iowait_progress">
                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" style="width: 0%;">
                            <span class="progress-value" id="dashboard_status_iowait">0.00 %</span>
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">Disk: {{@$totalHDDFormated}} (Free {{@$freeHDDPercent}} %)
                <div class="progressBarHolder">
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" style="width:{{@$usedHDDPercent}}%">
                            Used
                        </div>
                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="width:{{@$freeHDDPercent}}%">
                            Free
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">Last DB backup
                <div><time class="timeago" datetime="2021-08-12T20:00:00+02:00" title="2021-08-12 20:00:00">about 2 hours ago</time>  (128.99 KB)</div>
            </li>
            <li class="list-group-item">Last Remote Backup
                <div style=" color:red;font-weight: bold; ">
                    <time onclick="open_dialog_new('dashboard--backup-status')" class="timeago" datetime="" title="Never">Never</time>
                </div>
            </li>
        </ul>
    </div>
</div>
