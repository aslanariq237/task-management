<!DOCTYPE html>
<html>
<head>
    <title>Work Report - {{ $task?->name ?? 'Task Report' }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #111827;
            color: #e5e7eb;
            margin: 0;
            padding: 40px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
        }
        h1 {
            color: #60a5fa;
            margin: 0 0 8px 0;
            font-size: 28px;
        }
        .subtitle {
            color: #9ca3af;
            font-size: 14px;
        }
        .section {
            margin-bottom: 35px;
        }
        .section-title {
            color: #60a5fa;
            font-size: 16px;
            margin-bottom: 12px;
            border-bottom: 1px solid #374151;
            padding-bottom: 8px;
        }
        .label {
            color: #9ca3af;
            font-size: 13px;
            margin-bottom: 4px;
        }
        .value {
            color: #e5e7eb;
            font-size: 15px;
            margin-bottom: 15px;
        }
        .divider {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, #4b5563, transparent);
            margin: 25px 0;
        }
        .documentation {
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }
        .doc-item {
            text-align: center;
            flex: 1;
        }
        .doc-item img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #374151;
        }
        .doc-label {
            margin-top: 8px;
            color: #60a5fa;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>WORK REPORT</h1>
        <p class="subtitle">TaskFlow Management System</p>
        <p style="color:#9ca3af; font-size:13px;">{{ now()->format('d F Y H:i') }}</p>
    </div>

    <!-- Task Information -->
    <div class="section">
        <div class="section-title">Task Information</div>
        <div class="label">Project</div>
        <div class="value">{{ $task->project->name ?? '-' }}</div>
        
        <div class="label">Task</div>
        <div class="value"><strong>{{ $task->name }}</strong></div>
        
        <div class="label">Staff</div>
        <div class="value">{{ $task->employee->name ?? '-' }}</div>
    </div>

    <hr class="divider">

    <!-- Company Info -->
    <div class="section">
        <div class="section-title">Company</div>
        <div class="value">{{ $task->client ?? '-' }}</div>

        <div class="section-title">Address</div>
        <div class="value">{{ $task->address ?? '-' }}</div>

        <div class="section-title">Task Type</div>
        <div class="value">{{ ucfirst($task->status) }}</div>
    </div>

    <hr class="divider">

    <!-- Work Performed -->
    <div class="section">
        <div class="section-title">Work Performed</div>
        <div class="value" style="white-space: pre-wrap;">
            {{ $task->to_do ?? 'Belum ada data pekerjaan yang dilakukan.' }}
        </div>
    </div>

    <hr class="divider">

    <!-- Notes -->
    <div class="section">
        <div class="section-title">Notes</div>
        <div class="value" style="white-space: pre-wrap;">
            {{ $task->notes ?? 'Tidak ada catatan tambahan.' }}
        </div>
    </div>

    <hr class="divider">

    <!-- Documentation -->
    <div class="section">
        <div class="section-title">Documentation</div>
        
        <div class="documentation">
            <!-- Before -->
            <div class="doc-item">
                <div class="doc-label">Before</div>
                @if($task->images->where('type', 'before')->count() > 0)
                    @foreach($task->images->where('type', 'before') as $doc)
                        <img src="{{ public_path('storage/' . $doc->image_url) }}" alt="Before">
                        @break
                    @endforeach
                @else
                    <div style="height:140px; background:#1f2937; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#6b7280;">
                        📷
                    </div>
                @endif
            </div>

            <!-- During / Progress -->
            <div class="doc-item">
                <div class="doc-label">During</div>
                @if($task->images->where('type', 'progress')->count() > 0)
                    @foreach($task->images->where('type', 'progress') as $doc)
                        <img src="{{ public_path('storage/' . $doc->image_url) }}" alt="During">
                        @break
                    @endforeach
                @else
                    <div style="height:140px; background:#1f2937; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#6b7280;">
                        📷
                    </div>
                @endif
            </div>

            <!-- After -->
            <div class="doc-item">
                <div class="doc-label">After</div>
                @if($task->images->where('type', 'after')->count() > 0)
                    @foreach($task->images->where('type', 'after') as $doc)
                        <img src="{{ public_path('storage/' . $doc->image_url) }}" alt="After">
                        @break
                    @endforeach
                @else
                    <div style="height:140px; background:#1f2937; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#6b7280;">
                        📷
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div style="margin-top:50px; text-align:center; color:#6b7280; font-size:11px;">
        Generated by TaskFlow • {{ now()->format('d F Y H:i') }}
    </div>
</body>
</html>