<table>
    <thead>
        <tr>
            <th>Kolom 1</th>
            <th>Kolom 2</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item->email }}</td>
                <td>{{ $item->password }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
