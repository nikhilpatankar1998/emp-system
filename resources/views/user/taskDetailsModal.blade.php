<p><strong>ID:</strong> {{ $task->id }}</p>
<p><strong>Project Name:</strong> {{ $task->project_name }}</p>
<p><strong>Title:</strong> {{ $task->title }}</p>
<p><strong>Description:</strong> {{ $task->description }}</p>
<p><strong>Status:</strong> {{ $task->status ?? 'Not Added' }}</p>
<p><strong>Work Time:</strong> {{ $task->time_taken ?? 'Not Added' }}</p>
<p><strong>Description by me:</strong> {{ $task->descriptionbyuser ?? 'not added' }}</p>