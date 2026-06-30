<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-.png" class="" alt="Laravel ">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
