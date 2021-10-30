<x-dashboard-tile :position="$position">
    <div class="title">Wetter</div>
    <div class="content mt-2 weather"></div>
</x-dashboard-tile>
<script>
    Weather.get('.weather');
</script>
