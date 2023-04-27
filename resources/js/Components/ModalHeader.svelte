<script>
    export let title;
</script>

<div class="px-4 py-3 bg-gray-100 flex justify-between gap-16 border-b items-center">
    <h2 class="text-xl font-bold">{title}</h2>

    <div>
        <slot/>
    </div>
</div>