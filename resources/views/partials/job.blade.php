<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="10%">Key</th>
        <th>Value</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>UUID</th>
        <td>{{ $payload['uuid'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Name</th>
        <td>{{ $payload['displayName'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Job</th>
        <td>{{ $payload['job'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Max Tries</th>
        <td>{{ $payload['maxTries'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Max Exception</th>
        <td>{{ $payload['maxExceptions'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Fail On Timeout</th>
        <td>{{ $payload['failOnTimeout'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Backoff</th>
        <td>{{ $payload['failOnTimeout'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Timeout</th>
        <td>{{ $payload['timeout'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Retry Unit</th>
        <td>{{ $payload['retryUntil'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Command Name</th>
        <td>{{ $payload['data']['commandName'] ?? '' }}</td>
    </tr>
    <tr>
        <th>Command</th>
        <td><pre>{{  json_encode(unserialize($payload['data']['command']), JSON_PRETTY_PRINT)  }}</pre>
        </td>
    </tr>
    </tbody>
</table>
