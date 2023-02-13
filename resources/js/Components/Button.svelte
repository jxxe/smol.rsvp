<script>
    export let primary = false;
    export let href;
    export let action;

    let className = $$props.class ?? '';
    className += ' border rounded-lg px-4 py-2 shadow-sm ';

    if(primary) {
        className += 'bg-blue-500 text-white border-blue-500 ';
    } else {
        className += 'hover:bg-gray-50 transition-colors cursor-pointer px-6 ';
    }
</script>

{#if href}
    <a {href} class={className}>
        <slot/>
    </a>
{:else}
    <button class={className} on:click={action}>
        <slot/>
    </button>
{/if}