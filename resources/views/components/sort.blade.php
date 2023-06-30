@if ($sortField !== $field)
<span class=" flex-col">
  <i class="bi bi-caret-up-fill"></i>
<i class="bi bi-caret-down-fill"></i>
</span>
@elseif($sortAsc)
<i class="bi bi-caret-up-fill"></i>
@else
<i class="bi bi-caret-down-fill"></i>
@endif

