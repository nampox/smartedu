<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Log Viewer - SmartEdu</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="bi bi-journal-text"></i> SmartEdu Log Viewer
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/">
                    <i class="bi bi-house"></i> Home
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0">
                    <i class="bi bi-list-ul"></i> Laravel Logs
                </h1>
                <p class="text-muted">View and analyze application logs</p>
            </div>
            <div class="col-md-6 text-end">
                <form method="GET" action="{{ route('logs.index') }}" class="d-flex gap-2 justify-content-end">
                    <div class="input-group" style="max-width: 150px;">
                        <label class="input-group-text" for="date">
                            <i class="bi bi-calendar"></i>
                        </label>
                        <select class="form-select" name="date" id="date">
                            @foreach($availableDates as $availableDate)
                                <option value="{{ $availableDate }}" {{ $date == $availableDate ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($availableDate)->format('M d, Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="input-group" style="max-width: 120px;">
                        <label class="input-group-text" for="level">
                            <i class="bi bi-funnel"></i>
                        </label>
                        <select class="form-select" name="level" id="level">
                            <option value="">All Levels</option>
                            <option value="ERROR" {{ $level == 'ERROR' ? 'selected' : '' }}>Error</option>
                            <option value="WARNING" {{ $level == 'WARNING' ? 'selected' : '' }}>Warning</option>
                            <option value="INFO" {{ $level == 'INFO' ? 'selected' : '' }}>Info</option>
                            <option value="DEBUG" {{ $level == 'DEBUG' ? 'selected' : '' }}>Debug</option>
                        </select>
                    </div>
                    
                    <div class="input-group" style="max-width: 200px;">
                        <input type="text" class="form-control" name="search" id="search" 
                               placeholder="Search logs..." value="{{ $search }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Errors</h6>
                                <h3 class="mb-0">{{ collect($logs)->where('level', 'ERROR')->count() }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-exclamation-triangle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Warnings</h6>
                                <h3 class="mb-0">{{ collect($logs)->where('level', 'WARNING')->count() }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-exclamation-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Info</h6>
                                <h3 class="mb-0">{{ collect($logs)->where('level', 'INFO')->count() }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-info-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-secondary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total</h6>
                                <h3 class="mb-0">{{ count($logs) }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-list-ul fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Log Entries -->
        @if(count($logs) > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clock"></i> Log Entries for {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($logs as $log)
                        @if($log)
                            <div class="border-start border-4 border-{{ $log['level_class'] }} p-3 mb-3 bg-light">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge bg-{{ $log['level_class'] }}">
                                                {{ $log['level'] }}
                                            </span>
                                            <span class="badge bg-secondary">{{ $log['channel'] }}</span>
                                            <small class="text-muted">{{ $log['timestamp'] }}</small>
                                        </div>
                                        <div class="font-monospace">{{ $log['message'] }}</div>
                                        
                                        @if(!empty($log['context']))
                                            <div class="mt-2 p-2 bg-info text-white rounded">
                                                <h6 class="mb-2"><i class="bi bi-info-circle"></i> Context</h6>
                                                <small class="font-monospace">
                                                    @if(isset($log['context']['exception']))
                                                        <strong>Exception:</strong> {{ $log['context']['exception'] }}<br>
                                                    @endif
                                                    @if(isset($log['context']['file']))
                                                        <strong>File:</strong> {{ $log['context']['file'] }}<br>
                                                    @endif
                                                    @if(isset($log['context']['line']))
                                                        <strong>Line:</strong> {{ $log['context']['line'] }}<br>
                                                    @endif
                                                    @if(isset($log['context']['trace']))
                                                        <strong>Trace:</strong><br>
                                                        @foreach(array_slice($log['context']['trace'], 0, 5) as $trace)
                                                            {{ $trace }}<br>
                                                        @endforeach
                                                    @endif
                                                </small>
                                            </div>
                                        @endif
                                        
                                        @if(!empty($log['stack_trace']))
                                            <div class="mt-2 p-2 bg-dark text-light rounded">
                                                <h6 class="mb-2"><i class="bi bi-list-ul"></i> Stack Trace</h6>
                                                <small class="font-monospace">
                                                    @foreach(array_slice($log['stack_trace'], 0, 10) as $trace)
                                                        {{ $trace }}<br>
                                                    @endforeach
                                                    @if(count($log['stack_trace']) > 10)
                                                        <em>... and {{ count($log['stack_trace']) - 10 }} more lines</em>
                                                    @endif
                                                </small>
                                            </div>
                                        @endif
                                        
                                        @if(empty($log['context']) && empty($log['stack_trace']) && !empty($log['additional_lines']))
                                            <div class="mt-2 p-2 bg-secondary text-light rounded">
                                                <small class="font-monospace">
                                                    @foreach($log['additional_lines'] as $line)
                                                        @if(!empty(trim($line)))
                                                            {{ $line }}<br>
                                                        @endif
                                                    @endforeach
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No logs found for {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</h5>
                    <p class="text-muted">There are no log entries for the selected date.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 