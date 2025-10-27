<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma ToDo List</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
</head>
<body class="light-mode">
    <button id="theme-toggle">🌙 Mode sombre</button>

    <div class="container">
        <h1>Ma ToDo List</h1>

        <form action="/tasks" method="POST">
            @csrf
            <input type="text" name="title" placeholder="Nouvelle tâche...">
            <button type="submit">Ajouter</button>
        </form>

        <ul>
            @foreach ($tasks as $task)
    <li class="task-item">
        <form action="/tasks/{{ $task->id }}/toggle" method="POST" style="display: flex; align-items: center; gap: 10px;">
            @csrf
            @method('PUT')
            <button type="submit" style="background: #28a745; border: none; padding: 6px 10px; border-radius: 6px; color: white; font-weight: bold; cursor: pointer;">
                ✅ C’est fait
            </button>
            <span style="flex: 1; {{ $task->completed ? 'text-decoration: line-through; color: gray;' : '' }}">
                {{ $task->title }}
            </span>
        </form>
        <form action="/tasks/{{ $task->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Supprimer</button>
        </form>
    </li>
@endforeach
   
        </ul>
    </div>

    <footer>
        <p>Créé avec ❤️ par Youcef Merioud</p>
    </footer>

    <script>
        const toggle = document.getElementById('theme-toggle');
        const body = document.body;

        toggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            body.classList.toggle('light-mode');

            if (body.classList.contains('dark-mode')) {
                toggle.textContent = '☀️ Mode clair';
            } else {
                toggle.textContent = '🌙 Mode sombre';
            }
        });
    </script>
</body>
</html>
