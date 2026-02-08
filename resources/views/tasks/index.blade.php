<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma ToDo List</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
</head>
<body class="light-mode">
<button id="theme-toggle" class="theme-toggle">
    🌙 <span>Mode sombre</span>
</button>

    <div class="container todo-card">

        <h1>Merioud Youcef </h1>

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
                ✅ 
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
<footer class="site-footer">
    <p>
        © {{ date('Y') }} — <strong>Ma ToDo List</strong>  
        <span class="separator">|</span>
        Projet DevOps — Youcef Merioud
    </p>
</footer>

<script>
    const toggle = document.getElementById('theme-toggle');
    const body = document.body;

    // 🔁 RESTAURER LE THÈME AU CHARGEMENT
    const savedTheme = localStorage.getItem('theme');

    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
        body.classList.remove('light-mode');
        toggle.textContent = '☀️ Mode clair';
    }

    // 🌙 TOGGLE DU THÈME
    toggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        body.classList.toggle('light-mode');

        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
            toggle.textContent = '☀️ Mode clair';
        } else {
            localStorage.setItem('theme', 'light');
            toggle.textContent = '🌙 Mode sombre';
        }
    });
</script>
</body>
</html>
