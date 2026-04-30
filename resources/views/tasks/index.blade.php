<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task App</title>
    <!-- Pulling in Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Configuring Tailwind to use your exact CSS variables -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        theme: {
                            card: 'rgba(47, 62, 70, 0.8)', /* --card-bg */
                            text: '#ffe9c9',               /* --text-color */
                            accent: '#A4C4D2',             /* --accent */
                            input: '#1e282d',              /* Pulled from your table headers */
                            border: '#614c41'              /* Pulled from your h2 borders */
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Fallback background gradient to simulate your image/dark mode */
        body {
            background-image: linear-gradient(-45deg, #ABB2AB, #89A9B6);
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="text-theme-text font-sans antialiased min-h-screen flex items-center justify-center p-4">

    <!-- Main Container (Matches your .card class styling) -->
    <div class="bg-theme-card backdrop-blur-sm rounded-xl shadow-[0_4px_15px_rgba(0,0,0,0.3)] w-full max-w-md p-8 relative border border-white/10">
        
        <!-- Header & Logout (Matches your .header-card) -->
        <div class="flex justify-between items-center mb-6 pb-3 border-b-4 border-theme-accent">
            <h1 class="text-2xl font-bold text-white">Task Manager</h1>
            
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="text-sm font-bold text-theme-accent hover:text-theme-text transition-colors">
                    Logout
                </button>
            </form>
        </div>

        <!-- Add Task Form -->
        <form method="POST" action="/tasks" class="mb-6 flex gap-3">
            @csrf
            <input type="text" 
                   name="title" 
                   placeholder="What needs to be done?" 
                   required
                   class="flex-1 bg-theme-input text-theme-text placeholder-gray-400 border-none rounded px-4 py-3 focus:outline-none focus:ring-2 focus:ring-theme-accent transition-shadow">
            
            <!-- Button matches your exact hover transform -->
            <button class="bg-theme-accent hover:bg-theme-text text-[#2f3e46] px-6 py-3 rounded font-bold transition-all transform hover:-translate-y-0.5">
                Add
            </button>
        </form>

        <!-- Task List -->
        <div class="space-y-3">
            @foreach($tasks as $task)
                <div class="flex items-center justify-between bg-black/20 hover:bg-black/30 p-3 rounded-lg border border-white/5 transition-colors">
                    
                    <!-- Left side: Checkbox & Title -->
                    <div class="flex items-center gap-3">
                        <form method="POST" action="/tasks/{{ $task->id }}">
                            @csrf
                            @method('PATCH')
                            <button title="Toggle status" class="flex items-center justify-center w-6 h-6 rounded border transition-colors 
                                {{ $task->is_done ? 'bg-theme-accent border-theme-accent text-[#2f3e46]' : 'border-theme-accent text-transparent hover:bg-theme-accent/20' }}">
                                <!-- Checkmark Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>

                        <span class="{{ $task->is_done ? 'line-through text-gray-500' : 'text-theme-text font-medium' }}">
                            {{ $task->title }}
                        </span>
                    </div>

                    <!-- Right side: Delete Button -->
                    <form method="POST" action="/tasks/{{ $task->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-theme-accent opacity-70 hover:opacity-100 hover:text-red-400 p-1 rounded-md transition-colors" title="Delete task">
                            <!-- Trash Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            @endforeach
            
            <!-- Empty State -->
            @if(count($tasks) === 0)
                <p class="text-center text-theme-accent opacity-60 text-sm py-4">No tasks yet. You're all caught up!</p>
            @endif
        </div>

    </div>
</body>
</html>