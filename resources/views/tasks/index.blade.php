<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo App</title>
</head>
<body>
    <h1>ToDo リスト</h1>
    <form action="/tasks" method="POST">
        @csrf
        <input type="text" name="title">
        <button type="submit">追加</button>
    </form>

    <ul>
        @foreach ($tasks as $task)
            <li>
               <form action="/tasks/{{ $task->id }}" method="POST" style="display: inline">
                    @csrf
                    @method('PATCH')
                    <input type="checkbox" name="is_done" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}> 
                </form>
                {{ $task->title }}
                <form action="/tasks/{{ $task->id }}" method="POST" style="display: inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
            </li>
        @endforeach
    </ul>
    
</body>
</html>