<table width="100%" border="1">
    <tr>
        <td>ID</td>
        <td>dateCreate</td>
        <td>apikey</td>
        <td>group</td>
    </tr>
    {% for users in data %}
        <tr>
            <td>{{ data.id }}</td>
            <td>{{ data.dateCreate }}</td>
            <td>{{ data.apikey }}</td>
            <td>{{ data.group }}</td>
        </tr>
    {% endfor }
</table>